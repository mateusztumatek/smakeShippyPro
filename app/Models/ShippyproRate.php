<?php

namespace App\Models;

class ShippyproRate{
    public $carrier, $order_id, $carrier_id, $carrier_label, $rate, $rate_id, $delivery_days, $service, $currency, $zone_name, $weight_range, $detailed_pricing;
    public function __construct($params)
    {
        foreach ($params as $key => $param){
            if(property_exists($this, $key)){
                $this->$key = $param;
            }
        }
    }
}
