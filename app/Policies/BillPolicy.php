<?php

namespace App\Policies;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BillPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Bill $bill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Bill $bill)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Bill $bill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Bill $bill)
    {
//        if ($user->hasPermission('update_own_bill'){
//                    return $user->id === $bill->user_id;
//    } else
//        if ($user->hasPermission('update_bill')) {
//            return true;
//        } else {
//            return false;
//        }
        if ($user->role->permissions->contains('name', 'update_own_bill')){
            return $user->id === $bill->user_id;
            } elseif($user->role->permissions->contains('name', 'update_bill')){
                return true;
                } else {
            return false;
                }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Bill $bill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Bill $bill)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Bill $bill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Bill $bill)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Bill $bill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Bill $bill)
    {
        //
    }
}
