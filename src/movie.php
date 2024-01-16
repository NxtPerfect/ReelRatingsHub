<?php
session_start(); // Rozpoczęcie sesji do logowania/wylogowania
$databasename = '127.0.0.1'; // Wprowadzenie danych do SQL
$username = 'root';
$password = '';
$conn = new mysqli($databasename, $username, $password, 'ReelRatingsHub'); // Połączenie z bazą danych

if (!$conn) { // Jeśli wystąpi błąd, pokaż go na ekranie i przerwij wykonywanie pliku
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['title'])) { // Jeśli wejdziemy pierwszy raz na film, zapisz dane
    // Gdy wyślemy ocenę, inaczej przeniosłoby nas do strony bez wybranego filmu
    $title = $_GET['title'];
    $_SESSION['title'] = $title; // zapisz tytuł do sesji
    $qr_name = trim(implode(' ', explode('+', $title))); // zamień nazwę z plusami z get, na spacje
    // np zamiast "top+gun", będzie "top gun"
    $query = "SELECT id, name, genres, description FROM movies WHERE name LIKE '$qr_name'"; // Przeszukanie bazy danych
    // Znajdzie film który ma taką nazwę
    $res = mysqli_query($conn, $query);
    $movie = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $movie = $movie[0]; // Wybierz pierwszy element z wyników
    mysqli_free_result($res); // zwolnij pamięć którą zajmuje zmienna $res
} elseif (isset($_SESSION['title'])) { // jeśli w sesji mamy wybrany tytuł
    $title = $_SESSION['title']; // zapisz go
    $query = "SELECT id, name, genres, description FROM movies WHERE name LIKE '$title'"; // i wyszukaj w bazie danych
    $res = mysqli_query($conn, $query);
    $movie = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $movie = $movie[0];
    mysqli_free_result($res);
}

if (isset($_SESSION['username'])) { // Wybierz Id użytkownika z bazy danych, potrzebne do oceny filmu
    // Jeśli nie jest ustawione, to jesteśmy gościem
    $username = $_SESSION['username'];
    $query = "SELECT id, username FROM users WHERE username LIKE '$username';";
    $res = mysqli_query($conn, $query);
    $user_id = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $user_id = $user_id[0]['id'];
    mysqli_free_result($res);
}
$movie_id = $movie['id']; // Wybierz id filmu do oceny

// Jeśli wysyłamy ocenę
if (isset($_POST['story']) && isset($_POST['characters']) && isset($_POST['originality']) && isset($_POST['emotional'])) {
    $_story = intval($_POST['story']); // Zamień wartość na liczbę
    $_characters = intval($_POST['characters']);
    $_originality = intval($_POST['originality']);
    $_emotional = intval($_POST['emotional']);
    $query = "INSERT INTO reviews (id, user_id, movie_id, story, characters, originality, emotional) VALUES (NULL, $user_id, $movie_id, $_story, $_characters, $_originality, $_emotional);";
    // Wyślij zapytanie do bazy danych, jeśli wystąpi błąd, pokaż go na stronie
    if ($conn->query($query) === false) {
        echo "Error" . $query . " " . $conn->error;
    }
}

