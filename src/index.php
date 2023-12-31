<?php
// read filters from database
$databasename = '127.0.0.1';
$username = 'root';
$password = '';
$conn = new mysqli($databasename, $username, $password, 'ReelRatingsHub');

if (!$conn) {
  die("Connection failed: " . $conn->connect_error);
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
    <a href="index.php" style="text-decoration: none; color: black;">
      <h1>Reel Ratings Hub</h1>
    </a>
    <form class="search" method="GET" action="index.php">
      <input type="text" name="title" placeholder="Search movie name">
      <div type="submit" name="search" value="search" class="search_icon" style="cursor: pointer;">
        <i class="fa fa-search"></i>
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
        <h3>Filtry</h3>
        <?php
        $query = 'SELECT DISTINCT genres FROM movies ORDER BY genres';
        $res = mysqli_query($conn, $query);
        $filters = mysqli_fetch_all($res, MYSQLI_ASSOC);
        mysqli_free_result($res);
        foreach ($filters as $filter) {
          foreach ($filter as $f) { ?>
            <button class='filter_element_button' id='action' type='submit' name='filter' value=<?php echo $f ?> style='cursor: pointer;'><?php echo ucwords($f) ?></button>
        <?php }
        } ?>
        <button class="filter_element_reset" name="reset" value="reset" style="cursor: pointer;">Wyczyść filtry</button>
      </form>
    </div>
    <div class="movies">
      <?php
      $active_filter = $_GET['filter'];
      $query = 'SELECT name, genres, description FROM movies ORDER BY name';
      if (isset($active_filter)) {
        $query = "SELECT name, genres, description FROM movies WHERE genres LIKE '$active_filter' ORDER BY name";
      }
      $res = mysqli_query($conn, $query);
      $movies = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      foreach ($movies as $val) { ?>
        <div class='image' style='background-image: url("<?php echo "./assets/$val[name].jpg" ?>");'>
          <div class='image_info'>
            <h3><?php echo ucwords($val['name']) ?></h3>
            <p><?php echo $val['description'] ?></p>
            <form method='GET' action='movie.php'>
              <button class='review_button' type='submit' name='title' value='<?php echo $val['name'] ?>'>Review</button>
            </form>
          </div>
        </div>
      <?php } ?>
    </div>
  </main>
</body>

</html>
