<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use App\Models\Thumbnail;

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

        $response = Http::get($thumbnailUrl);

        if ($response->successful()) {
            $fileContents = $response->body();
            $fileName = basename($thumbnailUrl);
            $fileNameNew = 'bgr_' . basename($thumbnailUrl);

            // Send the file to the external API
            $apiResponse = Http::attach(
                'thumbnail', $fileContents, $fileName
            )->post(config('app.bg_worker_endpoint'));

            if ($apiResponse->successful()) {
                // Retrieve the file contents from the response
                $processedImageContents = $apiResponse->body();

                // Generate a unique filename for the processed image
                $processedFileName = $request->user()->id . '/' . $fileNameNew;

                // Save the processed image directly to S3
                Storage::put($processedFileName, $processedImageContents, 'public');

                $request->user()->thumbnails()->create([
                    'name' => $fileNameNew
                ]);

                return redirect(route('dashboard'))->with('status', 'background-removed');

            }

            return redirect(route('dashboard'))->with('error', 'failed-to-download-thumbnail');

        }

        return redirect(route('dashboard'))->with('error', 'failed-to-download-thumbnail');
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