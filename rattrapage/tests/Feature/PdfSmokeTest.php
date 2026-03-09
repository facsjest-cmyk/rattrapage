<?php

namespace Tests\Feature;

use Tests\TestCase;

class PdfSmokeTest extends TestCase
{
    public function test_pdf_smoke_endpoint_returns_pdf(): void
    {
        $response = $this->get('/_smoke/pdf');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }
}
