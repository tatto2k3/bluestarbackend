<?php



class CallBackParameter
{
    public $data;
    public $mac;
    public $type;

    public function __construct($data, $mac, $type)
    {
        $this->data = $data;
        $this->mac = $mac;
        $this->type = $type;
    }
}
