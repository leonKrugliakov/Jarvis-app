function outputMessage(message) {
  $("#output").html("");
  $("#output").append("<p>" + message + "</p>");
}

function outputHtmlMessage(html) {
  $("#output").html("");
  $("#output").append(html);
}

function showCommands(){
  var commands = ["tell me the weather - tells the weather \n", "what is ... - explains what ... is\n", "who is ... - explains who ... is\n",
                   "define ... - gives you a definition of ...\n", "calculate x + y / z - calculate the math problem (cannot do complex functions such as square root or powers\n",
                   "translate ... to ,,, - translates ... into the language ,,,\n", "play ... - plays the song ...\n", "today's date - returns today's date\n",
                   "what time is it - returns the current time\n"];
  alert(commands);
}

function speekMessage(message) {
  if ('speechSynthesis' in window) {
    var msg = new SpeechSynthesisUtterance(message);
    window.speechSynthesis.speak(msg);
  }else {
    console.log("unable to use speech synth");
  }
}

function stopSpeek() {
  if ('speechSynthesis' in window) {
    window.speechSynthesis.cancel();
  }else {
    console.log("unable to use speech synth");
  }
}


function submitData(input_data) {

  var inputstring = input_data.inputstring;
  var location = input_data.location;

  $.ajax({
    type: "POST",
    url: "./brain.php",
    data: {"input": inputstring},
  }).done (function (data) {

    var json_data = JSON.parse(data);
    console.log(data);

    switch (json_data.type){
      case "message":
        outputMessage(json_data.message);
        speekMessage(json_data.message);
        break;
      case "html":
        outputHtmlMessage(json_data.html);
        break;

      case "command":

        //DEBUG
        console.log("command: " + json_data.command);

        if (json_data.command == "stop") {
          stopSpeek();
        }

        break;


      default:
        console.log("I dunno");
    }



    /**if (data.includes("stop voice") == false) {
      outputMessage(data);

      if (data.includes("<iframe>") == false) {
        speekMessage(data);
      }
    }else {
      stopSpeek();
    }**/

  })
}

$(document).ready(function () {
  $("#searchForm").submit(function (e) {
    e.preventDefault();

    var inputstring = $("#searchInput").val();

    var work = function () {
      var input_data = {"inputstring": inputstring};
      submitData(input_data);
    };

    work();


  });
});
