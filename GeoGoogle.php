<?php

class GeoGoogle extends Weather
{
    protected string $key = '41497a61537944755441457342376d636c5731596b78316744414b6b684f395f4b4356464b734d';
    private string $country = '';
    private string $city = '';


    public function prepareUrl($lat, $long): mixed
    {
        $str = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&language=ru&result_type=country|locality&key=" . $this->apiKey;
       $result= json_decode(parent::getResponce($str));

        $this->answer = $this->answer['plus_code']['compound_code'];//беру только кусок с городом и страной!
       return   $this->answer;
    }

    public function getCity(): string
    {

        $geoArray = explode(',', $this->answer);//0- код, 1 - город, последнее - страна;
        $this->city = explode(' ', $geoArray[0])[1];
        return $this->city;
    }

    public function getCountry(): string
    {
        $geo = $this->answer;
        $geo = explode(',', $geo);
        $this->country = array_pop($geo);

        return $this->country;
    }


}