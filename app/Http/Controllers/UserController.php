<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\User;
use App\Utils\Enums\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var Supplier
     */
    private $supplier;
    /**
     * @var User
     */
    private $user;

    /**
     * UserController constructor.
     * @param Supplier $supplier
     * @param User $user
     */
    public function __construct(Supplier $supplier, User $user)
    {
        $this->supplier = $supplier;
        $this->user = $user;
    }


    public function getSuppliers(){
        return $this->supplier->select('id', 'name as text')->get();
    }

    public function getCustomers(){
        return $this->user->select('id', 'name as text')->whereRole(Role::CUSTOMER)->get();
    }
}
