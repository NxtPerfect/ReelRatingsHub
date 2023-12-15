<html lang="en">

<head>
  <title>Reel Ratings Hub</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
  <h1>Reel Ratings Hub</h1>
  <nav>
    <div class="search">Wyszukaj Tytuł</div>
    <div class="filter">Filtry</div>
    <form method="POST" action="index.php">
      <input type="submit" name="login" value="Zaloguj">
      <input type="submit" name="register" value="Dołącz">
    </form>
  </nav>
  <div class="movies">Filmy</div>
  <?php
  if (isset($_POST['login'])) {
    echo "Login";
  }
  if (isset($_POST['register'])) {
    echo ('<form method="POST"> <input type="text" name="name"><input type="password" name="password">');
  }
  ?>
</body>

</html>
