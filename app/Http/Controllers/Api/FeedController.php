<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    // ===========================
    // HOME FEED
    // ===========================

    public function home(Request $request)
{
    $perPage = $request->get('per_page', 1);

    $videos = Video::with([
        'user.profile'
    ])
        ->where('is_public', true)
        ->latest()
        ->paginate($perPage);

    return response()->json([
        'success' => true,

        'videos' => $videos->items(),

        'pagination' => [
            'current_page' => $videos->currentPage(),
            'last_page' => $videos->lastPage(),
            'per_page' => $videos->perPage(),
            'total' => $videos->total(),
            'has_more' => $videos->hasMorePages(),
        ]
    ]);
}
    // ===========================
    // TRENDING
    // ===========================

    public function trending()
  {
       $videos = Video::with([
           'user.profile'
       ])
         ->orderByDesc('views')
         ->take(10)
         ->get();

        return response()->json([
           'success' => true,
           'videos' => $videos,
       ]);
  }
}