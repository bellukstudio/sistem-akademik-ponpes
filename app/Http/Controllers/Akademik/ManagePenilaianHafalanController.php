<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterClass;
use App\Models\MasterStudent;
use App\Models\TrxMemorizeSurah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

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
        $client = new Client();
        $response = $client->get('https://equran.id/api/surat');
        $apiQuran = json_decode($response->getBody()->getContents());
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
        $request->validate([
            'program' => 'required',
            'class' => 'required',
            'surah_name' => 'required|max:100',
            'verseText' => 'sometimes|max:100',
            'verseOption' => 'sometimes'
        ]);

        try {
            $student = MasterStudent::join(
                'trx_class_groups',
                'trx_class_groups.student_id',
                '=',
                'master_students.id'
            )->leftJoin(
                'trx_memorize_surahs',
                function ($join) {
                    $join->on(
                        'trx_memorize_surahs.student_id',
                        '=',
                        'master_students.id'
                    )->where('trx_memorize_surahs.surah', '=', request('surah_name'))
                        ->where('trx_memorize_surahs.verse', '=', request('verseText'))
                        ->orWhere('trx_memorize_surahs.verse', '=', request('verseOption'));
                }

            )->where('trx_class_groups.class_id', $request->class)
                ->select(
                    'master_students.name as student_name',
                    'master_students.id as student_id',
                    'trx_class_groups.class_id as class_id',
                    'trx_memorize_surahs.score as score'
                )->groupBy('master_students.id')->get();

            $program  = MasterAcademicProgram::where('id', $request->program)->firstOrFail();
            $class = MasterClass::where('id', $request->class)->firstOrFail();

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
                'class' => $class->class_name,
                'student' => $student,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function store(Request $request, $student, $class)
    {
        $request->validate([
            'score' => 'required'
        ]);

        try {
            TrxMemorizeSurah::create([
                'student_id' => $student,
                'class_id' => $class,
                'surah' => $request->surah_name,
                'verse' => $request->verse,
                'score' => $request->score,
                'user_id' => Auth::user()->id,
                'date_assesment' => date('Y-m-d'),
            ]);
            return back()->with('success', 'Nilai berhasil di input');
        } catch (\Exception $e) {
            return back()->withErrors($e);
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
}
