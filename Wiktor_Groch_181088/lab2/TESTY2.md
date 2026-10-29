Autor: Wiktor Groch

**Testy robione w przegladarce Edge**
## Motyw i nawigacja :
| Wszystko poprawnie
## Start trzy razy potem Stop i Start:
| Wszystko poprawnie
## Fragment nazwy ze spacjami i inną wielkością liter :
| Wszystko poprawnie
## Brak dopasowania i wyczyszczenie pola :
| Wszystko poprawnie
## Cena 1999 gr oraz ilość 3 :
| Wszystko poprawnie **(wyswietlana cena 59.97)**
## Ilość pusta 0 6 oraz 1,5: 
| Przy 0 i 6 wyswietla sie komunikat ze **liczba musi byc pomiedzy 1 a 5**, a przy 1.5 pojawia sie komunikat **ze prosze wpisac poprawna liczbe**
## Dziesięć spacji oraz tekst <b>Test</b> :
| Przy samych spacjach pojawia sie komunikat **Wiadomość po usunięciu spacji musi mieć minimum 10 znaków.**
## Klawiatura widoki i wyłączony JavaScript :
| Wszystko poprawnie
## Test wylaczonego JS:
|Test przebiegl pomysle
## Ustawienie breakpointu:
Ustawienie breakpointa przy zmiennej sumaGrosze i zmiana ilosci i produktu w formularzu **WYNIK:**
this: input#ilosc
ilosc: 1
sumaGrosze: <value unavailable>
sumaPLN: <value unavailable>
wybranyID: "klasyczna kaczka"
wybranyProdukt: {id: 'klasyczna kaczka', nazwa: 'Zolta kaczka', cenaGrosze: 10000}
## Sprawdzenie liczby wywołań zegara :
|zegar wywoluje sie tylko raz przez warunek **if (!flaga = false)** w kodzie
## Celowe wywołanie błędnej funkcji:
| 1. Zmiana nazwy **usunPodsumowanie();** na **usunPdsumowanie();**
| 2. Zmiana produktu i ilsoc 
| 3. Blad w konsoli : **main.js:161 Uncaught ReferenceError: usunPdsumowanie is not defined**


## URUCHOMIENIE STRONY
| Stowrzylem **srodowisko** (postawione na serverze Oracle cloud) w ktorym bede testowal i wrzucal moje prace z zajec | W srodowisku da sie odpalic strone jak i przejrzec caly kod z danego zadania |
| Cale srodowisko zostalo stworzone z pomoca AI poniewaz nie jestem krolem html'a i php'a |
| **link** http://130.162.217.201:8080 |