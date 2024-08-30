<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Jobs\RemoveBackground;
use App\Models\Thumbnail;
use Illuminate\Support\Facades\Log;

class ThumbnailController extends Controller
{

    public function upload(Request $request): RedirectResponse
    {

        $data = $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
        ]);

        // If there's a profile photo in the request, store it.
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filePath = $request->user()->id.'/'.$file->getClientOriginalName();
            $path = $file->storeAs($filePath);
            $request->user()->thumbnail = $filePath;
        }

        $request->user()->thumbnails()->create([
            'name' => $file->getClientOriginalName(),
        ]);

        return redirect(route('dashboard'))->with('status', 'thumbnail-uploaded');
    }

    public function removeBackground(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'thumbnail_url' => 'required|url',
        ]);

        $thumbnailUrl = $data['thumbnail_url'];

        // Dispatch the job
        Log::info('Dispatching RemoveBackground job for user: ' . $request->user()->id . ' with thumbnail URL: ' . $thumbnailUrl);

        RemoveBackground::dispatch($request->user(), $thumbnailUrl);
        Log::info('Finished dispatching RemoveBackground job for user: ' . $request->user()->id . ' with thumbnail URL: ' . $thumbnailUrl);

        return redirect(route('dashboard'))->with('status', 'background-removal-queued');
    }

    public function destroy(Request $request,Thumbnail $thumbnail)
    {
        // Delete database thumbnail
        $thumbnail->delete();

        // Delete thumbnail from MinIO
        Storage::delete($request->user()->id . '/' . $thumbnail->name);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Thumbnail deleted successfully.');
    }


}