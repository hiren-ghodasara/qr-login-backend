<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'amount', 'meta', 'type', 'description',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }
}
