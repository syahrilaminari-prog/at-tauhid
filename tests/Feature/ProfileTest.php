<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_profile_tab_opens_institution_profile_for_signed_in_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/')
            ->assertOk()
            ->assertSee('Profil')
            ->assertSee('href="'.route('profil').'"', false);
    }

    public function test_guest_homepage_profile_tab_still_links_to_institution_profile(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('href="'.route('profil').'"', false);
    }

    public function test_institution_profile_page_displays_complete_sections(): void
    {
        $this->get('/profil')
            ->assertOk()
            ->assertSee('Sejarah Pesantren')
            ->assertSee('Visi')
            ->assertSee('Misi')
            ->assertSee('Struktur Organisasi')
            ->assertSee('Program Inti');

        $this->get('/')->assertDontSee('Sejarah Pesantren');
    }

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_profile_photo_can_be_uploaded_and_replaced(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch('/profile', [
                'name' => $user->name,
                'email' => $user->email,
                'image' => UploadedFile::fake()->image('foto-profil-lama.jpg'),
            ])
            ->assertRedirect('/profile');

        $oldImage = $user->imageAttachments()->firstOrFail();
        Storage::disk('local')->assertExists($oldImage->path);
        $this->get(route('image-attachments.show', $oldImage))->assertOk();

        $this->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'image' => UploadedFile::fake()->image('foto-profil-baru.webp'),
        ])->assertRedirect('/profile');

        Storage::disk('local')->assertMissing($oldImage->path);
        $this->assertCount(1, $user->imageAttachments()->get());
        $this->assertSame('foto-profil-baru.webp', $user->imageAttachments()->first()->original_name);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_unverified_email_can_be_resent_from_profile_page(): void
    {
        $user = User::factory()->unverified()->create();

        Notification::fake();

        $this->actingAs($user)
            ->get('/profile')
            ->assertOk()
            ->assertSee('Email belum diverifikasi')
            ->assertSee('Kirim ulang email verifikasi');

        $this->post(route('verification.send'))
            ->assertRedirect()
            ->assertSessionHas('status', 'verification-link-sent');

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_user_can_delete_their_account(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();

        $this->actingAs($user)->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'image' => UploadedFile::fake()->image('foto-yang-dihapus.png'),
        ]);
        $image = $user->imageAttachments()->firstOrFail();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
        $this->assertDatabaseMissing('image_attachments', ['id' => $image->id]);
        Storage::disk('local')->assertMissing($image->path);
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
