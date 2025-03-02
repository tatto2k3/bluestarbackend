<?php


class EmbedData
{
    public $redirecturl;
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

    public function getRedirectUrl()
    {
        return $this->redirecturl;
    }

    public function setRedirectUrl($redirecturl)
    {
        $this->redirecturl = $redirecturl;
    }

    public function getCustomerName()
    {
        return $this->customer_name;
    }

    public function setCustomerName($customer_name)
    {
        $this->customer_name = $customer_name;
    }

    // Repeat the pattern for other properties

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

    public function getCustomerPhone()
    {
        return $this->customer_phone;
    }

    public function setCustomerPhone($customer_phone)
    {
        $this->customer_phone = $customer_phone;
    }

    // Repeat the pattern for other properties

    public function getTripType()
    {
        return $this->trip_type;
    }

    public function setTripType($trip_type)
    {
        $this->trip_type = $trip_type;
    }

    // ... Repeat for other properties ...
}
