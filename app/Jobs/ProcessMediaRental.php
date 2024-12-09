<?php

namespace App\Jobs;

use App\Models\Media;
use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ProcessMediaRental implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $clientId;
    protected $mediaId;

    /**
     * Create a new job instance.
     */
    public function __construct($clientId, $mediaId)
    {
        $this->clientId = $clientId;
        $this->mediaId = $mediaId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $media = Media::find($this->mediaId);

        if (!$media->availability) {
            return;
        }

        Rental::create([
            'client_id' => $this->clientId,
            'media_id' => $this->mediaId,
            'rented_at' => Carbon::now(),
        ]);

        $media->update(['availability' => false]);
        $webhookUrl = env('WEBHOOK_JOB_COMPLETED_URL');
        if (!$webhookUrl) {
            throw new \Exception('Webhook URL is not configured');
        }
        Http::post($webhookUrl, [
            'status' => 'success',
            'job' => 'ProcessMediaRental',
            'client_id' => $this->clientId,
            'media_id' => $this->mediaId,
            'rented_at' => $rental->rented_at,
        ]);
    }
}

