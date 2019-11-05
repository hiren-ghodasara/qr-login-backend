<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    protected $dates = [
        'execution_date',
    ];

    protected $fillable = [
        'name',
        'photo',
        'description',
        'created_by',
        'type',
        'joining_fee',
        'max_user',
        'joined_user',
        'execution_date',
    ];

    public function contestsType()
    {
        return $this->belongsTo('App\Models\ContestType', 'type');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User', 'created_by');
    }
}
