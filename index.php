<DOCTYPE html>

<html>

<head>
  <title>Jarvis</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

  <link rel = "stylesheet" type = "text/css" href = "style/main.css">

</head>

<body>

    <div class = "container-fluid">
      <div class = "text-center">
        <img src="logo.png" class="img-fluid center-text"/>
      </div>

      <div class = "text-center">

             <form method="POST" action="brain.php">
               <input type="text" name="input" class="form-control searchTerm" placeholder="Ask me Anything..." />
               <input type="submit" class="btn btn-primary searchButton" />
             </form>

      </div>

    </div>

</body>

</html>
