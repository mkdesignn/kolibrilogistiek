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
}
