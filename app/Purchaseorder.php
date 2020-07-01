<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid as UuidAlias;
use Webpatser\Uuid\Uuid;

class Purchaseorder extends Model
{

    protected $table = 'purchaseorders';

    protected $guarded = [];

    protected $dates = [
        'expected_at',
        'received_at'
    ];


    /**
     *  Boot model with uuidv4
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = \Ramsey\Uuid\Uuid::getFactory()->uuid4();
        });
    }

    public function customer(){
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    public function supplier(){
        return $this->hasOne(User::class, 'id', 'supplier_id');
    }

    public function lines(){

        return $this->hasMany(Purchaseorderlines::class);
    }
}
