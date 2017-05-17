function outputMessage(message) {
  $("#output").text(message);
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
      outputMessage(data);
    })
  });



});
