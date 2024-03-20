<?php

namespace App\Jobs;

use App\Models\Barang;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

// Consumer
class BarangProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     * menampung data yang akan di kirim ke job
     */
    public function __construct(public int $barangId) // parameter terhadap __construct
        // adalah payload dari job
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $barang = Barang::find($this->barangId);
        Log::info("START PROCESSING JOB BARANG: {$barang->id}");
        sleep(30); // simulate slow process
        Log::info("FINISHED PROCESSING JOB BARANG: {$barang->id}");
        // self::dispatch($barang->id); NOTE: menyambung pekerjaan dengan mengantri ulang untuk
        // diproses pada next job
    }
}
