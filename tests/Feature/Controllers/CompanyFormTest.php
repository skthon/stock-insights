<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class CompanyFormTest extends TestCase
{
    public function test_show_form_page_can_be_rendered()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_show_form_page_contains_input_fields()
    {
        $response = $this->get('/');
        $response->assertSee('Company Symbol');
        $response->assertSee('Email Address');
        $response->assertSee('Select date start');
        $response->assertSee('Select date end');
        $response->assertSee('Submit');
    }
}
