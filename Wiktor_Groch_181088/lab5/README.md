Autor: Wiktor Groch

## Adres domyślny i menu:
**|Oczekiwany wynik:** index.php i index.php?idp= pokazują stronę główną. Odnośniki otwierają właściwe treści ze wspólnym szablonem i poprawnym tytułem.
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Nieznany lub tablicowy klucz:
**|Oczekiwany wynik:** ?idp=nieznana i ?idp[]=filmy dają HTTP 404 i odnośnik powrotny, bez ostrzeżeń PHP.
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Próba podania ścieżki:  
**|Oczekiwany wynik:** ?idp=..%2Fstatus.php daje HTTP 404. Zawartość status.php nie zostaje dołączona
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Brak pliku widoku: 
**|Oczekiwany wynik:** Zmień tymczasowo nazwę html/filmy.html. Adres ?idp=filmy zwraca HTTP 500 bez ujawnienia ścieżki systemowej.
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Strona główna i AJAX: 
**|Oczekiwany wynik:** Na stronie głównej działają style, grafiki i animacje. W panelu Sieć widać udane żądanie do status.php, a na stronie jego wynik.
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Katalog i sesja po migracji: 
**|Oczekiwany wynik:** Otwórz katalog z menu i użyj filtra. Zapisz poprawny wybór: POST 303, potem GET 200. Wróć na stronę główną, otwórz Filmy i ponownie wejdź do katalogu. Zapisany wybór nadal jest widoczny.
**|Otrzymany wynik:** Zgodne z oczekiwanym
## Filmy i układ mobilny:
**|Oczekiwany wynik:** Trzy filmy można uruchomić, odnośniki działają, a przy szerokości 360 px strona nie przewija się w poziomie.
**|Otrzymany wynik:** Zgodne z oczekiwanym




## URUCHOMIENIE STRONY
| Stowrzylem **srodowisko** (postawione na serverze Oracle cloud) w ktorym bede testowal i wrzucal moje prace z zajec | W srodowisku da sie odpalic strone jak i przejrzec caly kod z danego zadania |
| Cale srodowisko zostalo stworzone z pomoca AI poniewaz nie jestem krolem html'a i php'a |
| **link** http://130.162.217.201:8080 |