<?php

namespace App\Models;
use App\Services\ShippyProClient;
use Illuminate\Support\Collection;

class ShippyproShipment
{
    protected $from_address, $to_address, $parcels;
    protected $Insurance = 0, $InsuranceCurrency = "EUR", $CashOnDelivery = 0, $CashOnDeliveryCurrency="EUR", $ContentDescription, $TotalValue, $ShippingService = "Standard", $RateCarriers;

    public function __construct(float $TotalValue, $ContentDescription)
    {
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
    public function getRate(){
        $client = new ShippyProClient('MRJlNDNmYzU1OGM5MjBiM2Q5MzYzZjkyOGFiMzdmNDE6');
        return $client->rates($this);
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
            'parcel' => $this->parcelsToArray(),
            'Insurance' => $this->Insurance,
            'InsuranceCurrency' => $this->InsuranceCurrency,
            'CashOnDelivery' => $this->CashOnDelivery,
            'CashOnDeliveryCurrency' => $this->CashOnDeliveryCurrency,
            'ContentDescription' => $this->ContentDescription,
            'TotalValue' => $this->TotalValue,
            'ShippingService' => $this->ShippingService
        ];
    }
}
