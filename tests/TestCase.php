<?php

namespace Tests;

use App\Purchaseorder;
use App\Purchaseorderlines;
use App\User;
use App\Utils\Enums\Role;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // HTTP status constants
    const HTTP_BAD_REQUEST = 400;
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_NO_CONTENT = 204;
    const HTTP_NOT_FOUND = 404;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_WRONG_METHOD = 405;
    const HTTP_FORBIDDEN = 403;
    const HTTP_UNPROCESSABLE_ENTITY = 422;
    const HTTP_INTERNAL_ERROR = 500;
    const HTTP_SERVICE_UNAVALIABLE = 503;
    const HTTP_REDIRECT = 302;

    // HTTP ACTION
    const HTTP_GET = 'get';
    const HTTP_POST = 'post';

    protected function createOrder(int $userId)
    {
        return factory(Purchaseorder::class)->create(['user_id'=>$userId, 'customer_id'=>$userId]);
    }

    protected function createOrderLine(Purchaseorder $order)
    {
        return factory(Purchaseorderlines::class)->create(['purchaseorder_id'=>$order->id, 'user_id'=>$order->user_id]);
    }

    protected function createCustomer()
    {
        return factory(User::class)->create(['role'=>Role::CUSTOMER]);
    }

    protected function createSupplier()
    {
        return factory(User::class)->create(['role'=>Role::SUPPLIER]);
    }

    protected function createAdmin()
    {
        return factory(User::class)->create(['role'=>Role::ADMIN]);
    }
}
