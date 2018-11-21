<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRule extends Model
{
    protected $table = 'user_rule';
    protected $fillable = ['content'];
}
