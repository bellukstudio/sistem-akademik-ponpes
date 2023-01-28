<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\MasterNews;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class BeritaController extends Controller
{
    public function getAllNews()
    {
        try {
            $data = MasterNews::latest()->get();
            return ApiResponse::success([
                'berita' => $data
            ], 'Get News Successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Authentication failed', 500);
        }
    }
}
