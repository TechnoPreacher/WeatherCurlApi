<?php

class Weather
{
   private string $key='4dff0a6b68edea6cd84c605eaa1fe43b';
   private string $lat = '46.4775';
    private string $long = '30.7326';


    public function allRates($lat,$lng)
    {

      $str = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lng&units=metric&lang=uk_UA&appid=".$this->key;

        $cURL = curl_init($str);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);//не плюёся в браузер
        $bufRates = curl_exec($cURL);//выполнили
        curl_close($cURL);//закрыли
        return ($bufRates);//массив из жсон-строки;
    }


}