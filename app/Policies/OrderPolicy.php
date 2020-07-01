<?php

namespace App\Policies;

use App\Purchaseorder;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function accessOrder(User $user , Purchaseorder $purchaseorder){

        if($user->isAdmin()){
            return false;
        } else {
            return $purchaseorder->user_id === $user->id;
        }
    }

}
