<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthEtudiantMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_convocation_without_session_redirects_to_login_with_message(): void
    {
        $response = $this->get('/convocation');

        $response->assertRedirect('/');
        $response->assertSessionHas('auth_message', __('messages.auth.must_login'));
    }

    public function test_convocation_with_session_is_allowed(): void
    {
        Etudiant::create([
            'cod_etu' => 'A0001',
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '2000-03-07',
            'filiere' => 'INFO',
        ]);

        $response = $this->withSession(['cod_etu' => 'A0001'])->get('/convocation');

        $response->assertOk();
        $response->assertSee(__('messages.convocation.heading'), false);
    }

    public function test_convocation_with_session_cookie_but_missing_session_shows_expired_message(): void
    {
        $cookieName = config('session.cookie');

        $response = $this->withCookie($cookieName, 'dummy')->get('/convocation');

        $response->assertRedirect('/');
        $response->assertSessionHas('auth_message', __('messages.auth.session_expired'));
    }
}
