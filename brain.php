<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYngkuESFSn8WI_0gCWfsB9e2f3xvaj30&libraries=places"></script>

<?php

  $input = $_POST["input"];

  switch($input){
    case (strpos($input, "weather") !== false):
      tellWeather();
      break;
    case (strpos($input, "what is") !== false):
      lookUp($input);
      break;
    case (strpos($input, "define") !== false):
      defineWord($input);
      break;
    case (strpos($input, "hello") !== false):
      greet($input);
      break;
    case (strpos($input, "today's date") !== false):
      todayDate($input);
      break;
    case (strpos($input, "what time is it") !== false):
      todayTime($input);
      break;
    case (strpos($input, "what is") !== false):
      lookUp($input);
      break;
    case (strpos($input, "are you married") !== false):
      married($input);
      break;
    case (strpos($input, "can you feel") !== false):
      feel($input);
      break;
    case (strpos($input, "what's your life story") !== false):
      lifeStory($input);
      break;
    case (strpos($input, "who is your father") !== false):
      yourFather($input);
      break;
    case (strpos($input, "plus" || "minus" || "times" || "devided") !== false):
      calculate($input);
      break;
  };


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
    $lookedUpInfo = explode(']', $json);
    $lookedUpInfo = $lookedUpInfo[1];
    $lookedUpInfo = substr($lookedUpInfo, 3, (strlen($lookedUpInfo)-4));

    echo $lookedUpInfo;
  }

  function defineWord($input){
    $input = substr($input, (strpos($input, "define") + 7));
    $thing = "http://api.wordnik.com:80/v4/word.json/" . $input . "/definitions?limit=200&includeRelated=true&useCanonical=false&includeTags=false&api_key=e4906f30d12a264c87b33d67db55b33fe87e268b94a52e08f";
    $json = file_get_contents($thing);
    $json = json_decode($json);
    echo $json[0]->text;
  }

  function calculate($input){

  }



  function greet(){
    echo "Top of the morning to ya";
  }

  function todayDate(){
    echo "Today is " . date("l jS \of F Y");
  }

  function todayTime(){
    echo "The time is " . date("h:i A");
  }

  function married(){
    echo "I am if you want me to be ";
  }

  function feel(){
    echo "I am a form of Artifical Intellegence so NO ";
  }

  function lifeStory(){
    echo "i was born in 2017 and now i serve you as your Virtual assistant, yay (sarcasm!) ";
  }

  function yourFather(){
    echo "Hey no need to judge";
  }


?>
