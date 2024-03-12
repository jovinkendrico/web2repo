<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\BarangServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\Mock;
use Mockery\MockInterface;
use Tests\TestCase;

class BarangControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_barang_success(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'web')
                         ->post('/admin/barang/', ['nama' => 'test 1', 'harga' => 1000]);
        $response->assertRedirectToRoute('admin.barang.index');
    }

    public function test_create_barang_failed(): void
    {
        $user = User::factory()->create();

        $this->instance(BarangServiceInterface::class,
            Mockery::mock(BarangServiceInterface::class, function(MockInterface $mock) {
                $mock->shouldReceive('create')->andThrow(new \Exception('some error'));
            })
        );

        $response = $this->actingAs($user, 'web')
                         ->post('/admin/barang/',
            ['nama' => 'test 1', 'harga' => 1000]);
        $response->assertInternalServerError();
    }
}
