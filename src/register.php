<?php
session_start(); // Rozpoczęcie sesji do zapisania danych logowania/rejestracji
$databasename = '127.0.0.1'; // Przygotowanie danych do SQL
$username = 'root';
$password = '';
$conn = new mysqli($databasename, $username, $password, 'ReelRatingsHub'); // Połączenie z bazą danych
$error_msg = "";

if (!$conn) { // Jeśli problem z połączeniem, pokaż na stronie i zakończ wykonywanie pliku
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['username'])) { // Jeśli już zalogowany, pokaż wiadomość że użytkownik zalogowany
  echo "
<body>
  <nav>
    <a href=index.php style=text-decoration: none; color: black;>
      <h1>Reel Ratings Hub</h1>
    </a>
    <form class=search method=GET action=index.php>
      <input type=text name=title placeholder=Search movie name>
      <div type=submit name=search value=search class=search_icon style=cursor: pointer;>
        <i class=fa fa-search></i>
      </div>
    </form>
    <div class=login>
      <form class=login_form method=POST action=register.php>
        <button type=submit name=login value=login style=cursor: pointer;>Zaloguj</button>
        <button type=submit name=register value=register style=cursor: pointer;>Zarejestruj</button>
      </form>
    </div>
  </nav>
</body>";
  echo "User already logged in";
  exit(); // Skończ wykonywanie pliku
}

// Jeśli się rejestrujemy
if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
  if ($_POST["password"] == $_POST["confirm_password"]) { // jeśli potwierdzenie hasła takie same jak hasło
    $_name = $_POST['name'];
    $_email = $_POST['email'];
    $_password = $_POST['password'];
    $query = "SELECT email FROM users WHERE email LIKE '$_email';"; // sprawdź czy użytkownik już zarejestrowany
    $res = mysqli_query($conn, $query);
    if (count(mysqli_fetch_all($res, MYSQLI_ASSOC)) > 0) { // Jeśli tak, pokaż wiadomość
      $error_msg = "Użytkownik istnieje";
      mysqli_free_result($res);
      $_POST['register'] = 1; // ustaw na register, aby nie zmienić strony na logowanie
    } else { // jeśli nie, wstaw dane do bazy danych
      mysqli_free_result($res);
      $query = "INSERT INTO users (id, email, username, password) VALUES (NULL, '$_email', '$_name', '$_password');";
      $res = mysqli_query($conn, $query);
      $_SESSION['username'] = $_name; // ustaw zmienną sesji, aby użytkownik był zalogowany
    }
  } else { // jeśli hasło nieprawidłowe, pokaż wiadomość
    $error_msg = "Hasło nieprawidłowe";
    $_POST['register'] = 1; // ustaw na register, aby nie zmienić strony na logowanie
  }
}

// Jeśli się logujemy
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login'])) {
  $_email = $_POST['email'];
  $query = "SELECT email, username, password FROM users WHERE email LIKE '$_email';"; // sprawdź czy email jest w tabeli
  $res = mysqli_query($conn, $query);
  $test = mysqli_fetch_all($res, MYSQLI_ASSOC);
  if (count($test) == 0) { // jeśli nie znaleziono emailu
    $error_msg = "Użytkownik nie istnieje";
    mysqli_free_result($res);
  } else {
    if ($test[0]['password'] == $_POST['password']) { // jeśli hasło w bazie jak podane
      $_SESSION['username'] = $test[0]['username'];
      header("Location: index.php"); // przenieś na głóœną stronę
    } else { // Inaczej wypisz wiadomość
      $error_msg = "Niepoprawne hasło";
      mysqli_free_result($res);
    }
  }
}
?>

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
    <?php
    // Wypisz formularz rejestracji
    if (isset($_POST["register"])) {
      echo "
        <form class=signin method=POST action=register.php>
          <label for=name>Nazwa użytkownika</label>
          <input type=text name=name placeholder='Nazwa użytkownika' required>
          <label for=email>Email</label>
          <input type=email name=email placeholder=email@me.de required>
          <label for=password>Password</label>
          <input type=password name=password placeholder=******** required>
          <label for=confirm_password>Confirm Password</label>
          <input type=password name=confirm_password placeholder=******** required>
          <button type=submit>Zarejestruj</button>
          $error_msg
        </form>";
    } else { // Inaczej, wypisz formularz logowania
      echo "
        <form class=signin method=POST action=register.php>
          <label for=email>Email</label>
          <input type=email name=email placeholder=email@me.de required>
          <label for=password>Password</label>
          <input type=password name=password placeholder=******** required>
          <input type=hidden name=login></input>
          <button type=submit>Zaloguj</button>
          $error_msg
        </form>";
    }
    ?>
  </main>
</body>

</html>
