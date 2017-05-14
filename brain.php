<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYngkuESFSn8WI_0gCWfsB9e2f3xvaj30&libraries=places"></script>

<?php

  $input = $_POST["input"];

  function regularResponse($message) {

    return function($value) use ($message) {
      echo $message;
    };

  }

  $functionKeys = array(
    "weather" => function ($input) {
        echo tellWeather();
    },
    "what is" => function ($in) {
      echo lookUp($in);
    },

    "define" => function ($input) {
      echo defineWord($input);
    },

    "Hello" => regularResponse("Top of the morning to ya"),

    "today's date" => function ($value) {
      echo "Today is " . date("l jS \of F Y");
    },

    "what time is it" => function($value){
      echo "The time is " . date("h:i A");
    },

    "are you married" => regularResponse("I am if you want me to be"),

    "can you feel" => regularResponse("I am a form of Artifical Intellegence so NO"),

    "what's your life story" => regularResponse("i was born in 2017 and now i serve you as your Virtual assistant, yay (sarcasm!)"),

    "who is your father" => regularResponse("Hey no need to judge"),

  );

  foreach($functionKeys as $key => $value){
    if(strpos($input, $key) !== false){
      $functionKeys[$key]($input);
    }
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

?>
