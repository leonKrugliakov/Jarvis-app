<?php

function returnData($data) {
  $json_data = json_encode($data);
  echo $json_data;
}


function sendMessage($message) {

  $data = array(
    "type" => "message",
    "message" => $message
  );

  echo returnData($data);

}

function sendWrappedMessage($message) {

  return function() use ($message) {
    sendMessage($message);
  };

}

function sendWMessage($message) {
  return sendWrappedMessage($message);
}


function sendCommand($command) {
  $data = array(
    "type" => "command",
    "command" => $command
  );

  echo returnData($data);

}

function sendHtml($html) {

  $data = array(
    "type" => "html",
    "html" => $html
  );

  echo returnData($data);

}

















 ?>
