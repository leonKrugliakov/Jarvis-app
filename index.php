<DOCTYPE html>

<html>

<head>
  <title>Jarvis</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Jquery -->
  <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

  <script src = "./src/main.js"></script>

  <link rel = "stylesheet" type = "text/css" href = "style/main.css">

</head>

<body>

    <div class = "container-fluid">
      <div class = "text-center">
        <img src="logo.png" class="img-fluid center-text"/>
      </div>

      <div class = "text-center">

             <form method = "post" action = "" id = "searchForm">
               <input id = "searchInput" type="text" name="input" class="form-control searchTerm" placeholder="Ask me Anything..." />
               <input id = "searchButton" type="submit" class="btn btn-primary searchButton" />
             </form>

      </div>

      <b><p class = "text-center" id = "output"></p></b>

    </div>

</body>

</html>
