<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterClass;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use App\Models\TrxMemorizeSurah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ManagePenilaianHafalanController extends Controller
{

    /**
     * index controller
     */
    public function index()
    {
        if (Auth::user()->roles_id === 3 || Auth::user()->roles_id === 4) {
            abort(403);
        }
        $program = MasterAcademicProgram::all();
        /**
         * [RETRIEVE DATA FROM API USING LIBRARY GUZZLE]
         */
        try {
            $client = new Client();
            $response = $client->get('https://equran.id/api/surat');
            $apiQuran = json_decode($response->getBody()->getContents());
        } catch (GuzzleException $e) {
            abort(599);
        }
        /**
         * END
         */
        return view(
            'dashboard.akademik.kelola_nilai.hafalan.index',
            compact('program', 'apiQuran')
        );
    }

    /**
     * create function
     * redirect to page create
     */

    public function create(Request $request)
    {
        $request->validate(
            [
                'program' => 'required',
                'class' => 'required',
                'surah_name' => 'required|max:100',
                'verseText' => 'sometimes|max:100',
                'verseOption' => 'sometimes'
            ],
            [
                'program.required' => 'Kolom Program wajib diisi',
                'class.required' => 'Kolom Kelas wajib diisi',
                'surah_name.required' => 'Kolom Nama Surah wajib diisi',
                'surah_name.max' => 'Kolom Nama Surah maksimal :max karakter',
                'verseText.max' => 'Kolom Teks Ayat maksimal :max karakter',
            ]
        );


        try {
            /**
             * [RETRIEVE DATA FROM API USING LIBRARY GUZZLE]
             */
            try {
                $client = new Client();
                $response = $client->get('https://equran.id/api/surat');
                $apiQuran = json_decode($response->getBody()->getContents());
            } catch (GuzzleException $e) {
                abort(599);
            }

            $student = MasterStudent::join(
                'trx_class_groups',
                'trx_class_groups.student_id',
                '=',
                'master_students.id'
            )->join('master_classes', 'master_classes.id', '=', 'trx_class_groups.class_id')
                ->leftJoin(
                    'trx_memorize_surahs',
                    function ($join) {
                        $join->on(
                            'trx_memorize_surahs.student_id',
                            '=',
                            'master_students.id'
                        )
                            ->where('trx_memorize_surahs.surah', '=', request('surah_name'))
                            ->where(function ($q) {
                                $q->where('trx_memorize_surahs.verse', '=', request('verseText'))
                                    ->orWhere('trx_memorize_surahs.verse', '=', request('verseOption'));
                            });
                    }
                )->leftJoin('master_periods', function ($join) {
                    $join->on('master_periods.id', '=', 'trx_memorize_surahs.id_period')
                        ->where('master_periods.status', 1);
                })
                ->where('trx_class_groups.class_id', $request->class)
                ->select(
                    'master_students.name as student_name',
                    'master_students.id as student_id',
                    'trx_class_groups.class_id as class_id',
                    'trx_memorize_surahs.score as score',
                    'trx_memorize_surahs.id as id_memorize',
                    'master_periods.id as period_id'
                )->groupBy('master_students.id')->get();

            $program  = MasterAcademicProgram::where('id', $request->program)->firstOrFail();
            $class = MasterClass::where('id', $request->class)->firstOrFail();
            $programAll = MasterAcademicProgram::all();


            //
            if (!empty(request('verseOption')) && !empty(request('verseText'))) {
                return back()->with('failed', 'Pilih salah satu!, Masukan Ayat Baru Atau Pilih Ayat Yang Sudah Ada');
            }

            if (!empty(request('verseOption'))) {
                $verse = request('verseOption');
            }
            if (!empty(request('verseText'))) {
                $verse = request('verseText');
            }

            return view('dashboard.akademik.kelola_nilai.hafalan.create', [
                'surah' => $request->surah_name,
                'verse' => $verse,
                'program' => $program->program_name,
                'programAll' => $programAll,
                'class' => $class->class_name,
                'student' => $student,
                'apiQuran' => $apiQuran
            ]);
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
    }

    public function store(Request $request, $student, $class)
    {
        $request->validate([
            'score' => 'required'
        ], [
            'score.required' => 'Nilai harus diisi'
        ]);

        try {
            $period = MasterPeriod::where('status', 1)->first();

            TrxMemorizeSurah::create([
                'student_id' => $student,
                'class_id' => $class,
                'surah' => $request->surah_name,
                'verse' => $request->verse,
                'score' => $request->score,
                'user_id' => Auth::user()->id,
                'date_assesment' => date('Y-m-d'),
                'id_period' => $period->id ?? null
            ]);
            return back()->with('success', 'Nilai berhasil di input');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
    }

    /**
     * filter data
     */

    public function getVerseBySurahNamed(Request $request)
    {
        $empData['data']  = TrxMemorizeSurah::where('surah', $request->surah)->select('verse')->groupBy('verse')->get();
        return response()->json($empData);
    }

    public function destroy($id)
    {
        try {
            $data = TrxMemorizeSurah::findOrFail($id);
            $data->delete();
            return back()->with('success', 'Nilai berhasil di hapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
