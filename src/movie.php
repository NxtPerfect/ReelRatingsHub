<!DOCTYPE html>
<html lang="en">

<head>
  <title>
    <?php $title = $_GET["title"];
    echo $title; ?></title>
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
    $url = './assets/test.jpg'; // temporary until database exists
    $description = 'Lorem ipsum dolor sit amet, officia excepteur ex fugiat reprehenderit enim labore culpa sint ad nisi Lorem pariatur mollit ex esse exercitation amet. Nisi anim cupidatat excepteur officia. Reprehenderit nostrud nostrud ipsum Lorem est aliquip amet voluptate voluptate dolor minim nulla est proident. Nostrud officia pariatur ut officia. Sit irure elit esse ea nulla sunt ex occaecat reprehenderit commodo officia dolor Lorem duis laboris cupidatat officia voluptate. Culpa proident adipisicing id nulla nisi laboris ex in Lorem sunt duis officia eiusmod. Aliqua reprehenderit commodo ex non excepteur duis sunt velit enim. Voluptate laboris sint cupidatat ullamco ut ea consectetur et est culpa et culpa duis.';
    $story = 80;
    $characters = 80;
    $originality = 80;
    $emotional_impact = 80;
    $total_score = ($story + $characters + $originality + $emotional_impact) / 4;
    $comments = array('bożydar' => 'A mi się podoba', 'halinka' => 'Bez sensu, tylko hejtujecie a sami byście lepiej nie zrobili');
    echo "<div class='movie_review'>";
    echo "<div class=image style='background-image: url($url);'></div>";
    echo "<div class=ratings>";
    echo "<div class=score>"; // oceny wszystkich uśrednione
    echo "<h2>Other Users reviewed</h2>";
    echo "<span>Story: $story</span>";
    echo "<span>Characters: $characters</span>";
    echo "<span>Originality: $originality</span>";
    echo "<span>Emotional Impact: $emotional_impact</span>";
    echo "<span>Total score: $total_score</span>";
    echo "</div>";
    echo "<p>$description"; // opis filmu
    echo "<h2>Your review</h2>";
    echo "<form class=scoring method=POST action=movie.php>";
    echo "<label for=story>Story</label>";
    echo "<input type=number min=0 max=100 name=story placeholder=Story>";
    echo "<label for=story>Characters</label>";
    echo "<input type=number min=0 max=100 name=characters placeholder=Characters>";
    echo "<label for=story>Originality</label>";
    echo "<input type=number min=0 max=100 name=originality placeholder=Originality>";
    echo "<label for=story>Emotional Impact</label>";
    echo "<input type=number min=0 max=100 name=emotional_impact placeholder='Emotional Impact'>";
    // echo "<h3>Total score: 1</h3>";
    echo "<button type=submit>Prześlij</button>";
    echo "</form>";
    echo "</div>";
    echo "<div class=comments>";
    echo "<form class=comment_form method=POST action=movie.php>";
    echo "<label for=comment><h2>Write your thoughts</h2></label>";
    echo "<textarea name=comment placeholder='What did you like/dislike about the movie?'>";
    echo "</textarea>";
    echo "<button type=submit>Prześlij</button>";
    echo "</form>";
    foreach ($comments as $key => $value) {
      echo "<div class=comment>";
      echo "<span><h4>$key</h4></span>";
      echo "<p>$value";
      echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    ?>
  </main>
</body>

</html>
