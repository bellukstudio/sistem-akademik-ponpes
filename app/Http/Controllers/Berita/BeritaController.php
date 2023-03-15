<?php

namespace App\Http\Controllers\Berita;

use App\Http\Controllers\Controller;
use App\Models\MasterNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Helpers\FcmHelper;
use App\Models\MasterTokenFcm;
use App\Models\MasterUsers;
use App\Models\TrxReadNews;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timeLine = MasterNews::orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        });
        $data = MasterNews::latest()->get();

        //
        $checkReadNews = TrxReadNews::all();
        return view('dashboard.berita.index', [
            "berita" => $data,
            'timeLine' => $timeLine,
            'checkReadNews' => $checkReadNews
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->roles_id != 1) {
            abort(403);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'judul' => ['required', 'string', 'max:50'],
                'keterangan' => ['required', 'string'],
            ],
            [
                'judul.required' => 'Judul tidak boleh kosong',
                'judul.max' => 'Judul tidak boleh lebih dari 50 karakter',
                'keterangan.required' => 'Keterangan tidak boleh kosong'
            ]
        );

        try {
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $data  = MasterNews::create(
                [
                    'id_user' => Auth::user()->id,
                    'title' => $request->judul,
                    'description' => $request->keterangan
                ]
            );

            // send notification

            sleep(1);
            $data['page'] = 'detailNotifPage';
            $checkAvaiableToken = MasterTokenFcm::all();
            if (count($checkAvaiableToken) > 0) {
                $dataFcm = [
                    'data' => $data
                ];
                FcmHelper::sendNotificationWithGuzzle($request->judul, $dataFcm);
            }
            return redirect()->route('beritaAcara.index')
                ->with('success', 'Pengumuman (' . $request->judul . ') berhasil di post');
        } catch (\Exception $e) {
            return back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (auth()->user()->roles_id != 1) {
            abort(403);
        }
        $timeLine = TrxReadNews::with(['announcement', 'user'])->where('news_id', $id)
            ->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });
        $readNews = TrxReadNews::where('news_id', $id)->count();

        return view('dashboard.berita.show', compact('timeLine', 'readNews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (auth()->user()->roles_id != 1) {
            abort(403);
        }
        $data = MasterNews::findOrFail($id);
        return view('dashboard.berita.edit', [
            'berita' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->roles_id != 1) {
            abort(403);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'judul' => ['required', 'string', 'max:50'],
                'keterangan' => ['required', 'string'],
            ],
            [
                'judul.required' => 'Judul tidak boleh kosong',
                'judul.max' => 'Judul tidak boleh lebih dari 50 karakter',
                'keterangan.required' => 'Keterangan tidak boleh kosong'
            ]
        );
        try {
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $berita = MasterNews::findOrFail($id);

            // update data
            $berita->title = $request->judul;
            $berita->description = $request->keterangan;
            $berita->update();

            return redirect()->route('beritaAcara.index')
                ->with('success', 'Pengumuman (' . $request->judul . ') berhasil di update');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal mengubah data');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->roles_id != 1) {
            abort(403);
        }
        try {
            $data = MasterNews::find($id);
            $data->delete();
            return redirect()->route('beritaAcara.index')->with('success', 'Data yang dipilih berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }

    public function readNews(Request $request)
    {
        try {
            $user = MasterUsers::find($request->user()->id);
            $newsData = TrxReadNews::where('user_id', $user->id)->where('news_id', $request->news)->get();
            if (count($newsData) > 0) {
                return response()->json(['message' => 'Sudah menandai terbaca.']);
            } else {
                $data = [
                    'user_id' => $user->id,
                    'news_id' => $request->news
                ];
                TrxReadNews::create($data);
            }
            return response()->json(['message' => 'Berhasil menandai terbaca.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menandai terbaca']);
        }
    }

    /**
     * show data in trash
     */

    public function trash()
    {
        if (auth()->user()->roles_id != 1) {
            abort(403);
        }
        $data = MasterNews::onlyTrashed()->get();
        return view('dashboard.berita.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            if (auth()->user()->roles_id != 1) {
                abort(403);
            }
            $data = MasterNews::onlyTrashed()->where('id', $id);
            $data->restore();
            return redirect()->route('beritaAcara.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
        try {
            if (auth()->user()->roles_id != 1) {
                abort(403);
            }
            $data = MasterNews::onlyTrashed();
            $data->restore();
            return redirect()->route('beritaAcara.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {
        try {
            if (auth()->user()->roles_id != 1) {
                abort(403);
            }
            $data = MasterNews::onlyTrashed()->where('id', $id);
            $data->forceDelete();
            return redirect()->route('trashBeritaAcara')->with('success', 'Data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
        try {
            if (auth()->user()->roles_id != 1) {
                abort(403);
            }
            $data = MasterNews::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashBeritaAcara')->with('success', 'Data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
