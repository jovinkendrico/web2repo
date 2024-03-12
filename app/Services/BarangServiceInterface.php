<?php

namespace App\Services;

use App\Models\User;

interface BarangServiceInterface {
    function create(string $nama, int $harga, User $actor);
}
