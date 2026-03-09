<?php

namespace Tests\Feature;

use Tests\TestCase;

class SessionLifetimeConfigTest extends TestCase
{
    public function test_session_lifetime_is_30_minutes(): void
    {
        $this->assertSame(30, config('session.lifetime'));
    }
}
