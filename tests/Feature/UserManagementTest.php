<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_create_a_user(): void
    {
        $superadmin = User::factory()->superadmin()->create();

        $response = $this->actingAs($superadmin)->post(route('users.store'), [
            'name' => 'Karyawan Baru',
            'email' => 'karyawan.baru@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'karyawan',
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'karyawan.baru@example.com',
            'role' => 'karyawan',
        ]);
    }

    public function test_superadmin_can_update_a_user_without_changing_the_password(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $user = User::factory()->karyawan()->create();

        $this->actingAs($superadmin)->get(route('users.edit', $user))->assertOk();

        $this->actingAs($superadmin)
            ->put(route('users.update', $user), [
                'name' => 'Nama Diperbarui',
                'email' => $user->email,
                'password' => '',
                'password_confirmation' => '',
                'role' => 'superadmin',
            ])
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Diperbarui',
            'role' => 'superadmin',
        ]);
    }

    public function test_superadmin_can_delete_another_user(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $user = User::factory()->karyawan()->create();

        $this->actingAs($superadmin)
            ->delete(route('users.destroy', $user))
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_superadmin_can_not_delete_their_own_account(): void
    {
        $superadmin = User::factory()->superadmin()->create();

        $this->actingAs($superadmin)
            ->delete(route('users.destroy', $superadmin))
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $superadmin->id]);
    }
}
