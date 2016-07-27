<?php

namespace App\Events;

use App\Events;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmailNeedToBeSent extends Event
{
    use SerializesModels;
    
    public $to; //收件人
    public $view; //邮件模版
    public $content; //模版变量
    public $subject; //邮件主题
    public $sender; //发件人

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($to, $view, $subject, $content, $sender=null)
    {
        $this->to = $to;
        $this->view = $view;
        $this->subject = $subject;
        $this->content = $content;
        $this->sender = is_null($sender) ? config('mail.from') : $sender;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
