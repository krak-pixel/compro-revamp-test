<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_is_available(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Solusi Distribusi &amp; Logistik Terbaik', false)
            ->assertSee('id="tentang-kami"', false)
            ->assertSee('id="kontak-kami"', false);
    }
}
