<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     * @return void
     */
    public function index_should_return_view_successfully()
    {

        $this->be(factory(User::class)->create());

        $this->get('dashboard')
            ->assertStatus(self::HTTP_OK);
    }

    /**
     * @test
     *
     * @return void
     */
    public function index_should_throw_an_error_if_user_was_not_logged_in_and_tried_ta_access_it()
    {
        $this->get('dashboard')
            ->assertStatus(self::HTTP_REDIRECT);
    }
}
