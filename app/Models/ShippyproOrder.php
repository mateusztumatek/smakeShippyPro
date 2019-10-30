<?php

namespace App\Models;

use App\Services\ShippyProClient;

class ShippyproOrder{
    public $OrderID, $LabelURL, $PDF, $ZPL, $CarrierID, $MarketPlacePlatform, $TrackingCarrier, $TrackingNumber, $TrackingExternalLink, $AdditionalTrackingNumbers, $Status;

    public function __construct($params)
    {
        foreach ($params as $key => $param){
            if(property_exists($this, $key)){
                $this->$key = $param;
            }
        }
    }

    public static function getOrder($id){
        $client = new ShippyProClient();
        $res = $client->order($id);
        $order = new ShippyproOrder($res);
        return $order;
    }
}
