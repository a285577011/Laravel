<?php

namespace App\Listeners;

use App\Events\UploadsChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

class RemoveOldFile
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
     * @param  OldFileNeedToBeRemoved  $event
     * @return void
     */
    public function handle(UploadsChanged $event)
    {
        if(is_array($event->oldfile)) {
            foreach ($event->oldfile as $k => $o) {
                if (is_array($event->newfile) && isset($event->newfile[$k])) {
                    $this->removeFromStorage($o, $event->newfile[$k]);
                } else {
                    $this->removeFromStorage($o, $event->newfile);
                }
            }
        } else {
            $this->removeFromStorage($event->oldfile, $event->newfile);
        }
    }

    protected function removeFromStorage($oldfile, $newfile)
    {
        if ($oldfile && ($newfile != $oldfile)) {
            try {
                @\Storage::delete($event->oldfile);
            } catch (\Exception $e) {
                // do nothing
            }
        }
    }
}
