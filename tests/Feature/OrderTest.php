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

    /**
     * @test
     *
     * @return void
     */
    public function purchased_should_return_specific_view_with_specific_orders()
    {
        $customer = $this->createCustomer();
        $this->be($customer);
        $order = $this->createOrder($customer->id);
        $order = $this->createOrderLine($order);

        $this->get('orders/purchased/list')
            ->assertStatus(self::HTTP_OK)
            ->assertViewIs('order.purchased.index')
            ->assertViewHas('purchased', function($purchased){
                $this->assertEquals(count($purchased->items()), 1);
                return true;
            });
    }

    /**
     * @test
     *
     * @return void
     */
    public function purchased_should_not_return_the_any_data_if_user_did_not_have_any()
    {
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer->id);
        $order = $this->createOrderLine($order);

        $secondCustomer = $this->createCustomer();
        $this->be($secondCustomer);

        $this->get('orders/purchased/list')
            ->assertStatus(self::HTTP_OK)
            ->assertViewIs('order.purchased.index')
            ->assertViewHas('purchased', function($purchased){
                $this->assertEquals(count($purchased->items()), 0);
                return true;
            });
    }


    /**
     * @test
     *
     * @return void
     */
    public function purchased_should_return_all_data_if_user_was_admin()
    {
        $admin = $this->createAdmin();

        $firstCustomer = $this->createCustomer();
        $order = $this->createOrder($firstCustomer->id);
        $order = $this->createOrderLine($order);

        $secondCustomer = $this->createCustomer();
        $order = $this->createOrder($secondCustomer->id);
        $order = $this->createOrderLine($order);

        $this->be($admin);

        $this->get('orders/purchased/list')
            ->assertStatus(self::HTTP_OK)
            ->assertViewIs('order.purchased.index')
            ->assertViewHas('purchased', function($purchased){
                $this->assertEquals(count($purchased->items()), 2);
                return true;
            });
    }

    /**
     * @test
     *
     * @return void
     */
    public function storePurchased_should_store_new_order()
    {
        $admin = $this->createAdmin();

        $customer = $this->createCustomer();
        $order = $this->createOrder($customer->id);
        $orderLine = $this->createOrderLine($order);

        $suplier = $this->createSupplier();

        $this->be($admin);

        $this->json('post', 'orders/purchased',
            [
                'customer_id'=>$customer->id,
                'supplier_id'=>$suplier->id,
                'expected_at'=>now()->toDateTimeString(),
                'number'=>random_int(1, 9999),
                'trackandtrace'=>'test',
                'quantity'=>[1],
                'product'=>[$orderLine->product->id]
            ])
            ->assertStatus(self::HTTP_REDIRECT)
            ->assertRedirect(route('purchased.list'));
    }


    /**
     * @test
     *
     * @return void
     */
    public function updatePurchased_should_update_order()
    {
        $admin = $this->createAdmin();

        $customer = $this->createCustomer();
        $order = $this->createOrder($customer->id);
        $orderLine = $this->createOrderLine($order);

        $suplier = $this->createSupplier();

        $this->be($admin);

        $this->json('put', 'orders/purchased/' . $order->id,
            [
                'customer_id'=>$customer->id,
                'supplier_id'=>$suplier->id,
                'expected_at'=>now()->toDateTimeString(),
                'number'=>random_int(1, 9999),
                'trackandtrace'=>'test',
                'quantity'=>[2],
                'product'=>[$orderLine->product->id]
            ])
            ->assertStatus(self::HTTP_REDIRECT)
            ->assertRedirect(route('purchased.list'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function show_should_return_the_correct_view()
    {
        $admin = $this->createAdmin();

        $customer = $this->createCustomer();
        $order = $this->createOrder($customer->id);

        $this->be($admin);

        $this->json('get', 'orders/purchased/' . $order->id)
            ->assertViewIs('order.purchased.show');
    }

    /**
     * @test
     *
     * @return void
     */
    public function create_should_return_the_correct_view()
    {
        $admin = $this->createAdmin();

        $this->be($admin);

        $this->json('get', 'orders/purchased')
            ->assertViewIs('order.purchased.create');
    }
}
