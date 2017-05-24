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

function stopSpeek() {
  if ('speechSynthesis' in window) {
    window.speechSynthesis.cancel();
  }else {
    console.log("unable to use speech synth");
  }
}

//TODO turn this into a promise

function getLocation() {

  let locationPromise = new Promise((resolve, reject) => {
    if (navigator.geolocation) {
      var pos = navigator.geolocation.getCurrentPosition(function (value) {
        var loco = {"latitude": value.coords.latitude, "longitude": value.coords.longitude}
        resolve(loco);
      });
    }else {
      reject("geo location not usuable")
    }
  });

  return locationPromise;

}

function submitData(input_data) {

  var inputstring = input_data.inputstring;
  var location = input_data.location;
  console.log(location);

  $.ajax({
    type: "POST",
    url: "./brain.php",
    data: {"input": inputstring, "location": location},
  }).done (function (data) {
    console.log(data);


    if (data.includes("stop voice") == false) {
      outputMessage(data);

      if (data.includes("<iframe>") == false) {
        speekMessage(data);
      }
    }else {
      stopSpeek();
    }

  })
}

$(document).ready(function () {
  $("#searchForm").submit(function (e) {
    e.preventDefault();

    var inputstring = $("#searchInput").val();

    getLocation().then (function (location) {
      var input_data = {"inputstring": inputstring,
                        "location": location};
      submitData(input_data)
    }).catch (function (reason) {
      var location = {"latitude": 0, "longitude": 0}
      var input_data = {"inputstring": inputstring,
                        "location": location};
      console.log(reason);
    });


  });
});
