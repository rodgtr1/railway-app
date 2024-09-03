<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class RemoveBackground implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $thumbnailUrl;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, string $thumbnailUrl)
    {
        $this->user = $user;
        $this->thumbnailUrl = $thumbnailUrl;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('Starting job to remove background');
        $response = Http::get($this->thumbnailUrl);

        if ($response->successful()) {
            $fileContents = $response->body();
            $fileName = basename($this->thumbnailUrl);
            $fileNameNew = 'bgr_' . $fileName;

            $apiResponse = Http::attach(
                'thumbnail', $fileContents, $fileName
            )->post(config('app.bg_worker_endpoint'));

            if ($apiResponse->successful()) {

                $processedImageContents = $apiResponse->body();

                $processedFileName = $this->user->id . '/' . $fileNameNew;

                Storage::put($processedFileName, $processedImageContents, 'public');

                $this->user->thumbnails()->create([
                    'name' => $fileNameNew
                ]);
            } else {
                Log::error('Failed to process image: ' . $apiResponse->status());
            }

        } else {
            Log::error('Failed to download thumbnail: ' . $this->thumbnailUrl);
        }
    }
}