<?php

class CreateTicketOrderDTO
{
    public $ticket_amount;
    public $customer_name;
    public $customer_email;
    public $customer_identify;
    public $seat_id;
    public $flight_id;
    public $departure_day;
    public $arrive_day;
    public $departure_time;
    public $arrive_time;
    public $customer_phone;
    public $duration_time;
    public $trip_type;

    // Getter and Setter methods

    public function getTicketAmount()
    {
        return $this->ticket_amount;
    }

    public function setTicketAmount($ticket_amount)
    {
        $this->ticket_amount = $ticket_amount;
    }

    public function getCustomerName()
    {
        return $this->customer_name;
    }

    public function setCustomerName($customer_name)
    {
        $this->customer_name = $customer_name;
    }

    public function getCustomerEmail()
    {
        return $this->customer_email;
    }

    public function setCustomerEmail($customer_email)
    {
        $this->customer_email = $customer_email;
    }

    public function getCustomerIdentify()
    {
        return $this->customer_identify;
    }

    public function setCustomerIdentify($customer_identify)
    {
        $this->customer_identify = $customer_identify;
    }

    public function getSeatID()
    {
        return $this->seat_id;
    }

    public function setSeatID($seat_id)
    {
        $this->seat_id = $seat_id;
    }

    public function getFlightID()
    {
        return $this->flight_id;
    }

    public function setFlightID($flight_id)
    {
        $this->flight_id = $flight_id;
    }

    public function getDepartureDay()
    {
        return $this->departure_day;
    }

    public function setDepartureDay($departure_day)
    {
        $this->departure_day = $departure_day;
    }

    public function getArriveDay()
    {
        return $this->arrive_day;
    }

    public function setArriveDay($arrive_day)
    {
        $this->arrive_day = $arrive_day;
    }

    public function getDepartureTime()
    {
        return $this->departure_time;
    }

    public function setDepartureTime($departure_time)
    {
        $this->departure_time = $departure_time;
    }

    public function getArriveTime()
    {
        return $this->arrive_time;
    }

    public function setArriveTime($arrive_time)
    {
        $this->arrive_time = $arrive_time;
    }

    public function getCustomerPhone()
    {
        return $this->customer_phone;
    }

    public function setCustomerPhone($customer_phone)
    {
        $this->customer_phone = $customer_phone;
    }

    public function getDurationTime()
    {
        return $this->duration_time;
    }

    public function setDurationTime($duration_time)
    {
        $this->duration_time = $duration_time;
    }

    public function getTripType()
    {
        return $this->trip_type;
    }

    public function setTripType($trip_type)
    {
        $this->trip_type = $trip_type;
    }
}
