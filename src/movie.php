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
  <title>
    <?php $title = $_GET["title"] ?>
    <?php echo $title ?></title>
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
  <main style="flex-direction: column;">
    <?php
    $qr_name = trim(implode(' ', explode('+', $_GET['title'])));
    $query = "SELECT name, genres, description FROM movies WHERE name LIKE '$qr_name'";
    $res = mysqli_query($conn, $query);
    $movie = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $movie = $movie[0];
    mysqli_free_result($res);
    $story = 80;
    $characters = 80;
    $originality = 80;
    $emotional_impact = 80;
    $total_score = ($story + $characters + $originality + $emotional_impact) / 4;
    $comments = array('bożydar' => 'A mi się podoba', 'halinka' => 'Bez sensu, tylko hejtujecie a sami byście lepiej nie zrobili'); ?>
    <div class='movie_review'>
      <div class='image' style='background-image: url("<?php echo "./assets/$movie[name].jpg" ?>");'></div>
      <div class='ratings'>
        <div class='score'>
          <h2>Other Users reviewed</h2>
          <span>Story: <?php echo $story ?></span>
          <span>Characters: <?php echo $characters ?></span>
          <span>Originality: <?php echo $originality ?></span>
          <span>Emotional Impact: <?php echo $emotional_impact ?></span>
          <span>Total score: <?php echo $total_score ?></span>
        </div>
        <p><?php echo $movie['description'] ?></p>
        <h2>Your review</h2>
        <form class='scoring' method='POST' action='movie.php'>
          <label for='story'>Story</label>
          <input type='number' min='0' max='100' name='story' placeholder='Story'>
          <label for='characters'>Characters</label>
          <input type='number' min='0' max='100' name='characters' placeholder='Characters'>
          <label for='originality'>Originality</label>
          <input type=number min='0' max='100' name='originality' placeholder='Originality'>
          <label for='emotional_impact'>Emotional Impact</label>
          <input type='number' min='0' max='100' name='emotional_impact' placeholder='Emotional Impact'>
          <button type='submit'>Prześlij</button>
        </form>
      </div>
      <div class='comments'>
        <form class='comment_form' method='POST' action='movie.php'>
          <label for='comment'>
            <h2>Write your thoughts</h2>
          </label>
          <textarea name='comment' placeholder="What did you like/dislike about the movie?">
    </textarea>
          <button type='submit'>Prześlij</button>
        </form>
        <?php foreach ($comments as $key => $value) { ?>
          <div class='comment'>
            <span>
              <h4><?php echo $key ?></h4>
            </span>
            <p><?php echo $value ?></p>
          </div>
        <?php } ?>
      </div>
    </div>
  </main>
</body>

</html>
