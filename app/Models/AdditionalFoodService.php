<?php

class AdditionalFoodService
{
    public $Id;
    public $FoodName;
    public $FoodDescription;
    public $FoodPrice;
    public $FoodForFlights = [];
    public $ReservationMapAdditionalFoodServices = [];
    public $FlightDetails = [];
    public $ReservationDetails = [];

    public function __construct()
    {
        $this->Id = uniqid(); // You can generate a unique identifier as needed
    }
}
