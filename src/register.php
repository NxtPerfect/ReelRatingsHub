<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
  <a href="index.php" style="text-decoration: none; color: black;">
    <h1>Reel Ratings Hub</h1>
  </a>
  <?php
  if (isset($_POST["register"])) {
    echo "<h2>Zarejestruj</h2><form method=GET action=register.php> <input type=text name=name><input type=password name=confirm_password><input type=password name=password><button type=submit>Zarejestruj</button>";
  } else {
    echo "<h2>Zaloguj</h2><form method=GET action=register.php> <input type=text name=name><input type=password name=password><button type=submit>Zaloguj</button>";
  }
  ?>
  <!-- If post == register then register, else login, save as cookie -->
</body>

</html>
