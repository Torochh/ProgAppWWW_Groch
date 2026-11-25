Autor: Wiktor Groch

## Odczyt i aktualizacja treści :
**|Oczekiwany wynik:** index.php i ?idp= otwierają glowna z HTTP 200. Zmień treść w phpMyAdmin: po odświeżeniu widać zmianę bez edycji plików PHP i HTML.
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Nowa strona i menu:
**|Oczekiwany wynik:** Dodaj opublikowany rekord z nowym aliasem. Link pojawia się w menu i otwiera stronę bez zmiany kodu PHP. Aktywny link jest oznaczony.
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Szkic i publikacja:  
**|Oczekiwany wynik:** Rekord ze statusem 0 znika z menu, a jego bezpośredni adres zwraca 404. Po zmianie statusu na 1 jest widoczny. Próba dodania identycznego aliasu jest odrzucana przez bazę.
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Błędne dane w adresie: 
**|Oczekiwany wynik:** ?idp=nieznana i ?idp[]=filmy dają 404. Jako idp sprawdź też ../cfg.php oraz tekst ' OR 1=1--. Każda próba daje 404 bez ostrzeżeń PHP.
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Awaria bazy : 
**|Oczekiwany wynik:** Ustaw tymczasowo błędny port w konfiguracji. Strona zwraca 500 bez szczegółów technicznych, a lokalny log pozwala ustalić przyczynę.
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Funkcje po migracji: 
**|Oczekiwany wynik:** Działają style, obrazy, animacje, AJAX i trzy filmy. Katalog filtruje produkty i zapisuje wybór: POST 303, potem GET 200. Wybór pozostaje po przejściu między podstronami.
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Odtworzenie środowiska:
**|Oczekiwany wynik:** Utwórz pustą bazę testową. Zaimportuj schemat i dane, uzupełnij lokalną konfigurację. Projekt uruchamia się zgodnie z README, także z polskimi znakami.
**|Otrzymany wynik:** Zgodne z oczekiwanym




## URUCHOMIENIE STRONY
| Stowrzylem **srodowisko** (postawione na serverze Oracle cloud) w ktorym bede testowal i wrzucal moje prace z zajec | W srodowisku da sie odpalic strone jak i przejrzec caly kod z danego zadania |
| Cale srodowisko zostalo stworzone z pomoca AI poniewaz nie jestem krolem html'a i php'a |
| **link** http://130.162.217.201:8080 |