<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginLocaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_returns_login_form(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('name="code_apogee"', false);
        $response->assertSee('name="date_naissance"', false);
        $response->assertSee('action="'.url('/login').'"', false);
    }

    public function test_switch_locale_sets_session_and_renders_rtl_for_ar(): void
    {
        $this->post('/locale/ar')->assertRedirect();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('dir="rtl"', false);
        $this->assertSame('ar', session('locale'));
    }

    public function test_invalid_date_format_shows_inline_error_and_keeps_values(): void
    {
        $response = $this->from('/')
            ->post('/login', [
                'code_apogee' => 'A12345',
                'date_naissance' => '31/02/2000',
            ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['date_naissance']);

        $follow = $this->get('/');
        $follow->assertSee('A12345', false);
        $follow->assertSee('31/02/2000', false);
        $follow->assertSee(__('messages.login.errors.dob_invalid_format'), false);
        $follow->assertSeeInOrder(['id="date_naissance"', 'autofocus'], false);
    }
}
