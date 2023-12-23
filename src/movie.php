<!DOCTYPE html>
<html lang="en">

<head>
  <title>
    <?php $title = $_GET["title"];
    echo $title; ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/style.css" rel="stylesheet">
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
    <?php
    $url = './assets/test.jpg'; // temporary until database exists
    $description = 'Lorem ipsum dolor sit amet, officia excepteur ex fugiat reprehenderit enim labore culpa sint ad nisi Lorem pariatur mollit ex esse exercitation amet. Nisi anim cupidatat excepteur officia. Reprehenderit nostrud nostrud ipsum Lorem est aliquip amet voluptate voluptate dolor minim nulla est proident. Nostrud officia pariatur ut officia. Sit irure elit esse ea nulla sunt ex occaecat reprehenderit commodo officia dolor Lorem duis laboris cupidatat officia voluptate. Culpa proident adipisicing id nulla nisi laboris ex in Lorem sunt duis officia eiusmod. Aliqua reprehenderit commodo ex non excepteur duis sunt velit enim. Voluptate laboris sint cupidatat ullamco ut ea consectetur et est culpa et culpa duis.';
    echo "<div class=movie_review><div class=image style='background-image: url($url);'></div><div class=ratings><span>Story: 80</span><span>Characters: 80</span><span>Originality: 80</span><span>Emotional Impact: 80</span><span>Total score: 80</span><p>$description</div></div>";
    ?>
  </main>
</body>

</html>
