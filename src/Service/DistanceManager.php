<?php


namespace App\Service;


use App\Entity\Location;

class DistanceManager
{
    public static function getDrivingDistance(Location $point, Location $destination)
    {

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins="
            .$point->latitude().",".$point->longitude()."&destinations="
            .$destination->latitude().",".$destination->longitude()
            ."&mode=driving";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);

        print_r($response_a); die();

    }
}