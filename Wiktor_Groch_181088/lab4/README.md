Autor: Wiktor Groch

## Filtr GET
| **Oczekwiany Wynik** : ?kategoria=ksiazki pokazuje tylko książki Nieznana kategoria lub ?kategoria[]=ksiazki pokazuje pełną listę i komunikat.
| **Rzeczywisty Wynik** :  Zgodny z oczekiwanym
## Poprawny POST i odświeżenie
| **Oczekwiany Wynik** : Wybierz dostępny produkt i poprawną ilość. W Network widać POST 303, potem GET 200. Po odświeżeniu i zmianie filtra zapisany wybór pozostaje widoczny.
| **Rzeczywisty Wynik** :  Zgodny z oczekiwanym

## Błędne wartości POST
| **Oczekwiany Wynik** : Sprawdź ilość 0, 6, 2.5, 2abc, brak pola,tablicę i nieznany produkt. Każda próba daje HTTP 400 i pozostawia poprzedni wybór.
| **Rzeczywisty Wynik** :  Zgodny z oczekiwanym

## Stan magazynowy
| **Oczekwiany Wynik** : Dla produktu ze stanem 1 spróbuj wybrać 2 sztuki. Serwer odrzuca wybór, mimo że 2 mieści się w przedziale 1–5.
| **Rzeczywisty Wynik** :  Zgodny z oczekiwanym

## Odrębna sesja i tekst HTML
| **Oczekwiany Wynik** : W nowej sesji, np. w osobnym oknie prywatnym, nie ma wyboru. Nazwa testowa <b>Test</b> wyświetla się jako tekst; przywróć zwykłą nazwę.
| **Rzeczywisty Wynik** :  Zgodny z oczekiwanym

## Strona po zmianie ścieżek
| **Oczekwiany Wynik** : Otwórz stronę główną i podstrony. Działają style, obrazy, linki i funkcje z lab3, w tym animacje i żądanie do status.php.
| **Rzeczywisty Wynik** :  Zgodny z oczekiwanym


## URUCHOMIENIE STRONY
| Stowrzylem **srodowisko** (postawione na serverze Oracle cloud) w ktorym bede testowal i wrzucal moje prace z zajec | W srodowisku da sie odpalic strone jak i przejrzec caly kod z danego zadania |
| Cale srodowisko zostalo stworzone z pomoca AI poniewaz nie jestem krolem html'a i php'a |
| **link** http://130.162.217.201:8080 |