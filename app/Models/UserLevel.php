<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Tanmo\Search\Traits\Search;

class UserLevel extends Model
{
    use Search;

    protected $fillable = ['name','level','upgrade_condition','date_num','date_money','brands','brands_money'];

    /**
     * @param $value
     * @return string
     */
//    public function getUpgradeWayAttribute($value)
//    {
//        switch ($value) {
//            case '0':
//                $upgrade_way = '手动升级';
//                break;
//            case 1:
//                $upgrade_way = '自动升级';
//                break;
//        }
//        return $upgrade_way;
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class,'level','level');
    }

    /**
     * @param Builder $builder
     * @param $start
     * @param $end
     * @return $this|void
     */
    public function scopeTimeInterval(Builder $builder, $start,$end)
    {
        if($start && $end) {
            return $builder->whereBetween('created_at', [$start,$end]);
        }
        else if($start) {
            return $builder->where('created_at', '>=' ,$start);
        }
        else if($end) {
            return $builder->where('created_at', '<=' ,$end);
        }
        else return;
    }

    /**
     * @param $value
     * @return array
     */
    public function getBrandsAttribute($value)
    {
        $brands = explode(",",$value);

        return $brands;
    }

    /**
     * @param $value
     * @return float
     */
    public function getDateMoneyAttribute($value)
    {
        return round($value / 100, 2);
    }

    /**
     * @param $value
     */
    public function setDateMoneyAttribute($value)
    {
        $this->attributes['date_money'] = $value * 100;
    }

    public function getBrandsMoneyAttribute($value)
    {
        return round($value / 100, 2);
    }

    /**
     * @param $value
     */
    public function setBrandsMoneyAttribute($value)
    {
        $this->attributes['brands_money'] = $value * 100;
    }

}
