<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniqueCode extends Model
{
    protected $fillable = ['unique_code', 'visitor', 'channel_id'];
}
