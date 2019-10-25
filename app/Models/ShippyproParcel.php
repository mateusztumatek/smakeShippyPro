<?php

namespace App\Models;

class ShippyproParcel{
    public $length, $width, $height, $weight;
    public function __construct($length, $width, $height, $weight)
    {
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->weight = $weight;
    }
    public function toArray(){
        return [
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'weight' => $this->weight
        ];
    }
}
