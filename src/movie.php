<?php
session_start();
// read filters from database
$databasename = '127.0.0.1';
$username = 'root';
$password = '';
$conn = new mysqli($databasename, $username, $password, 'ReelRatingsHub');

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['title'])) {
    $title = $_GET['title'];
    $_SESSION['title'] = $title;
    $qr_name = trim(implode(' ', explode('+', $title)));
    $query = "SELECT id, name, genres, description FROM movies WHERE name LIKE '$qr_name'";
    $res = mysqli_query($conn, $query);
    $movie = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $movie = $movie[0];
    mysqli_free_result($res);
} elseif (isset($_SESSION['title'])) {
    $title = $_SESSION['title'];
    $query = "SELECT id, name, genres, description FROM movies WHERE name LIKE '$title'";
    $res = mysqli_query($conn, $query);
    $movie = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $movie = $movie[0];
    mysqli_free_result($res);
}

$user_id = 1;
$movie_id = $movie['id'];

// create review
if (isset($_POST['story']) && isset($_POST['characters']) && isset($_POST['originality']) && isset($_POST['emotional'])) {
    // if not logged in, return error
    // else check if already in database
    // if not, insert
    $_story = intval($_POST['story']);
    $_characters = intval($_POST['characters']);
    $_originality = intval($_POST['originality']);
    $_emotional = intval($_POST['emotional']);
    $query = "INSERT INTO reviews (id, user_id, movie_id, story, characters, originality, emotional) VALUES (NULL, $user_id, $movie_id, $_story, $_characters, $_originality, $_emotional);";
    if ($conn->query($query) === false) {
        echo "Error" . $query . " " . $conn->error;
    }
}

// send comment
if (isset($_POST['content'])) {
    $username = 'error';
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    } elseif (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
    $content = $_POST['content'];
    if (strlen($_POST['content']) > 250) {
        $content = substr($_POST['content'], 0, 250);
    }
    $query = "INSERT INTO comments (id, movie_id, username, content) VALUES (NULL, $movie_id, '$username', '$content');";
    if ($conn->query($query) === false) {
        echo "Error" . $query . " " . $conn->error;
    }
}
?>

<html lang="en">

<head>
  <title>
    <?php echo ucwords($title); ?></title>
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
    $query = "SELECT * FROM reviews WHERE movie_id LIKE '$movie[id]'";
$res = mysqli_query($conn, $query);
$reviews = mysqli_fetch_all($res, MYSQLI_ASSOC);
mysqli_free_result($res);
$story = 0;
$characters = 0;
$originality = 0;
$emotional = 0;
for ($i = 0; $i < count($reviews); $i++) {
    $story += $reviews[$i]['story'];
    $characters += $reviews[$i]['characters'];
    $originality += $reviews[$i]['originality'];
    $emotional += $reviews[$i]['emotional'];
}
$story = $story / count($reviews);
$chracters = $characters / count($reviews);
$originality = $originality / count($reviews);
$emotional = $emotional / count($reviews);
$total_score = ($story + $characters + $originality + $emotional) / 4;
$query = "SELECT * FROM comments WHERE movie_id LIKE '$movie[id]'";
$res = mysqli_query($conn, $query);
$comments = mysqli_fetch_all($res, MYSQLI_ASSOC);
mysqli_free_result($res); ?>
    <div class='movie_review'>
      <div class='image' style='background-image: url("<?php echo "./assets/$movie[name].jpg" ?>");'></div>
      <div class='ratings'>
        <div class='score'>
          <h2>Other Users reviewed</h2>
          <span>Story: <?php echo number_format((float)$story, 2) ?></span>
          <span>Characters: <?php echo number_format((float)$characters, 2) ?></span>
          <span>Originality: <?php echo number_format((float)$originality, 2) ?></span>
          <span>Emotional Impact: <?php echo number_format((float)$emotional, 2) ?></span>
          <span>Total score: <?php echo number_format((float)$total_score, 2) ?></span>
        </div>
        <?php if (isset($_SESSION['username'])) {
            $query = "SELECT * FROM reviews WHERE user_id LIKE $user_id AND movie_id LIKE $movie_id;";
            $res = mysqli_query($conn, $query);
            $personal_review = mysqli_fetch_all($res, MYSQLI_ASSOC);
            $personal_review = $personal_review[0];
            $personal_story = number_format((float)$personal_review['story'], 2);
            $personal_characters = number_format((float)$personal_review['characters'], 2);
            $personal_originality = number_format((float)$personal_review['originality'], 2);
            $personal_emotional = number_format((float)$personal_review['emotional'], 2);
            mysqli_free_result($res);
            $personal_total_score = number_format((float)($personal_review['story'] + $personal_review['characters'] + $personal_review['originality'] + $personal_review['emotional']) / 4, 2);
            echo "<div class='score'>";
            echo "<h2>You reviewed</h2>";
            echo "<span>Story: $personal_story </span>";
            echo "<span>Characters: $personal_characters </span>";
            echo "<span>Originality:  $personal_originality </span>";
            echo "<span>Emotional Impact:  $personal_emotional </span>";
            echo "<span>Total score: $personal_total_score </span>";
            echo "</div>";
        } ?>
        <p><?php echo $movie['description'] ?></p>
        <h2>Your review</h2>
        <form class='scoring' method='POST' action='movie.php'>
          <label for='story'>Story [0-100]</label>
          <input type='number' min='0' max='100' name='story' placeholder='0-100' required>
          <label for='characters'>Characters [0-100]</label>
          <input type='number' min='0' max='100' name='characters' placeholder='0-100' required>
          <label for='originality'>Originality [0-100]</label>
          <input type=number min='0' max='100' name='originality' placeholder='0-100' required>
          <label for='emotional'>Emotional Impact [0-100]</label>
          <input type='number' min='0' max='100' name='emotional' placeholder='0-100' required>
          <?php //if not logged in, show "Log in to post review"
          if (!isset($_COOKIE['username'])) {
              echo "<button type='submit'>Prześlij</button>";
          } else {
              echo "<h3>Log in to post review</h3>";
          }
?>
        </form>
      </div>
      <div class='comments'>
        <form class='comment_form' method='POST' action='movie.php'>
          <label for='comment'>
            <h2>Write your thoughts</h2>
          </label>
          <?php // don't show username input if user is logged in with cookie
if (!isset($_SESSION['username'])) {
    echo "<input type='text' placeholder='Username' name='username'></input>";
}
?>
          <textarea name='content' placeholder="What did you like/dislike about the movie?" maxlength="250" required></textarea>
          <button type='submit'>Prześlij</button>
        </form>
        <?php for ($i = 0; $i < count($comments); $i++) { ?>
          <div class='comment'>
            <span>
              <h4><?php echo $comments[$i]['username'] ?></h4>
            </span>
            <p><?php echo $comments[$i]['content'] ?></p>
          </div>
        <?php } ?>
      </div>
    </div>
  </main>
</body>

</html>
