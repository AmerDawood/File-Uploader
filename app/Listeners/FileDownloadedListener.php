<?php

namespace App\Listeners;

use App\Events\FileDownloaded;
use App\Models\User;
use App\Notifications\FileDownloadedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class FileDownloadedListener
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


        $user = User::find(Auth::id());

if ($user) {
    $user->notify(new FileDownloadedNotification($file));
} else {
    // Error when the user not found
}

    }
}
