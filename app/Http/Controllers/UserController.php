<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var Supplier
     */
    private $supplier;

    /**
     * UserController constructor.
     * @param Supplier $supplier
     */
    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }


    public function getSuppliers(){
        return $this->supplier->select('id', 'name as text')->get();
    }
}
