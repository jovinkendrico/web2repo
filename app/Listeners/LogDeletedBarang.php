<?php

namespace App\Listeners;

use App\Events\BarangDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogDeletedBarang
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
        Log::info("Barang Deleted: {$event->barang->nama} => {$event->barang->harga}");
    }
}
