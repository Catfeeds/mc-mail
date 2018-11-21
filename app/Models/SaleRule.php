<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleRule extends Model
{
    protected $table = 'after_sale_rule';
    protected $fillable = ['content'];
}
