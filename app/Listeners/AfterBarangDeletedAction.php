<?php

namespace App\Listeners;

use App\Events\BarangDeleted;
use App\Jobs\BarangProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class AfterBarangDeletedAction
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
    public function handle(BarangDeleted $event): void
    {
        //
        Log::info("dispatch process barang job for {$event->barang->nama}");
        BarangProcessor::dispatch($event->barang->id);
    }
}
