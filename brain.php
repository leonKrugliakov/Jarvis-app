<?php

  //Imports
  require('location.php');
  require('utils.php');

  require('infrastructure.php');

  $input = strtolower($_POST["input"]);
  $location = $_POST["location"];

  $functionKeys = array(

    //Test functionKeys
    "test" => function ($input) {
      sendMessage("this is a test");
    },

    "the weather" => function ($input) {
      sendMessage(tellWeather());
    },
    "what is" => function ($in) {
      sendMessage(lookUp($in));
    },

    "define" => function ($input) {
      sendMessage(defineWord($input));
    },

    "calculate" => function($input){
      sendMessage(calculate($input));
    },

    "translate" => function ($input) {
      sendMessage(translate($input));
    },

    "play" => function($input){
      echo music($input);
    },

    "tell me the news" => function($input){
      echo news($input);
    },

    "today's date" => function ($value) {
      sendMessage("Today is " . date("l jS \of F Y"));
    },

    "what time is it" => function($value){
      sendMessage("The time is " . date("h:i A"));
    },

    "where am i" => function ($value) use ($location) {
      sendMessage(findPerson($location));
    },

    "where is" => function ($value) {
      sendMessage(findLocation($value));
    },

    "stop" => function ($value) {
      sendCommand("stop");
    },

    "location" => function ($value) use ($location) {
      sendMessage($location[latitude] . "," . $location[longitude]);
    },

    "hello" => sendWMessage("Top of the morning to ya"),

    "are you married" => sendWMessage("I am if you want me to be"),

    "can you feel" => sendWMessage("I am a form of Artifical Intellegence so NO"),

    "what's your life story" => sendWMessage("i was born in 2017 and now i serve you as your Virtual assistant, yay (sarcasm!)"),

    "who is your father" => sendWMessage("Hey no need to judge"),

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

  if (preg_match("/^\s*([-+\(\)]?)(\d+)(?:\s*([-+)(*\/])\s*((?:\s[-+)()])?\d+)\s*)+$/", trim($input, " ")) || strpos($input, '(') !== false || strpos($input, ')') !== false){
    $output = eval('return ' .$input.';');
    return $input . " = " .$output;
  }else{
    return "You entered an invalid input";
  }
}

function translate($input){

  //TODO put a example syntax
  // Translate (language) into (language)

  if (preg_match_all("/(?<=translate )(.*?)(?= into)/s", $input, $result))
    for ($i = 1; count($result) > $i; $i++) {
        $strippedInput = $result[$i][0];
  }

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

function music($input){
  $start = strpos($input, "play ") + 5;
  $item = substr($input, $start, strlen($input));
  $searchString = $item;
  $correctString = str_replace(" ","+",$searchString);
  $youtubeUrl = "https://www.youtube.com/results?search_query=". $correctString;
  $getHTML = file_get_contents($youtubeUrl);
  $pattern = '/<a href="\/watch\?v=(.*?)"/i';

  if(preg_match($pattern, $getHTML, $match)){
    $videoID = $match[1];
  } else {
    echo "Something went wrong!";
    exit;
  }

  return("<iframe width=\"560\" height=\"315\" src=\"//www.youtube.com/embed/" . $videoID ."?autoplay=1\" frameborder=\"0\" allowfullscreen></iframe>");
}

function news($input){
  $sources = array("abc-news-au", "bbc-news", "bloomberg", "business-insider", "cnbc", "cnn", "daily-mail", "espn", "financial-times",
  "google-news", "hacker-news", "independent", "national-geographic", "techcrunch", "the-economist", "the-guardian-uk",
  "the-new-york-times", "the-next-web", "the-telegraph", "the-wall-street-journal", "the-washington-post", "time", "usa-today");
  $random = rand(0, count($sources));
  $news = file_get_contents("https://newsapi.org/v1/articles?source=" . $sources[$random] . "&apiKey=38736fedc4b0460fafc18e3d9b26d00a");
  $news = json_decode($news);
  //print_r($news);
  $source = explode("-", $news->source);
  $sourceTitle = "";
  for($i = 0; $i < count($source); $i++){
    $sourceTitle = $sourceTitle . ucfirst($source[$i]) . " ";
  }

  echo "

    <table class='table table-striped table-bordered'>
      <tr>
        <th>
          Source:
          " . $sourceTitle . "
        </th>
      </tr>
      <thead class='thead-inverse'>
        <tr>
          <th>
            Title:
          </th>
          <th>
            Description:
          </th>
          <th>
            Link:
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            " . $news->articles[0]->title . "
          </td>
          <td>
            " . $news->articles[0]->description . "
          </td>
          <td>
            <a href=" . $news->articles[0]->url . ">Full article</a>
          </td>
        </tr>
        <tr>
          <td>
            " . $news->articles[1]->title . "
          </td>
          <td>
            " . $news->articles[1]->description . "
          </td>
          <td>
            <a href=" . $news->articles[1]->url . ">Full article</a>
          </td>
        </tr>
        <tr>
          <td>
            " . $news->articles[2]->title . "
          </td>
          <td>
            " . $news->articles[2]->description . "
          </td>
          <td>
            <a href=" . $news->articles[2]->url . ">Full article</a>
          </td>
        </tr>
        <tr>
          <td>
            " . $news->articles[3]->title . "
          </td>
          <td>
            " . $news->articles[3]->description . "
          </td>
          <td>
            <a href=" . $news->articles[3]->url . ">Full article</a>
          </td>
        </tr>
        <tr>
          <td>
            " . $news->articles[4]->title . "
          </td>
          <td>
            " . $news->articles[4]->description . "
          </td>
          <td>
            <a href=" . $news->articles[4]->url . ">Full article</a>
          </td>
        </tr>
        <tr>
          <td>
            " . $news->articles[5]->title . "
          </td>
          <td>
            " . $news->articles[5]->description . "
          </td>
          <td>
            <a href=" . $news->articles[5]->url . ">Full article</a>
          </td>
        </tr>
        <tr>
          <td>
            " . $news->articles[6]->title . "
          </td>
          <td>
            " . $news->articles[6]->description . "
          </td>
          <td>
            <a href=" . $news->articles[6]->url . ">Full article</a>
          </td>
        </tr>
        <tr>
          <td>
            " . $news->articles[7]->title . "
          </td>
          <td>
            " . $news->articles[7]->description . "
          </td>
          <td>
            <a href=" . $news->articles[7]->url . ">Full article</a>
          </td>
        </tr>
        <tr>
          <td>
            " . $news->articles[8]->title . "
          </td>
          <td>
            " . $news->articles[8]->description . "
          </td>
          <td>
            <a href=" . $news->articles[8]->url . ">Full article</a>
          </td>
        </tr>
      </tbody>
    </table>

  ";

}

?>
