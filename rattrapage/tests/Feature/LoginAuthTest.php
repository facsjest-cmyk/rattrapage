<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class LoginAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_happy_path_authenticates_and_redirects_to_convocation(): void
    {
        Etudiant::create([
            'cod_etu' => 'A0001',
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '2000-03-07',
            'filiere' => 'INFO',
        ]);

        $response = $this->post('/login', [
            'code_apogee' => 'A0001',
            'date_naissance' => '07/03/2000',
        ]);

        $response->assertRedirect('/convocation');
        $this->assertSame('A0001', session('cod_etu'));
    }

    public function test_apogee_not_found_shows_specific_error(): void
    {
        $response = $this->from('/')->post('/login', [
            'code_apogee' => 'NOTFOUND',
            'date_naissance' => '07/03/2000',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors([
            'code_apogee' => __('messages.login.errors.apogee_not_found'),
        ]);

        $follow = $this->get('/');
        $follow->assertSee('NOTFOUND', false);
    }

    public function test_dob_mismatch_shows_specific_error(): void
    {
        Etudiant::create([
            'cod_etu' => 'A0002',
            'nom' => 'Doe',
            'prenom' => 'Jane',
            'date_naissance' => '2001-02-03',
            'filiere' => 'INFO',
        ]);

        $response = $this->from('/')->post('/login', [
            'code_apogee' => 'A0002',
            'date_naissance' => '07/03/2000',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors([
            'date_naissance' => __('messages.login.errors.dob_mismatch'),
        ]);
    }

    public function test_throttle_after_six_attempts(): void
    {
        RateLimiter::clear('login:127.0.0.1');

        for ($i = 0; $i < 5; $i++) {
            $this->from('/')->post('/login', [
                'code_apogee' => 'NOTFOUND',
                'date_naissance' => '07/03/2000',
            ])->assertRedirect('/');
        }

        $response = $this->from('/')->post('/login', [
            'code_apogee' => 'NOTFOUND',
            'date_naissance' => '07/03/2000',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors([
            'code_apogee' => __('messages.login.errors.throttle'),
        ]);
    }
}
