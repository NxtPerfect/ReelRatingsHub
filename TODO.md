1. Rejestracja
    - nazwa
    - email
    - hasło
    - powtórz hasło
    - Jeśli email w bazie danych, wyrzuć błąd
    - Jeśli hasło == powtórz hasło, a email jest prawidłowym mailem \w@\w.\w, dodaj do bazy danych
    - może dodawać recenzje w procentach od 0% do 100%
    - limit słów w recenzji to 1000, minimum 100
2. Logowanie
    - nazwa/email
    - hasło
    - Jeśli są w bazie danych, zaloguj, inaczej max 5 prób, potem poczekaj 5 minut
3. Użytkownik jako gość
    - nazwa użytkownika to generowane id lub który gość z kolei
    - [/] może jedynie komentować pod filmami
    - [x] limit słów w komentarzu to 250
4. Bazy danych
    - [x] po napisaniu komentarza/recenzji, zapisz do bazy danych
    - [x] wyświetlaj recenzje/komentarze z bazy danych
    - [x] wyświetlaj filmy/gatunki z bazy danych
5. Baza danych - filmy
    - [x] unikalne id
    - [x] tytuł
    - [x] gatunki
    <!-- - ile trwa w minutach -->
6. Baza danych - komentarze
    - [x] unikalne id
    - [x] nazwa użytkownika
    - [x] treść komentarza
    - [ ] data dodania
7. Baza danych - użytkownicy
    - [x] unikalne id
    - [x] email
    - [x] nazwa
    - [x] hasło
8. Baza danych - gość
    - unikalne id
    - nazwa
