<?php

namespace App\Listeners;

use App\Events\BarangCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogCreatedBarang
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
    public function handle(BarangCreated $event): void
    {
        Log::info("Barang Created: {$event->barang->nama} => {$event->barang->harga}");
    }
}
