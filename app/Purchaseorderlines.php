<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Purchaseorderlines extends Model
{
    protected $table = 'purchaseorderlines';

    protected $guarded = [];

    protected $casts = [
        'purchaseorder_id' => 'int',
        'product_id' => 'int',
        'user_id' => 'int',
        'received_by' => 'int',
        'quantity' => 'int',
        'quantity_received' => 'int',
    ];

    public function __construct( $attributes = [] )
	{
        parent::__construct($attributes);
//        $this->user_id = \Auth::id();
	}

    /**
     * A purchaseorderline has 1 user who created it
     */
    public function user()
    {
        return $this->hasOne('DogStocker\User')
            ->select(['id', 'name', 'is_worker']);
    }

    /**
     * A purchaseorderline belongs to 1 purchaseorder
     */
    public function purchaseorder()
    {
        return $this->belongsTo(Purchaseorder::class, 'id', 'purchaseorder');
    }

    /**
     * A purchaseorderline belongs to 1 product
     */
    public function product()
    {
        return $this->belongsTo('DogStocker\Product');
    }
}
