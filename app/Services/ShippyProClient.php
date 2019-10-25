<?php

namespace App\Services;

use App\Models\ShippyproAddress;
use App\Models\ShippyproShipment;
use Illuminate\Support\Collection;
use App\Services\ShippyProRequest as ShippyProRequest;
class ShippyProClient{
    protected $request;
    public function __construct($api_key)
    {
        $this->request = new \App\Services\ShippyProRequest($api_key);
    }
    public function rates(ShippyproShipment $shipment){
        try{
            $out = $this->request->call($shipment->toArray(), 'GetRates');
            return $out;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
