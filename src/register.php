<!DOCTYPE html>
<html lang="en">

<head>
  <title><?php if (isset($_POST["register"])) {
      echo "Register";
  } else {
      echo "Login";
  } ?></title>
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
    <?php
    if (isset($_POST["register"])) {
        echo "<form class=signin method=GET action=register.php><label for=name>Display Username</label><input type=text name=name placeholder='Display Username'><label for=email>Email</label><input type=email name=email placeholder=email@me.de><label for=password>Password</label><input type=password name=password placeholder=********><label for=confirm_password>Confirm Password</label><input type=password name=confirm_password placeholder=********><button type=submit>Zarejestruj</button>";
    } else {
        echo "<form class=signin method=GET action=register.php><label for=email>Email</label><input type=email name=email placeholder=email@me.de><label for=password>Password</label><input type=password name=password placeholder=********><button type=submit>Zaloguj</button>";
    }
  ?>
  </main>
</body>

</html>
