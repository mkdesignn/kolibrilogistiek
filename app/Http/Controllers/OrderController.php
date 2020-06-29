<?php

namespace App\Http\Controllers;

use App\Purchaseorder;
use Illuminate\Http\Request;
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

        $this->purchaseorder = $purchaseorder;
    }

    public function shipped(Request $request)
    {

        $purchaseorder = $this->purchaseorder->select(DB::raw('count(*) as count'), 'shipped_at');
        $purchaseorder->whereBetween('shipped_at', [$request->start_date, $request->end_date]);
        return $purchaseorder->groupBy('shipped_at')->get();
    }
}
