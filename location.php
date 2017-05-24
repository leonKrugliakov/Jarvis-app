<?php

function getKeys() {
  $keys_data = file_get_contents("./keys.json");
  $keys = json_decode($keys_data);

  return $keys;
}



function findPerson($location) {
  $keys = getKeys();
  $googlekey = $keys->googlemaps;
  $request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='. $location[latitude] .','. $location[longitude] .'&sensor=false&location_type=ROOFTOP&result_type=street_address&key='. $keys->googlemaps;

  $loco = file_get_contents($request);
  $yourloco = json_decode($loco)->results[0]->formatted_address;
  echo "Your location is " . $yourloco;

}

//TODO finish loco

function findLocation($input) {

  $keys = getKeys();

  $startphrase = "where is ";
  $start = strpos($input, $startphrase) + strlen($startphrase);
  $address = substr($input, $start, strlen($input));

  $request = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=' . $keys->googlemaps;

  $loco_data = file_get_contents($request);
  $parsed_loco = json_decode($loco_data);
  $geometry = $parsed_loco->results[0]->geometry;

  $latitude = $geometry->location->lat;
  $longitude = $geometry->location->lng;

  $message = "You are located at " . $latitude . " latitude and " . $longitude . " longitude.";

  echo $message;

}

 ?>
