<?php

$input = $_POST["input"];

function lookup($input){
  $input = $input;
  $start = strpos($input, "what is ") + 8;
  $item = substr($input, $start, strlen($input));
  $askArray = explode(" ", $item);
  $finalThing = "";

  for($i = 0; $i < sizeof($askArray); $i++){
    $finalThing = $askArray[$i] . "+";
  }


  $jsonurl="https://en.wikipedia.org/w/api.php?action=opensearch&search=" . $finalThing . "&limit=1&namespace=0&format=json";
  $json = file_get_contents($jsonurl);
  //echo $json . "<br /><br />";
  $lookedUpInfo = "";

  $counter = 0;
  for($i = 0; $counter < 5; $i++){
    if(strpos($json[$i], '"') !== false){
      $counter++;
    }
    if($counter === 5){
      $start = $i + 1;
      $endIt = 0;
      $end = 0;
      for($x = $start; $endIt < 1; $x++){
        if(strpos($json[$x], '"') !== false){
          $endIt = 1;
          $end = $x;
          $end;
        }
      }
      $lookedUpInfo = substr($json, $start, $end - $start);
    }
  }
  echo $lookedUpInfo;
}

lookUp($input);

?>
