<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BarangManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_create_a_barang(): void
    {
        $superadmin = User::factory()->superadmin()->create();

        $response = $this->actingAs($superadmin)->post(route('barangs.store'), [
            'kode_barang' => 'BRG100',
            'nama_barang' => 'Keyboard Mechanical',
            'harga' => 150000,
            'stok' => 5,
        ]);

        $response->assertRedirect(route('barangs.index'));
        $this->assertDatabaseHas('barangs', [
            'kode_barang' => 'BRG100',
            'nama_barang' => 'Keyboard Mechanical',
        ]);
    }

    public function test_superadmin_can_update_and_delete_a_barang(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $barang = Barang::create([
            'kode_barang' => 'BRG101',
            'nama_barang' => 'Mouse Wireless',
            'harga' => 75000,
            'stok' => 10,
        ]);

        $this->actingAs($superadmin)->get(route('barangs.edit', $barang))->assertOk();

        $this->actingAs($superadmin)
            ->put(route('barangs.update', $barang), [
                'kode_barang' => 'BRG101',
                'nama_barang' => 'Mouse Wireless Pro',
                'harga' => 85000,
                'stok' => 8,
            ])
            ->assertRedirect(route('barangs.index'));

        $this->assertDatabaseHas('barangs', [
            'id' => $barang->id,
            'nama_barang' => 'Mouse Wireless Pro',
            'harga' => 85000,
        ]);

        $this->actingAs($superadmin)
            ->delete(route('barangs.destroy', $barang))
            ->assertRedirect(route('barangs.index'));

        $this->assertDatabaseMissing('barangs', ['id' => $barang->id]);
    }

    public function test_barang_creation_requires_valid_data(): void
    {
        $superadmin = User::factory()->superadmin()->create();

        $this->actingAs($superadmin)
            ->post(route('barangs.store'), [
                'kode_barang' => '',
                'nama_barang' => '',
                'harga' => -1,
                'stok' => -1,
            ])
            ->assertSessionHasErrors(['kode_barang', 'nama_barang', 'harga', 'stok']);

        $this->assertDatabaseCount('barangs', 0);
    }

    public function test_karyawan_can_not_manage_barangs(): void
    {
        $karyawan = User::factory()->karyawan()->create();

        $this->actingAs($karyawan)
            ->post(route('barangs.store'), [
                'kode_barang' => 'BRG102',
                'nama_barang' => 'Barang Baru',
                'harga' => 10000,
                'stok' => 1,
            ])
            ->assertForbidden();

        $this->assertDatabaseCount('barangs', 0);
    }
}
