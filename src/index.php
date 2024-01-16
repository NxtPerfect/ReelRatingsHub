<?php
session_start(); // Rozpoczęcie sesji, potrzebne do logowania/wylogowania
$databasename = '127.0.0.1'; // wprowadzenie danych potrzebnych do połączenia z SQL
$username = 'root';
$password = '';
$conn = new mysqli($databasename, $username, $password, 'ReelRatingsHub'); // Połączenie z bazą danych

if (!$conn) { // Jeśli wystąpił problem, kończy wykonywanie pliku i wypisuje problem na stronie
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['search'])) { // Jeśli wpiszemy coś w wyszukiwarkę, wybierz nazwę filmu z bazy danych
  $_movie_name = $_GET['search'];
  $query = "SELECT * FROM movies WHERE name LIKE '%$_movie_name%'";
  echo $query;
  $res = mysqli_query($conn, $query);
  $movies = mysqli_fetch_all($res, MYSQLI_ASSOC);
  mysqli_free_result($res); // Uwalnia pamięć powiązaną z daną
}

if (isset($_POST['logout'])) { // Jeśli chcemy się wylogować, usunie parametr sesji, oraz przeniesie do strony głównej
  session_unset();
  unset($_SESSION['username']);
  header("Location: index.php");
  exit();
}
?>


<html lang="en">

<head>
  <title>Reel Ratings Hub</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
</head>

<body>
  <nav>
    <a href=index.php style='text-decoration: none;' color: black;>
      <h1>Reel Ratings Hub</h1>
    </a>
    <form class=search method=GET action=#>
      <input name=search type=text name=title placeholder='Search movie name'>
      <button type=submit class=search_icon style='cursor: pointer;'>
        <i class='fa fa-search'></i>
      </button>
    </form>
    <?php if (isset($_SESSION['username'])) { // Jeśli użytkownik jest zalogowany, pokaż przycisk wyloguj, nazwę oraz ikonkę
      echo "
    <div class=login>
<svg xmlns='http://www.w3.org/2000/svg' height=16 width=14 viewBox='0 0 448 512'><path d='M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z'/></svg>
      $_SESSION[username]
      <form method=post action=index.php>
        <button type=submit name=logout >Wyloguj</input>
      </form>
    </div>
    ";
    } else { // Jeśli nie, pokaż przycisk logowania i rejestracji
      echo "
    <div class=login>
      <form class=login_form method=POST action=register.php>
        <button type=submit name=login value=login style=cursor: pointer;>Zaloguj</button>
        <button type=submit name=register value=register style=cursor: pointer;>Zarejestruj</button>
      </form>
    </div>";
    } ?>
  </nav>
  <main>
    <div class="filter">
      <form method="GET" action="index.php">
        <h3>Filtry</h3>
        <?php // Wypisz wszystkie gatunki jako filtry po lewej na stronie głównej
        $query = 'SELECT * FROM genres ORDER BY genre';
        $res = mysqli_query($conn, $query);
        $filters = mysqli_fetch_all($res, MYSQLI_ASSOC);
        mysqli_free_result($res);
        foreach ($filters as $filter) { // Dla każdego gatunku pokaż przycisk wraz z poprawną wartością gatunku
          foreach ($filter as $f) { ?>
            <button class='filter_element_button' id='action' type='submit' name='filter' value=<?php echo $f ?> style='cursor: pointer;'><?php echo ucwords($f) ?></button>
        <?php }
        } ?>
        <button class="filter_element_reset" name="reset" value="reset" style="cursor: pointer;">Wyczyść filtry</button>
      </form>
    </div>
    <div class="movies">
      <?php // Przefiltruj filmy po wybranym gatunku, jeśli został ustawiony
      $active_filter = $_GET['filter'];
      $query = 'SELECT name, genres, description FROM movies ORDER BY name';
      if (isset($active_filter)) {
        $query = "SELECT name, genres, description FROM movies WHERE genres LIKE '$active_filter' ORDER BY name";
      }
      $res = mysqli_query($conn, $query);
      if (!isset($_movie_name)) { // Jeśli nie wyszukujemy filmu, pokaż wszystkie
        $movies = mysqli_fetch_all($res, MYSQLI_ASSOC);
      }
      mysqli_free_result($res);
      foreach ($movies as $val) { // Wyświetlenie karty filmu, z tytułem, opisem, odpowiednim plakatem oraz przyciskiem do oceny
      ?>
        <div class='image' style='background-image: url("<?php echo "./assets/$val[name].jpg" ?>");'>
          <div class='image_info'>
            <h3><?php echo ucwords($val['name']) ?></h3>
            <p><?php echo $val['description'] ?></p>
            <form method='GET' action='movie.php'>
              <button class='review_button' type='submit' name='title' value='<?php echo $val['name'] ?>'>Oceń</button>
            </form>
          </div>
        </div>
      <?php } ?>
    </div>
  </main>
</body>

</html>
