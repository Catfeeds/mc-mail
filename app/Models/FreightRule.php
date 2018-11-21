<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreightRule extends Model
{
    protected $table = 'freight_rule';
    protected $fillable = ['content'];
}
