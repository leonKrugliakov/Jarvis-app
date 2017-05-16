$(document).ready(function () {

  $("#searchButton").click (function () {

    var inputstring = $("#searchInput").val();

    $.ajax({
      type: "POST",
      url: "./brain.php",
      data: {"input": inputstring},
      success: function (data) {
        console.log(data);
      }
    })

  });

});
