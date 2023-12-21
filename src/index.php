<html lang="en">

<head>
  <title>Reel Ratings Hub</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <nav>
    <a href="index.php" style="text-decoration: none; color: black;"><h1>Reel Ratings Hub</h1></a>
    <form method="GET" action="index.php">
      <div class="search">
        <input type="text" name="title">
          <div type="submit" name="search" value="search" class="search_icon" style="cursor: pointer;">
            <i class="fa fa-search"></i>
          </div>
      </div>
    </form>
    <div class="login">
      <form class="login_form" method="POST" action="register.php">
        <button type="submit" name="login" value="login" style="cursor: pointer;">Zaloguj</button>
        <button type="submit" name="register" value="register" style="cursor: pointer;">Zarejestruj</button>
      </form>
    </div>
  </nav>
  <main>
    <div class="filter">
      <form method="GET" action="index.php">
        Filtry
        <input type="checkbox" name="filter" value="action" style="cursor: pointer;">Akcji</button>
        <input type="checkbox" name="filter" value="adventure" style="cursor: pointer;">Przygodowe</button>
        <button type="submit" style="cursor: pointer;">Filtruj</button>
        <button name="reset" value="reset" style="cursor: pointer;">Wyczyść filtry</button>
    </div>
    <div class="movies">
      <?php
      echo "<img src=assets/test.jpg/>";
      echo "<img src=assets/test.jpg/>";
      echo "<img src=assets/test.jpg/>";
      echo "<img src=assets/test.jpg/>";
      echo "<img src=assets/test.jpg/>";
      echo "<img src=assets/test.jpg/>";
      ?>
    </div>
  </main>
</body>

</html>
