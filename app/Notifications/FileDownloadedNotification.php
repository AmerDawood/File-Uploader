<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FileDownloadedNotification extends Notification
{
    use Queueable;


    protected function createMessage(){

        $content = __(':name Posted a new :type :title',[
            'name' => 'test name',
            'type' => 'test type',
            'title' => 'test title',
        ]);

        return [
            'title' => 'test title',
            'body' =>$content,
            'image' => '',
            'link' => '',
        ];
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public  function toBrodcast(object $notifiable) : BroadcastMessage
    {

        return new BroadcastMessage($this->createMessage());

    }
    public function toArray(object $notifiable): array
    {
        return [
            'file_id' => $this->file->id,
            'message' => 'The file ' . $this->file->filename . ' has been downloaded.',
        ];
    }
}
