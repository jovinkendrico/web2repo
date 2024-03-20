<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\User;

interface BarangServiceInterface {
    function create(string $nama, int $harga, User $actor): Barang;
}
