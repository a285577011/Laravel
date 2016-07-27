<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UploadsChanged extends Event
{
    use SerializesModels;
    
    public $oldfile;
    public $newfile;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($oldfile, $newfile)
    {
        $this->oldfile = $oldfile;
        $this->newfile = $newfile;
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
