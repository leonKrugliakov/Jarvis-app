<?php

  function tellWeather(){
  $jsonurl = "http://api.openweathermap.org/data/2.5/weather?zip=63146&units=metric&APPID=ce0de60baf27ac825921e85bc1d23a9a";
  $json = file_get_contents($jsonurl);
  $weather = json_decode($json);
  $station = $weather->name;
  $humidity = $weather->main->humidity;
  $tempC = $weather->main->temp;
  $min_tempC = $weather->main->temp_min;
  $max_tempC = $weather->main->temp_max;
  echo "The current temperature in ".$station." is " . $tempC . "C at this moment.";
  }

  tellWeather();
  
?>