// Wyślij komentarz
if (isset($_POST['content'])) {
    $username = 'error'; // Wartość domyślna
    if (isset($_POST['username'])) { // Jeśli wpisaliśmy nazwę użytkownika w polu, bo jesteśmy gościem
        $username = $_POST['username'];
    } elseif (isset($_SESSION['username'])) { // jeśli jesteśmy zalogowani
        $username = $_SESSION['username'];
    }
    $content = $_POST['content']; // weź zawartość komentarza z pola tekstowego
    if (strlen($_POST['content']) > 250) { // upewnij się że komentarz ma mniej niż 250 znaków
        $content = substr($_POST['content'], 0, 250); // jeśli większy, to wybierz pierwsze 250 znaków
    }
    $query = "INSERT INTO comments (id, movie_id, username, content) VALUES (NULL, '$movie_id', '$username', '$content');";
    // Stwórz nowy komentarz, jeśli wystąpi błąd, pokaż go na stronie
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
    <main style="flex-direction: column;">
        <?php // zbierz wszystkie oceny
        $query = "SELECT * FROM reviews WHERE movie_id LIKE '$movie[id]'";
$res = mysqli_query($conn, $query);
$reviews = mysqli_fetch_all($res, MYSQLI_ASSOC);
mysqli_free_result($res);
$story = 0;
$characters = 0;
$originality = 0;
$emotional = 0;
for ($i = 0; $i < count($reviews); $i++) { // zlicz sumy ocen dla każdej kategorii
    $story += $reviews[$i]['story'];
    $characters += $reviews[$i]['characters'];
    $originality += $reviews[$i]['originality'];
    $emotional += $reviews[$i]['emotional'];
}
if (count($reviews) == 0) { // jeśli brak ocen to zmień na 0
    $story = 0;
    $characters = 0;
    $originality = 0;
    $emotional = 0;
    $total_score = 0;
} else { // jeśli są oceny, to zlicz średnią
    $story = $story / count($reviews);
    $chracters = $characters / count($reviews);
    $originality = $originality / count($reviews);
    $emotional = $emotional / count($reviews);
    $total_score = ($story + $characters + $originality + $emotional) / 4;
}
$query = "SELECT * FROM comments WHERE movie_id LIKE '$movie[id]'";
// Wybierz wszystkie komentarze z bazy danych
$res = mysqli_query($conn, $query);
$comments = mysqli_fetch_all($res, MYSQLI_ASSOC);
mysqli_free_result($res); ?>
        <div class='movie_review'>
            <div class='image' style='background-image: url("<?php echo "./assets/$movie[name].jpg" ?>");'></div>
            <div class='ratings'>
                <div class='score'>
                    <h2>Inni użytkownicy ocenili</h2>
                    <span>Fabuła: <?php echo number_format((float)$story, 2) ?></span>
                    <span>Postacie: <?php echo number_format((float)$characters, 2) ?></span>
                    <span>Oryginalność: <?php echo number_format((float)$originality, 2) ?></span>
                    <span>Wpływ emocjonalny: <?php echo number_format((float)$emotional, 2) ?></span>
                    <span>Łączna ocena: <?php echo number_format((float)$total_score, 2) ?></span>
                </div>
                <?php if (isset($_SESSION['username'])) { // Jeśli użytkownik zalogowany
                    $query = "SELECT * FROM reviews WHERE user_id LIKE $user_id AND movie_id LIKE '$movie_id';";
                    // wybierz ocene użytkownika
                    $res = mysqli_query($conn, $query);
                    $personal_review = mysqli_fetch_all($res, MYSQLI_ASSOC);
                    $personal_review = $personal_review[0];
                    // Ocenę zamień na liczby zmiennoprzecinkowe z maksymalnie dwoma miejscami po przecinku
                    $personal_story = number_format((float)$personal_review['story'], 2);
                    $personal_characters = number_format((float)$personal_review['characters'], 2);
                    $personal_originality = number_format((float)$personal_review['originality'], 2);
                    $personal_emotional = number_format((float)$personal_review['emotional'], 2);
                    mysqli_free_result($res);
                    $personal_total_score = number_format((float)($personal_review['story'] + $personal_review['characters'] + $personal_review['originality'] + $personal_review['emotional']) / 4, 2);
                    echo "<div class='score'>";
                    echo "<h2>Twoja ocena</h2>";
                    echo "<span>Fabuła: $personal_story </span>";
                    echo "<span>Postacie: $personal_characters </span>";
                    echo "<span>Oryginalność:  $personal_originality </span>";
                    echo "<span>Wpływ emocjonalny:  $personal_emotional </span>";
                    echo "<span>Łączna ocena: $personal_total_score </span>";
                    echo "</div>";
                } ?>
                <p><?php echo $movie['description'] ?></p>
                <h2>Twoja ocena</h2>
                <form class='scoring' method='POST' action='movie.php'>
                    <label for='story'>Fabuła [0-100]</label>
                    <input type='number' min='0' max='100' name='story' placeholder='0-100' required>
                    <label for='characters'>Postacie [0-100]</label>
                    <input type='number' min='0' max='100' name='characters' placeholder='0-100' required>
                    <label for='originality'>Oryginalność [0-100]</label>
                    <input type=number min='0' max='100' name='originality' placeholder='0-100' required>
                    <label for='emotional'>Wpływ emocjonalny [0-100]</label>
                    <input type='number' min='0' max='100' name='emotional' placeholder='0-100' required>
                    <?php // Jeśli użytkownik jest zalogowany, pokaż przycisk przesłania oceny
                    if (isset($_SESSION['username'])) {
                        echo "<button type='submit'>Prześlij</button>";
                    } else { // w innym przypadku, pokaż że trzeba się zalogować
                        echo "<h3>Zaloguj się aby ocenić</h3>";
                    }
?>
                </form>
            </div>
            <div class='comments'>
                <form class='comment_form' method='POST' action='movie.php'>
                    <label for='comment'>
                        <h2>Napisz swoje myśli</h2>
                    </label>
                    <?php // Jeśli nie zalogowany, pokaż pole do wpisania nazwy do komentarza
if (!isset($_SESSION['username'])) {
    echo "<input type='text' placeholder='Nazwa użytkownika' name='username' required></input>";
}
?>
                    <textarea name='content' placeholder="Co lubisz/nie lubisz z tego filmu?" maxlength="500" required></textarea>
                    <button type='submit'>Prześlij</button>
                </form>
                <?php if (count($comments) == 0) { // Jeśli nie ma komentarzy, wypisz wiadomość
                    echo "<div class=comment>
    <h2>Skomentuj jako pierwszy</h2>
</div>";
                } else { // jeśli są komentarze, wypisz je po kolei
                    foreach ($comments as $comment) {
                        echo "<div class=comment>
            <span>
              <h4>$comment[username]</h4>
            </span>
            <p>$comment[content] </p>
          </div>";
                    }
                } ?>
            </div>
        </div>
    </main>
</body>

</html>
