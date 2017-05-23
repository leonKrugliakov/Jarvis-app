function outputMessage(message) {
  $("#output").html("");
  $("#output").append(message);
}

function speekMessage(message) {
  if ('speechSynthesis' in window) {
    var msg = new SpeechSynthesisUtterance(message);
    window.speechSynthesis.speak(msg);
  }else {
    console.log("unable to use speech synth");
  }
}

$(document).ready(function () {
  $("#searchForm").submit(function (e) {
    e.preventDefault();
    var inputstring = $("#searchInput").val();
    $.ajax({
      type: "POST",
      url: "./brain.php",
      data: {"input": inputstring},
    }).done (function (data) {
      console.log(data);

      outputMessage(data);

      if (data.includes("<iframe>") == false) {
        speekMessage(data);
      }

    })
  });
});
