<?php

function regularResponse($message) {
  return function($value) use ($message) {
    echo $message;
  };

}

 ?>
