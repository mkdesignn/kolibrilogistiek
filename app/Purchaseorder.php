<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid as UuidAlias;

class Purchaseorder extends Model
{
//    use \TenantScope, \CustomerScope;

    protected $table = 'purchaseorders';

    protected $guarded = [];

    protected $dates = [
        'expected_at',
        'received_at'
    ];

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
