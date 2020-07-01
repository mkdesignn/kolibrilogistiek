<?php

namespace App;

use App\Scope\SupplierBuilder;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{

    protected $table = 'users';

    protected static function boot(){

        parent::boot();

        static::addGlobalScope(new SupplierBuilder());
    }

}
