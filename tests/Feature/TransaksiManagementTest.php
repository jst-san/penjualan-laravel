<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_create_a_transaksi_and_decrement_stock(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $barang = Barang::create([
            'kode_barang' => 'BRG001',
            'nama_barang' => 'Mouse Wireless',
            'harga' => 75000,
            'stok' => 10,
        ]);

        $response = $this->actingAs($superadmin)->post(route('transaksis.store'), [
            'tanggal' => now()->format('Y-m-d'),
            'items' => [
                ['barang_id' => $barang->id, 'jumlah' => 3],
            ],
        ]);

        $transaksi = Transaksi::firstOrFail();

        $response->assertRedirect(route('transaksis.show', $transaksi));
        $this->assertDatabaseHas('transaksis', [
            'id' => $transaksi->id,
            'total' => 225000,
        ]);
        $this->assertDatabaseHas('detail_transaksis', [
            'transaksi_id' => $transaksi->id,
            'barang_id' => $barang->id,
            'jumlah' => 3,
            'subtotal' => 225000,
        ]);
        $this->assertSame(7, $barang->fresh()->stok);
    }

    public function test_transaksi_can_not_be_created_when_stock_is_insufficient(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $barang = Barang::create([
            'kode_barang' => 'BRG002',
            'nama_barang' => 'Keyboard Mechanical',
            'harga' => 120000,
            'stok' => 2,
        ]);

        $this->actingAs($superadmin)
            ->post(route('transaksis.store'), [
                'tanggal' => now()->format('Y-m-d'),
                'items' => [
                    ['barang_id' => $barang->id, 'jumlah' => 5],
                ],
            ])
            ->assertSessionHasErrors('items');

        $this->assertDatabaseCount('transaksis', 0);
        $this->assertDatabaseCount('detail_transaksis', 0);
        $this->assertSame(2, $barang->fresh()->stok);
    }

    public function test_karyawan_can_not_create_a_transaksi(): void
    {
        $karyawan = User::factory()->karyawan()->create();
        $barang = Barang::create([
            'kode_barang' => 'BRG003',
            'nama_barang' => 'Flashdisk 32GB',
            'harga' => 65000,
            'stok' => 10,
        ]);

        $this->actingAs($karyawan)
            ->post(route('transaksis.store'), [
                'items' => [
                    ['barang_id' => $barang->id, 'jumlah' => 1],
                ],
            ])
            ->assertForbidden();

        $this->assertDatabaseCount('transaksis', 0);
    }

    public function test_superadmin_can_update_and_delete_a_transaksi(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $transaksi = Transaksi::create([
            'nomor_transaksi' => 'TRX-20260101-001',
            'tanggal' => now()->format('Y-m-d'),
            'total' => 100000,
        ]);

        $this->actingAs($superadmin)->get(route('transaksis.edit', $transaksi))->assertOk();

        $this->actingAs($superadmin)
            ->put(route('transaksis.update', $transaksi), [
                'nomor_transaksi' => 'TRX-20260101-001',
                'tanggal' => now()->format('Y-m-d'),
                'total' => 150000,
            ])
            ->assertRedirect(route('transaksis.show', $transaksi));

        $this->assertDatabaseHas('transaksis', [
            'id' => $transaksi->id,
            'total' => 150000,
        ]);

        $this->actingAs($superadmin)
            ->delete(route('transaksis.destroy', $transaksi))
            ->assertRedirect(route('transaksis.index'));

        $this->assertDatabaseMissing('transaksis', ['id' => $transaksi->id]);
    }
}
