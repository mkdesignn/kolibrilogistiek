<?php

namespace Tests\Feature;

use App\Purchaseorder;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     * @return void
     */
    public function shipped_should_throw_an_error_if_start_date_was_missing()
    {

        $this->json(self::HTTP_GET, 'orders/shipped')
            ->assertStatus(self::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['errors'=>['start_date']]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function shipped_should_throw_an_error_if_end_date_was_missing()
    {

        $this->json(self::HTTP_GET, 'orders/shipped')
            ->assertStatus(self::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['errors'=>['end_date']]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function shipped_should_throw_an_error_if_end_date_was_before_of_start_date()
    {

        $this->json(self::HTTP_GET, 'orders/shipped?start_date='.now()->toDateString().'&'.now()->subDays(3)->toDateString())
            ->assertStatus(self::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['errors'=>['end_date']]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function shipped_should_return_empty_results_if_no_records_found_between_specific_dates()
    {

        $this->be(factory(User::class)->create());

        $this->json(self::HTTP_GET, 'orders/shipped?start_date='.now()->toDateString().'&end_date='.now()->addDays(1)->toDateString())
            ->assertStatus(self::HTTP_OK)
            ->assertJson([]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function shipped_should_return_specific_results_if_there_was_data_between_specific_dates()
    {

        $this->be(factory(User::class)->create());
        $purchaseOrder = factory(Purchaseorder::class)->create(['shipped_at'=>now()->subDays(2)]);


        $this->json(self::HTTP_GET, 'orders/shipped?start_date='.now()->subDays(3)->toDateString().'&end_date='.now()->addDays(1)->toDateString())
            ->assertStatus(self::HTTP_OK)
            ->assertExactJson([['count'=>1, 'shipped_at'=>$purchaseOrder->shipped_at->toDateString()]]);
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
