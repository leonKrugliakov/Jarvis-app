<?php

  $input = strtolower($_POST["input"]);

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

    "calculate" => function($input){
      echo calculate($input);
    },

    "translate" => function ($input) {
      echo translate($input);
    },

    "hello" => regularResponse("Top of the morning to ya"),

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
  $start = strpos($input, "what is ") + 8;
  $item = substr($input, $start, strlen($input));
  $askArray = explode(" ", $item);
  $finalThing = "";
  for($i = 0; $i < sizeof($askArray); $i++){
    $finalThing = $askArray[$i] . "+";
  }
  $jsonurl="https://en.wikipedia.org/w/api.php?action=opensearch&search=" . $finalThing . "&limit=1&namespace=0&format=json";
  $json = file_get_contents($jsonurl);
  $lookedUpInfo = json_decode($json);
  $lookedUpInfo = $lookedUpInfo[2][0];
  //echo $lookedUpInfo . "<br /><br />";
  echo $lookedUpInfo;
}
function defineWord($input){
  $input = substr($input, (strpos($input, "define") + 7));
  $thing = "http://api.wordnik.com:80/v4/word.json/" . $input . "/definitions?limit=200&includeRelated=true&useCanonical=false&includeTags=false&api_key=e4906f30d12a264c87b33d67db55b33fe87e268b94a52e08f";
  $json = file_get_contents($thing);
  $json = json_decode($json);
  echo $json[0]->text;
}
function calculate($value){
  $start = strpos($value, "calculate ") + 10;
  $input = substr($value, $start, strlen($value));
  echo $input . "=";
  if (preg_match("/^\s*([-+\(\)]?)(\d+)(?:\s*([-+)(*\/])\s*((?:\s[-+)()])?\d+)\s*)+$/", trim($input, " ")) || strpos($input, '(') !== false || strpos($input, ')') !== false){
    $output = eval("echo " . $input . ";");
  }else{
    echo "You entered an invalid input";
  }
}

  function translate($input){
    if (preg_match_all("/(?<=translate )(.*?)(?= into)/s", $input, $result))
      for ($i = 1; count($result) > $i; $i++) {
          $strippedInput = $result[$i][0];
    }
    //echo urlencode($strippedInput) . "      ";
    $json= file_get_contents("http://www.transltr.org/api/getlanguagesfortranslate") or die("Error: Cannot create object");
    $json = json_decode($json);

    $langCode = "";
    $langTo = "";

    for($i = 0; $i < count($json); $i++){
      if(strpos(ucwords($input), $json[$i]->languageName) !== false){
        $langCode = $json[$i]->languageCode;
        $langTo = $json[$i]->languageName;
      }
    }

    $translated = file_get_contents("https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20170515T040121Z.de6ac212a5c4eb10.bc06fb92bb4de8f21363bea037ca320aef2aea46&text=" . urlencode($strippedInput) . "&lang=" . $langCode . "&[format=plain]&[options=0]&[callback=]");
    $translated = json_decode($translated);
     echo $strippedInput . " in " . $langTo . " is " . $translated->text[0];
}

?>
