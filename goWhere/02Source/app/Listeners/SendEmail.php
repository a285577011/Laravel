<?php

namespace App\Listeners;

use App\Events\EmailNeedToBeSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;

class SendEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmailNeedToBeSent  $event
     * @return void
     */
    public function handle(EmailNeedToBeSent $event)
    {
        Mail::send($event->view, $event->content, function ($message) use($event) {
            if($event->sender) {
                $message->from($event->sender['address'], $event->sender['name']);
            }
            $message->to($event->to);
            $message->subject($event->subject);
        });
    }

    /**
     * push到指定queue = email
     */
    public function queue($queue, $job, $data)
    {
        $queue->push($job, $data, 'email');
    }

}
