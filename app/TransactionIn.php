<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionIn extends Model
{
    protected $fillable = [
        'id_user', 'money', 'date', 'title', 'reason', 'image'
    ];
}
