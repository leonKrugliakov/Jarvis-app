<?php

function findPerson($location) {
  $json = file_get_contents("./keys.json");
  $keys = json_decode($json);
  $googlekey = $keys->googlemaps;
  $request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='. $location[latitude] .','. $location[longitude] .'&sensor=false&location_type=ROOFTOP&result_type=street_address&key='. $keys->googlemaps;

  $loco = file_get_contents($request);
  $yourloco = json_decode($loco)->results[0]->formatted_address;
  echo "Your location is " . $yourloco;

}

function findLocation($input) {
  $startphrase = "where is ";
  $start = strpos($input, $startphrase) + strlen($startphrase);
  $item = substr($input, $start, strlen($input));

  echo $item;

}

 ?>
