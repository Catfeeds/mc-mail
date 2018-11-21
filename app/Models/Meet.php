<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/5/3
 * Time: 16:10
 * Function:
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Mcategory;
class Meet extends Model
{
    /**
     * @var array
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'meet_items', 'meet_id', 'item_id');
    }

}