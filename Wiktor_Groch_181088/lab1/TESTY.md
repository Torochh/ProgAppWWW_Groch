Autor: Wiktor Groch

## TESTY w NU HTML:
| **index.html** | Warning Section lacks heading | (W sekcji nie ma h2-h6)
| **produkt.html** | Bez bledow 
| **kontakt.html** | Warning Section lacks heading | (W sekcji nie ma h2-h6)
| Kolejność treści | DevTools (wyłączenie CSS) | Zachowana logiczna kolejność nagłówków i bloków

## TESTY RESPONSYWNOSCI:
| Ustawienie szerokosci na `375` | Jedna kolumna bez przewyjania w bok
| Przejscie na szerokosc `768` | Robia sie 3 kolumy
| Przejscie na szerokosc `1280` | Ladnie wszystko uklada sie na stronie 

## TESTY KLAWIATURY I MYSZY:
| Klikanie `TA` | Zaznaczenie przeskakuje po kolei | Pojawia sie pomaranczowa ramka
| Klikniecie `SHIFT + TAB` | Zaznaczenie wraca do gory
| Klikniecie `ENTER` | Przechodzi do zaznaczonej strony

## WALIDACJA FORMULARZA:

| **Wysłanie pustego formularza** | Kliknięcie przycisku bez wpisywania danych | Blokada przez atrybut `required` | Formularz zablokowany, monit przy pierwszym pustym polu |
| **Niepoprawny format e-mail** | Wpisano `test-adres` (brak `@`) | Blokada przez `type="email"` | Przeglądarka wyświetla komunikat o konieczności podania znaku `@` |
| **Ilość mniejsza niż dozwolona** | Wpisano wartość `0` | Blokada przez `min="1"` | Przeglądarka informuje, że wartość musi wynosić co najmniej 1 |
| **Ilość większa niż dozwolona** | Wpisano wartość `6` | Blokada przez `max="5"` | Przeglądarka informuje, że wartość nie może przekraczać 5 |
| **Za krótka treść wiadomości** | Wpisano 5 znaków (`pomoc`) | Blokada przez `minlength="10"` | Przeglądarka żąda wydłużenia tekstu do co najmniej 10 znaków |
| **Wszystkie dane poprawne** | Wypełniono poprawnie wszystkie 4 pola | Wysłanie danych metodą GET, parametry widoczne w URL | Strona przeładowana, adres zawiera: `?email=...&produkt=...&ilosc=...&wiadomosc=...` |

## roznica miedzy ID I NAME :
1. **Hipoteza:** Usunięcie atrybutu `name` z pola `input` typu email (przy zachowaniu `id="email"` oraz `<label for="email">`) sprawi, że walidacja w przeglądarce zadziała, ale wpisany adres e-mail nie zostanie dołączony do adresu URL po wysłaniu formularza.
2. **Wyjaśnienie i wnioski:** W adresie URL brakuje klucza i wartości dla pola e-mail. Przeglądarka przesyła do serwera / do adresu wyłącznie te pola, które posiadają atrybut `name`. Atrybut `id` służy tylko do identyfikacji wewnątrz przeglądarki (do połączenia z etykietą `label` oraz stylów CSS).