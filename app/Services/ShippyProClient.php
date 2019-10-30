<?php

namespace App\Services;

use App\Models\ShippyproAddress;
use App\Models\ShippyproShipment;
use Illuminate\Support\Collection;
use App\Services\ShippyProRequest as ShippyProRequest;
class ShippyProClient{
    protected $request;
    public function __construct()
    {
        $this->request = new \App\Services\ShippyProRequest();
    }
    public function rates(ShippyproShipment $shipment){
        try{
            $out = $this->request->call($shipment->toArray(), 'GetRates');
            if(property_exists($out, 'Error')){
                throw new \Exception('Authentication Error');
            }
            return $out;
        }catch(\Exception $e){
            throw $e;
        }
    }
    public function ship(ShippyproShipment $shipment){
        try{
            $out = $this->request->call($shipment->toArray(), 'Ship');
            return $out;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function order($id){
        try{
            $out = $this->request->call(['OrderID' => (integer) $id], 'GetOrder');
            if(property_exists($out, 'Error')){
                throw new \Exception(new \Exception('Wrong order ID'));
            }
            return $out;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}

