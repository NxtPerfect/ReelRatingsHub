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
        // read filters from database
        $filters = array('action' => "Akcji", 'adventure' => "Przygodowe");
        foreach ($filters as $key => $value) {
          echo "<button class='filter_element_button' id=action type=submit name=filter value=$key style='cursor: pointer;'>$value</button>";
        }
        ?>
        <button class="filter_element_reset" name="reset" value="reset" style="cursor: pointer;">Wyczyść filtry</button>
      </form>
    </div>
    <div class="movies">
      <?php
      // foreach item in database -> render div
      $url = 'assets/test.jpg';
      echo "<div class=image style='background-image: url($url);'><div class=image_info><h3>Top Gun</h3><p>Lorem ipsum dolor sit amet, qui minim labore adipisicing minim sint cillum sint consectetur cupidatat.</p><form method=GET action=movie.php><button class=review_button type=submit name=title value='Top Gun'>Review</button></form></div></div>";
      echo "<div class=image style='background-image: url($url);'><div class=image_info><h3>Top Gun</h3><p>Lorem ipsum dolor sit amet, qui minim labore adipisicing minim sint cillum sint consectetur cupidatat.</p><form method=GET action=movie.php><button class=review_button type=submit name=title value='Top Gun'>Review</button></form></div></div>";
      echo "<div class=image style='background-image: url($url);'><div class=image_info><h3>Top Gun</h3><p>Lorem ipsum dolor sit amet, qui minim labore adipisicing minim sint cillum sint consectetur cupidatat.</p><form method=GET action=movie.php><button class=review_button type=submit name=title value='Top Gun'>Review</button></form></div></div>";
      echo "<div class=image style='background-image: url($url);'><div class=image_info><h3>Top Gun</h3><p>Lorem ipsum dolor sit amet, qui minim labore adipisicing minim sint cillum sint consectetur cupidatat.</p><form method=GET action=movie.php><button class=review_button type=submit name=title value='Top Gun'>Review</button></form></div></div>";
      echo "<div class=image style='background-image: url($url);'><div class=image_info><h3>Top Gun</h3><p>Lorem ipsum dolor sit amet, qui minim labore adipisicing minim sint cillum sint consectetur cupidatat.</p><form method=GET action=movie.php><button class=review_button type=submit name=title value='Top Gun'>Review</button></form></div></div>";
      echo "<div class=image style='background-image: url($url);'><div class=image_info><h3>Top Gun</h3><p>Lorem ipsum dolor sit amet, qui minim labore adipisicing minim sint cillum sint consectetur cupidatat.</p><form method=GET action=movie.php><button class=review_button type=submit name=title value='Top Gun'>Review</button></form></div></div>";
      echo "<div class=image style='background-image: url($url);'><div class=image_info><h3>Top Gun</h3><p>Lorem ipsum dolor sit amet, qui minim labore adipisicing minim sint cillum sint consectetur cupidatat.</p><form method=GET action=movie.php><button class=review_button type=submit name=title value='Top Gun'>Review</button></form></div></div>";
      ?>
    </div>
  </main>
</body>

</html>
