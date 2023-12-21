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
    - może jedynie komentować pod filmami
    - limit słów w komentarzu to 250
4. Bazy danych
    - po napisaniu komentarza/recenzji, zapisz do bazy danych
    - wyświetlaj recenzje/komentarze z bazy danych
    - wyświetlaj filmy/gatunki z bazy danych
5. Baza danych - filmy
    - unikalne id
    - tytuł
    - gatunki
    - ile trwa w minutach
6. Baza danych - komentarze
    - unikalne id
    - nazwa użytkownika
    - treść komentarza
    - data dodania
7. Baza danych - użytkownicy
    - unikalne id
    - email
    - nazwa
    - hasło
8. Baza danych - gość
    - unikalne id
    - nazwa
