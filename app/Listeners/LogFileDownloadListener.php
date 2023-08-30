<?php

namespace App\Listeners;

use App\Events\FileDownloaded;
use App\Models\DownloadLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogFileDownloadListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    public function handle(FileDownloaded $event)
    {
        $user = $event->user;
        $file = $event->file;
        $request = $event->request;

        // Create a new DownloadLog record
        $downloadLog = new DownloadLog();
        $downloadLog->file_id = $file->id;
        $downloadLog->downloaded_at = now();
        $downloadLog->ip_address = $request->ip();
        $downloadLog->user_agent = $request->userAgent();

        $country = 'test';
        $downloadLog->country = $country;

        $downloadLog->save();

        $file->increment('count_download');

    }
}
