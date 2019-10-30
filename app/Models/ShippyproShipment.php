<?php

namespace App\Models;
use App\Services\ShippyProClient;
use Illuminate\Support\Collection;

class ShippyproShipment
{
    protected $from_address, $to_address, $parcels;
    protected $Insurance = 0, $InsuranceCurrency = "EUR", $CashOnDelivery = 0, $CashOnDeliveryCurrency="EUR", $ContentDescription, $TotalValue, $ShippingService = "Standard", $RateCarriers;
    protected $TransactionID, $CarrierName, $CarrierService, $CarrierID, $OrderID, $RateID;
    protected $client;
    public function __construct(float $TotalValue, $ContentDescription)
    {
        $this->client = new ShippyProClient();
        $this->TotalValue = $TotalValue;
        $this->ContentDescription = $ContentDescription;
        $this->parcels = collect();
    }
    public function addParcel(ShippyproParcel $parcel) : Collection{
        $this->parcels->push($parcel);
        return $this->parcels;
    }
    public function from_address(ShippyproAddress $address) : self{
        $this->from_address = $address;
        return $this;
    }

    public function to_address(ShippyproAddress $address) : self{
        $this->to_address = $address;
        return $this;
    }

    public function setInsurance($value, $currency) : self{
        $this->Insurance = $value;
        $this->InsuranceCurrency = $currency;
        return $this;
    }

    public function setCashOnDelivery($currency) : self{
        $this->CashOnDelivery = 1;
        $this->CashOnDeliveryCurrency = $currency;
        return $this;
    }
    public function setTransactionId($id){
        $this->TransactionID = 'ORDER'.$id;
        $this->OrderID = 'ORDER'.$id;
    }
    public function setRate(ShippyproRate $rate){
        $this->CarrierName = $rate->carrier;
        $this->CarrierService = $rate->service;
        $this->CarrierID = $rate->carrier_id;
        $this->RateID = $rate->rate_id;
    }
    public function purchase(){
        return $this->client->ship($this);
    }
    public function getRates() : Collection{
        $rates = $this->client->rates($this);
        $rates_collection = collect()->whereInstanceOf(ShippyproRate::class);
        foreach ($rates->Rates as $r){
            $rates_collection->push(new ShippyproRate($r));
        }
        return $rates_collection;
    }
    public function parcelsToArray() : array{
        $array = array();
        foreach ($this->parcels as $parcel){
            array_push($array, $parcel->toArray());
        }
        return $array;
    }

    public function toArray() : array {
        return [
            'from_address' => $this->from_address->toArray(),
            'to_address' => $this->to_address->toArray(),
            'parcels' => $this->parcelsToArray(),
            'Insurance' => $this->Insurance,
            'InsuranceCurrency' => $this->InsuranceCurrency,
            'CashOnDelivery' => $this->CashOnDelivery,
            'CashOnDeliveryCurrency' => $this->CashOnDeliveryCurrency,
            'ContentDescription' => $this->ContentDescription,
            'TotalValue' => (string) $this->TotalValue,
            'ShippingService' => $this->ShippingService,
            'transactionID' => ($this->TransactionID) ? $this->TransactionID : null,
            'CarrierName' => ($this->CarrierName) ? $this->CarrierName : null,
            'CarrierService' => ($this->CarrierService) ? $this->CarrierService : null,
            'CarrierID' => ($this->CarrierID) ? $this->CarrierID : null,
            'OrderID' => ($this->OrderID) ? $this->OrderID : null,
            'RateID' => ($this->RateID) ? $this->RateID : null,
        ];
    }
}
