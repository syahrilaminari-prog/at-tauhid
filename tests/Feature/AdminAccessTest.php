<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_can_access_admin_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role_id' => $role->id,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertOk();
        $response->assertSee('Panel Administrasi');
        $response->assertSee('Modul Utama');
    }

    public function test_non_admin_user_cannot_access_admin_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Santri',
            'slug' => 'santri',
            'description' => 'Santri aktif',
        ]);

        $user = User::factory()->create([
            'name' => 'Santri User',
            'email' => 'santri@example.com',
            'role_id' => $role->id,
        ]);

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin-login@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
    }

    public function test_santri_login_redirects_to_santri_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Santri',
            'slug' => 'santri',
            'description' => 'Santri aktif',
        ]);

        $user = User::factory()->create([
            'name' => 'Santri User',
            'email' => 'santri-login@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/santri');
    }

    public function test_parent_user_can_access_parent_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Orang Tua',
            'slug' => 'orang_tua',
            'description' => 'Orang tua / wali santri',
        ]);

        $user = User::factory()->create([
            'name' => 'Orang Tua User',
            'email' => 'orangtua@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $response = $this->actingAs($user)->get('/orangtua');

        $response->assertOk();
        $response->assertSee('Portal Orang Tua');
    }

    public function test_parent_login_redirects_to_parent_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Orang Tua',
            'slug' => 'orang_tua',
            'description' => 'Orang tua / wali santri',
        ]);

        $user = User::factory()->create([
            'name' => 'Orang Tua User',
            'email' => 'orangtua-login@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/orangtua');
    }

    public function test_santri_user_can_access_student_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Santri',
            'slug' => 'santri',
            'description' => 'Santri aktif',
        ]);

        $user = User::factory()->create([
            'name' => 'Santri Dashboard User',
            'email' => 'santri-dashboard@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $response = $this->actingAs($user)->get('/santri');

        $response->assertOk();
        $response->assertSee('Dashboard Santri');
    }

    public function test_ustadz_user_can_access_teacher_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Ustadz',
            'slug' => 'ustadz',
            'description' => 'Pengajar dan pembina santri',
        ]);

        $user = User::factory()->create([
            'name' => 'Ustadz Dashboard User',
            'email' => 'ustadz-dashboard@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $response = $this->actingAs($user)->get('/ustadz');

        $response->assertOk();
        $response->assertSee('Dashboard Ustadz');
    }

    public function test_ustadz_login_redirects_to_ustadz_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Ustadz',
            'slug' => 'ustadz',
            'description' => 'Pengajar dan pembina santri',
        ]);

        $user = User::factory()->create([
            'name' => 'Ustadz Login User',
            'email' => 'ustadz-login@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/ustadz');
    }

    public function test_ustadz_cannot_access_santri_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Ustadz',
            'slug' => 'ustadz',
            'description' => 'Pengajar dan pembina santri',
        ]);

        $user = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($user)->get('/santri')->assertForbidden();
    }

    public function test_santri_cannot_access_ustadz_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Santri',
            'slug' => 'santri',
            'description' => 'Santri aktif',
        ]);

        $user = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($user)->get('/ustadz')->assertForbidden();
    }
}
