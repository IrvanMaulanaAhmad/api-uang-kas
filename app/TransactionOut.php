<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionOut extends Model
{
    protected $fillable = [
        'id_user', 'money', 'date', 'title', 'reason', 'image'
    ];
}
