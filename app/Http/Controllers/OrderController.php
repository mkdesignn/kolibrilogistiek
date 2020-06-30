<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippedOrderRequest;
use App\Purchaseorder;
use App\Utils\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    /**
     * @var Purchaseorder
     */
    private $purchaseorder;

    /**
     * OrderController constructor.
     * @param Purchaseorder $purchaseorder
     */
    public function __construct(Purchaseorder $purchaseorder)
    {
        $this->middleware('auth');
        $this->purchaseorder = $purchaseorder;
    }

    public function shipped(ShippedOrderRequest $request)
    {

        return $this->purchaseorder
            ->select(DB::raw('count(*) as count'), 'shipped_at')
            ->whereBetween('shipped_at', [$request->start_date, $request->end_date])
            ->where(function($query){
                $loggedInUser = Auth::user();
                $loggedInUser->role === Role::ADMIN ?: $query->where('customer_id', $loggedInUser->id);
            })
            ->groupBy('shipped_at')
            ->get();
    }


    /*
     *
     */
    public function purchased(){

        $purchased = $this->purchaseorder->whereCustomerId(Auth::user()->id)->paginate(10);
        return view('order.purchased.index', compact('purchased'));
    }

    public function show($order){

        return view('order.purchased.show', compact('order'));
    }
}
