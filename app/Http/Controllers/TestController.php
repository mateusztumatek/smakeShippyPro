<?php

namespace App\Http\Controllers;

use App\Models\ShippyproAddress;
use App\Models\ShippyproParcel;
use App\Models\ShippyproShipment;
use App\Services\ShippyProClient;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        $sender = new ShippyproAddress('Mateusz Bielak', '/', 'Tadeusza Kościuszki 58', '/', 'Wrocław', 'DS', '50-009', 'PL', '694556711', 'mbielak@ideashirt.pl');
        $recivier = new ShippyproAddress('Mateusz Bielak', '/', 'Tadeusza Kościuszki 58', '/', 'Wrocław', 'DS', '50-009', 'PL', '694556711', 'mbielak@ideashirt.pl');
        $parcel = new ShippyproParcel('30', '20', '20', '10');
        $shipment = new ShippyproShipment(30.00, 'Description');
        $shipment->to_address($recivier);
        $shipment->from_address($sender);
        $shipment->addParcel($parcel);
        dump($shipment->getRate());
    }
}
