<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\User;
use App\Services\BarangService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class BarangServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_success(): void
    {
        $user = User::factory()->create();

        $service = new BarangService;
        $service->create('test barang', 1000, $user);

        $this->assertDatabaseHas('barangs', [
            'nama' => 'test barang',
            'harga' => 1000,
            'created_by' => $user->id,
            'updated_by' => $user->id
        ]);
    }

    public function test_create_failed(): void
    {
        $this->instance(Barang::class,
            Mockery::mock(Barang::class, function(MockInterface $mock) {
                $mock->shouldReceive('create')->andThrow(new \Exception('some error'));
            })
        );

        $user = User::factory()->create();

        $this->assertThrows(function() {
            $service = new BarangService;
            $service->create('test barang', 1000, $user);
        }, \Exception::class);
    }
}
