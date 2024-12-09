<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Support\Facades\Queue;

class MediaController extends Controller
{
    public function index()
    {
        return MediaResource::collection(Media::all());
    }

    public function store(StoreMediaRequest $request)
    {
        $media = Media::create($request->validated());
        return new MediaResource($media);
    }

    public function show(Media $media)
    {
        return new MediaResource($media);
    }

    public function update(StoreMediaRequest $request, Media $media)
    {
        $media->update($request->validated());
        return new MediaResource($media);
    }
    
    public function destroy(Media $media)
    {
        $media->delete();
        return response()->json(['message' => 'Media deleted successfully.']);
    }
}

