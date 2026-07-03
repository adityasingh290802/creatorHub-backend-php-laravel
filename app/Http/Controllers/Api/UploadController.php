<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        
    //dd($request->all(), $request->file('video'));

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimes:mp4,mov,avi,mkv|max:102400',
        ]);

        $videoFile = $request->file('video');

        $videoName = time() . '_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

        $videoPath = $videoFile->storeAs(
            'videos',
            $videoName,
            'public'
        );

        $video = Video::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => Storage::url($videoPath),
            'thumbnail_url' => null,
            'views' => 0,
            'likes' => 0,
            'comments' => 0,
            'is_public' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Video uploaded successfully.',
            'video' => $video->load('user.profile'),
        ], 201);
    }
}