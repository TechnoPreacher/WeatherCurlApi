<?php

class Weather
{
    protected string $key = '6636663435306461356561323838313137366238326532386135383135396463';
    protected string $apiKey = '';
    protected $answer;
    private $temp;
    private $hum;

    public function __construct()
    {
        $this->apiKey = hex2bin($this->key);
    }

    public function prepareUrl($lat, $long): mixed
    {
        $str = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$long&units=metric&lang=uk_UA&appid=" . $this->apiKey;
        return $this->getResponce($str);
    }

    public function getResponce(string $url): mixed
    {
        $cURL = curl_init($url);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);//не плюёся в браузер
        $bufRates = curl_exec($cURL);//выполнили
        curl_close($cURL);//закрыли
        $this->answer = json_decode($bufRates, true);
        return ($bufRates);//массив из жсон-строки;
    }

    public function getTemp()
    {
        $this->temp="";
        //$tempFeel = $data['main']['feels_like'];
        if (isset( $this->answer['main']['temp']))
        $this->temp = $this->answer['main']['temp'];
        return $this->temp;
    }

    public function getHum()
    {
        $this->hum ="";
        if (isset( $this->answer['main']['humidity']))
        $this->hum = $this->answer['main']['humidity'];
        return $this->hum;
    }


}