<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippedOrderRequest;
use App\Http\Requests\StorePurchased;
use App\Http\Requests\UpdatePurchased;
use App\Purchaseorder;
use App\Purchaseorderlines;
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
     * @var Purchaseorderlines
     */
    private $purchaseorderlines;

    /**
     * OrderController constructor.
     * @param Purchaseorder $purchaseorder
     * @param Purchaseorderlines $purchaseorderlines
     */
    public function __construct(Purchaseorder $purchaseorder, Purchaseorderlines $purchaseorderlines)
    {
        $this->middleware('auth');
        $this->purchaseorder = $purchaseorder;
        $this->purchaseorderlines = $purchaseorderlines;
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

    public function storePurchased(StorePurchased $storePurchased){

        $customerId = $storePurchased->customer_id;
        if(Auth::user()->isAdmin()){
            $createdOrder = $this->purchaseorder
                ->create($storePurchased->only(['customer_id', 'supplier_id', 'number', 'expected_at', 'trackandtrace']) + ['user_id'=>$customerId]);
        } else {
            $customerId = Auth::user()->id;
            $createdOrder = $this->purchaseorder->create($storePurchased->only(['supplier_id', 'number', 'expected_at', 'trackandtrace']) +
                ['user_id'=>$customerId, 'customer_id'=>$customerId]);
        }

        foreach($storePurchased->product as $key => $productId){
            $this->purchaseorderlines->create([
                'purchaseorder_id'=>$createdOrder->id,
                'product_id'=>$productId,
                'user_id'=>$customerId,
                'batch'=>$storePurchased->has('batch') ? $storePurchased->batch[$key] : null,
                'quantity'=>$storePurchased->quantity[$key],
                'expire_date'=>$storePurchased->has('expire_date') ? $storePurchased->expire_date[$key]: null,
            ]);
        }


        return redirect()->to(route('purchased.list'));

    }

    public function updatePurchased($order, UpdatePurchased $storePurchased)
    {

        $this->authorize('accessOrder', $order);

        $customerId = $storePurchased->customer_id;
        if(Auth::user()->isAdmin()){
            $order->update($storePurchased->only(['customer_id', 'supplier_id', 'number', 'expected_at', 'trackandtrace']));
        } else {
            $order->update($storePurchased->only(['supplier_id', 'number', 'expected_at', 'trackandtrace']));
            $customerId = Auth::user()->id;
        }


        // drop all of the lines and create new one
        $order->lines()->delete();

        foreach($storePurchased->product as $key => $productId){
            $this->purchaseorderlines->create([
                'purchaseorder_id'=>$order->id,
                'product_id'=>$productId,
                'user_id'=>$customerId,
                'batch'=>$storePurchased->batch[$key],
                'quantity'=>$storePurchased->quantity[$key],
                'expire_date'=>$storePurchased->expire_date[$key],
                ]);
        }


        return redirect()->to(route('purchased.list'));
    }

    public function show($order){

        $this->authorize('accessOrder', $order);

        return view('order.purchased.show', compact('order'));
    }

    public function create(){

        $order = new Purchaseorder();
        return view('order.purchased.create', compact('order'));
    }

    public function purchasedLine($order){

        return $order->lines()->with('product')->get();
    }



}
