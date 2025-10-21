<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin_log extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'action',
        'user_id',
        'user_account',
        'mainDataTableName',
        'before',
        'after',
        'created_at',
    ];
}
