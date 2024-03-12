<?php

namespace App\Services;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BarangService implements BarangServiceInterface
{
    public function create(string $nama, int $harga, User $actor)
    {
        DB::transaction(function() use($nama, $harga, $actor) {
            // mass assign create with validation
            $barang = Barang::create([
                'nama' => $nama,
                'harga' => $harga,
            ]);

            $barang->createdBy()->associate($actor);
            $barang->updatedBy()->associate($actor);
            $barang->save();

            if (!$barang) {
                throw new \Exception('failed to create barang');
            }
        });
    }
}
