<?php

function sendMessage($message) {

  $data = array(
    "type" => "message",
    "message" => $message
  );

  $json_data = json_encode($data);

  echo $json_data;

}

function sendHtml($html) {

  $data = array(
    "type" => "html",
    "html" => $html
  );

  $json_data = json_encode($data);
  echo $json_data;

}

















 ?>
