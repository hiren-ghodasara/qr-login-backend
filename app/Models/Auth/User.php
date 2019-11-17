<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use App\Models\Auth\Traits\Relationship\UserRelationship;
use Laravel\Cashier\Billable;

/**
 * Class User.
 */
class User extends BaseUser
{
    use UserAttribute,
        UserMethod,
        Billable,
        UserRelationship,
        UserScope;

    public function transactions()
    {
        return $this->hasMany("App\Models\Transaction");
    }

    public function deposit($amount, $description = null, $meta = null)
    {
        return \DB::transaction(function () use ($amount, $description, $meta) {
            $this->transactions()
                ->create([
                    'amount' => $amount,
                    'type' => 'deposit',
                    'description' => $description,
                    'meta' => $meta,
                ]);
            $this->balance += $amount;
            $this->save();
        });
    }

    public function withdraw($amount, $description = null, $meta = null)
    {
        return \DB::transaction(function () use ($amount, $description, $meta) {
            $this->transactions()
                ->create([
                    'amount' => $amount,
                    'type' => 'withdraw',
                    'description' => $description,
                    'meta' => $meta,
                ]);
            $this->balance -= $amount;
            $this->save();
        });
    }
}
