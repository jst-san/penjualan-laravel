<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_karyawan_can_access_dashboard_and_transaksi_index(): void
    {
        $karyawan = User::factory()->karyawan()->create();

        $this->actingAs($karyawan)->get(route('dashboard'))->assertOk();
        $this->actingAs($karyawan)->get(route('transaksis.index'))->assertOk();
    }

    public function test_karyawan_can_view_transaksi_detail(): void
    {
        $karyawan = User::factory()->karyawan()->create();
        $barang = Barang::create([
            'kode_barang' => 'BRG001',
            'nama_barang' => 'Mouse Wireless',
            'harga' => 75000,
            'stok' => 10,
        ]);
        $transaksi = Transaksi::create([
            'nomor_transaksi' => 'TRX-20260101-001',
            'tanggal' => now()->format('Y-m-d'),
            'total' => 75000,
        ]);
        $transaksi->detailTransaksis()->create([
            'barang_id' => $barang->id,
            'harga' => 75000,
            'jumlah' => 1,
            'subtotal' => 75000,
        ]);

        $this->actingAs($karyawan)
            ->get(route('transaksis.show', $transaksi))
            ->assertOk()
            ->assertSee('Mouse Wireless');
    }

    public function test_karyawan_can_not_access_superadmin_routes(): void
    {
        $karyawan = User::factory()->karyawan()->create();

        $this->actingAs($karyawan)->get(route('users.index'))->assertForbidden();
        $this->actingAs($karyawan)->get(route('users.create'))->assertForbidden();
        $this->actingAs($karyawan)->get(route('barangs.index'))->assertForbidden();
        $this->actingAs($karyawan)->get(route('barangs.create'))->assertForbidden();
        $this->actingAs($karyawan)->get(route('transaksis.create'))->assertForbidden();
    }

    public function test_superadmin_can_access_all_routes(): void
    {
        $superadmin = User::factory()->superadmin()->create();

        $this->actingAs($superadmin)->get(route('dashboard'))->assertOk();
        $this->actingAs($superadmin)->get(route('users.index'))->assertOk();
        $this->actingAs($superadmin)->get(route('users.create'))->assertOk();
        $this->actingAs($superadmin)->get(route('barangs.index'))->assertOk();
        $this->actingAs($superadmin)->get(route('barangs.create'))->assertOk();
        $this->actingAs($superadmin)->get(route('transaksis.index'))->assertOk();
        $this->actingAs($superadmin)->get(route('transaksis.create'))->assertOk();
    }

    public function test_user_role_helper_methods(): void
    {
        $this->assertTrue(User::factory()->superadmin()->make()->isSuperadmin());
        $this->assertFalse(User::factory()->superadmin()->make()->isKaryawan());
        $this->assertTrue(User::factory()->karyawan()->make()->isKaryawan());
        $this->assertFalse(User::factory()->karyawan()->make()->isSuperadmin());
    }
}
