<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
}