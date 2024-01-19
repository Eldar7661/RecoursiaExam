<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    public function userAllMethods(User $model): bool
    {
        return $model->role == 'Admin';
    }

    public function posterminalAllMethods(User $model): bool
    {
        if ($model->role == 'Admin' || $model->role == 'Manager') {
            return true;
        } else {
            return false;
        }
    }

    public function themeAllMethods(User $model): bool
    {
        if ($model->role == 'Admin' || $model->role == 'Manager') {
            return true;
        } else {
            return false;
        }
    }

    public function solutionAllMethods(User $model): bool
    {
        if ($model->role == 'Admin' || $model->role == 'Manager') {
            return true;
        } else {
            return false;
        }
    }

    public function requestShow(User $model): bool
    {
        return true;
    }

    public function requestCreate(User $model): bool
    {
        if ($model->role == 'Admin' || $model->role == 'Manager') {
            return true;
        } else {
            return false;
        }
    }

    public function requestInWork(User $model): bool
    {
        if ($model->role == 'Admin' || $model->role == 'Worker') {
            return true;
        } else {
            return false;
        }
    }

    public function requestClose(User $model): bool
    {
        if ($model->role == 'Admin' || $model->role == 'Worker') {
            return true;
        } else {
            return false;
        }
    }

    public function requestCancel(User $model): bool
    {
        if ($model->role == 'Admin' || $model->role == 'Manager') {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }
}
