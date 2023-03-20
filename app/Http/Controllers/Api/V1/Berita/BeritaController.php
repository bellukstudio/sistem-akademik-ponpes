<?php

namespace App\Http\Controllers\Api\V1\Berita;

use App\Http\Controllers\Controller;
use App\Models\MasterNews;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\MasterUsers;
use App\Models\TrxReadNews;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    public function getAllNews()
    {
        try {
            $new = MasterNews::whereNotIn('id', function ($query) {
                $query->select('news_id')->from('trx_read_news')->where('user_id', Auth::user()->id);
            })->select(
                'master_news.id as id',
                'master_news.title as title',
                'master_news.description as desc',
            )->latest()->get();
            $old = TrxReadNews::join('master_news', 'master_news.id', '=', 'trx_read_news.news_id')
                ->select(
                    'master_news.id as id',
                    'master_news.title as title',
                    'master_news.description as desc',
                )
                ->latest('master_news.created_at')
                ->get();

            return ApiResponse::success([
                'old' => $old,
                'new' => $new
            ], 'Get News Successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps server Error', 500);
        }
    }

    public function readNews(Request $request, $news)
    {
        try {
            $user = MasterUsers::find($request->user()->id);
            $newsData = TrxReadNews::where('user_id', $user->id)->where('news_id', $news)->get();
            if (count($newsData) > 0) {
                return ApiResponse::success('You have read this news', 'News is read');
            } else {
                $data = [
                    'user_id' => $user->id,
                    'news_id' => $news
                ];
                TrxReadNews::create($data);
            }
            return ApiResponse::success('Read news success', 'News is read');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps server error', 500);
        }
    }
}
