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
    public function handle(): void
    {
        $response = Http::get($this->thumbnailUrl);

        if ($response->successful()) {
            $fileContents = $response->body();
            $fileName = basename($this->thumbnailUrl);
            $fileNameNew = 'bgr_' . $fileName;

            // Send the file to the external API
            $apiResponse = Http::attach(
                'thumbnail', $fileContents, $fileName
            )->post(config('app.bg_worker_endpoint'));

            if ($apiResponse->successful()) {
                // Retrieve the file contents from the response
                $processedImageContents = $apiResponse->body();

                // Generate a unique filename for the processed image
                $processedFileName = $this->user->id . '/' . $fileNameNew;

                // Save the processed image directly to S3
                Storage::put($processedFileName, $processedImageContents, 'public');

                $this->user->thumbnails()->create([
                    'name' => $fileNameNew
                ]);
            }
        }
    }
}