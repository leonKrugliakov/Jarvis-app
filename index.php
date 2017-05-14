<DOCTYPE html>

<html>

<head>
  <title>Jarvis</title>

  <style>
  @import url(https://fonts.googleapis.com/css?family=Open+Sans);

  body{
    background: #f2f2f2;
    font-family: 'Open Sans', sans-serif;
  }

  .search {
    width: 100%;
    position: relative
  }

  .searchTerm {
    float: left;
    width: 100%;
    border: 3px solid #00B4CC;
    padding: 5px;
    height: 40px;
    border-radius: 5px;
    outline: none;
    color: #9DBFAF;
  }

  .searchTerm:focus{
    color: #00B4CC;
  }

  .searchButton {
    position: absolute;
    margin-left: 10em;
    right: -50px;
    width: 100px;
    height: 38px;
    border: 1px solid #00B4CC;
    background: #00B4CC;
    text-align: center;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    font-size: 20px;
  }

  /*Resize the wrap to see the search bar change!*/
  .wrap{
    width: 30%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  h1{text-align: center;}
  h2{text-align: center; margin-top: -5%;}

  img.center {
   display: block;
   margin-left: auto;
   margin-right: auto;
   width: 20em;
  }
  </style>
</head>

<body>


    <img src="logo.png" class="center"/>



    <div class="wrap">
       <div class="search">
         <form method="POST" action="brain.php">
           <input type="text" name="input" class="searchTerm" placeholder="Ask me Anything..." />
           <input type="submit" class="searchButton" />
         </form>

       </div>
    </div>

</body>

</html>
