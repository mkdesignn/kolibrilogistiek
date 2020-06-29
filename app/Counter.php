<?php

namespace DogStocker;

use Illuminate\Database\Eloquent\Model;
use DB;

class Counter extends Model
{
    use \TenantScope;
    
    public static $exclude = [
        4, 5, 8
    ];
    
    public static function dashboardTotals()
    {
        $query = 'SELECT';
        foreach(config('orderStatus') as $key => $value){
            if(!in_array($key, self::$exclude)){
                if (admin()) {
                    $query .= " (SELECT COUNT(*) FROM salesorders WHERE " . ($value['name'] == 'shipped' ? 'DATE(shipped_at) = CURDATE() AND' : '') . " status = $key AND tenant_id = " . getTenantId() . ") AS '$key',";    
                } else {
                    $query .= " (SELECT COUNT(*) FROM salesorders WHERE " . ($value['name'] == 'shipped' ? 'DATE(shipped_at) = CURDATE() AND' : '') . " status = $key AND tenant_id = " . getTenantId() . " AND customer_id= " . getCustomerId() . ") AS '$key',";    
                }
            }
        }
        $query = rtrim($query, ',');
        return DB::select($query)[0];
    }
    
    public static function dashboardTotalsApi()
    {
        $query = 'SELECT';
        foreach(config('orderStatus') as $key => $value){
            if(!in_array($key, self::$exclude)){
                $query .= " (SELECT COUNT(*) FROM salesorders WHERE " . ($value['name'] == 'shipped' ? 'DATE(shipped_at) = CURDATE() AND' : '') . " status = $key AND shop_id = " . API_SHOP . " AND tenant_id = " . getTenantId() . ") AS '$key',";    
            }
        }
        $query = rtrim($query, ',');
        return DB::select($query)[0];
    }
}
