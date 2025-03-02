<?php

class Utils
{
    public static function getTimeStamp($date = null)
    {
        if ($date === null) {
            $date = new \DateTime();
        }

        return (int)($date->format('U.u') * 1000);
    }
}
