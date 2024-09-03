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

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filePath = $request->user()->id.'/'.$file->getClientOriginalName();
            $path = $file->storeAs($filePath);
            $request->user()->thumbnail = $filePath;

            $request->user()->thumbnails()->create([
                'name' => $file->getClientOriginalName(),
            ]);
        } else {
            return redirect()->back()->with('error', 'Failed to upload thumbnail.');
        }

        return redirect(route('dashboard'))->with('status', 'thumbnail-uploaded');
    }

    public function removeBackground(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'thumbnail_url' => 'required|url',
        ]);

        $thumbnailUrl = $data['thumbnail_url'];

        RemoveBackground::dispatch($request->user(), $thumbnailUrl);

        return redirect()->back()->with('status', 'background-job-initiated');

    }

    public function destroy(Request $request,Thumbnail $thumbnail)
    {
        $thumbnail->delete();

        Storage::delete($request->user()->id . '/' . $thumbnail->name);

        return redirect()->back()->with('success', 'Thumbnail deleted successfully.');
    }


}