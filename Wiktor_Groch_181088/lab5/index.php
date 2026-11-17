<?php
// ==========================================
// 1. KONFIGURACJA I MAPA PODSTRON (Zadanie 1 i 2)
// ==========================================
$idProjektu = "sklep-z-kaczkami-v5";

$mapaStron = [
    'glowna' => [
        'tytul' => 'Katalog',
        'plik'  => 'html/glowna.html'
    ],
    'produkt' => [
        'tytul' => 'Produkty',
        'plik'  => 'html/produkt.html'
    ],
    'kontakt' => [
        'tytul' => 'Kontakt',
        'plik'  => 'html/kontakt.html'
    ],
    'filmy' => [
        'tytul' => 'Filmy',
        'plik'  => 'html/filmy.html'
    ]
];


$idpRaw = $_GET['idp'] ?? '';
$wybranyKlucz = null;
$bladKomunikat = null;
$sciezkaPliku = null;

if ($idpRaw === '') {
    $wybranyKlucz = 'glowna';
} elseif (!is_string($idpRaw) || !array_key_exists($idpRaw, $mapaStron)) {
    http_response_code(404);
    $bladKomunikat = "Błąd 404: Nie znaleziono żądanej podstrony.";
    $tytulStrony = "Nie znaleziono strony (404)";
} else {
    $wybranyKlucz = $idpRaw;
}

if ($wybranyKlucz !== null) {
    $tytulStrony = $mapaStron[$wybranyKlucz]['tytul'];
    $pelnaSciezka = __DIR__ . '/' . $mapaStron[$wybranyKlucz]['plik'];

    if (!is_file($pelnaSciezka) || !is_readable($pelnaSciezka)) {
        http_response_code(500);
        $bladKomunikat = "Błąd 500: Wewnętrzny błąd serwera podczas ładowania widoku.";
        $tytulStrony = "Błąd serwera (500)";
    } else {
        $sciezkaPliku = $pelnaSciezka;
    }
}
?>
<!DOCTYPE html>
<html lang="pl" data-theme="light" id="theme">
<head>
    <title><?php echo htmlspecialchars($tytulStrony, ENT_QUOTES, 'UTF-8'); ?> - Sklep z Kaczkami</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/main.js" defer></script>
    <script src="vendor/jquery-4.0.0.min.js" defer></script>
    <script src="js/lab3.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <?php foreach ($mapaStron as $klucz => $dane): ?>
                    <?php 
                        $adres = ($klucz === 'glowna') ? 'index.php' : 'index.php?idp=' . urlencode($klucz);
                        $czyAktywny = ($wybranyKlucz === $klucz && $bladKomunikat === null);
                    ?>
                    <li>
                        <a href="<?php echo $adres; ?>" <?php echo $czyAktywny ? 'aria-current="page"' : ''; ?>>
                            <?php echo htmlspecialchars($dane['tytul'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li><a href="lab4.php">Katalog PHP</a></li>
                <li><button id="darktheme" type="button" aria-pressed="false">Dark Theme</button></li>
            </ul>
            <section class="sekcja-zegar">
                <p>Czas: <span id="zegar"></span></p>
                <p>Data: <span id="data"></span></p>
                <button id="stop" type="button">Zegar Stop</button>
                <button id="start" type="button">Zegar Start</button>
            </section>
        </nav>
        <h1>Sklep z Kaczkami — <?php echo htmlspecialchars($tytulStrony, ENT_QUOTES, 'UTF-8'); ?></h1>
    </header>

    <main class="container">
        <?php if ($bladKomunikat !== null): ?>
            <section class="blad-strony">
                <h2><?php echo htmlspecialchars($bladKomunikat, ENT_QUOTES, 'UTF-8'); ?></h2>
                <p><a href="index.php">Powrót do strony głównej</a></p>
            </section>
        <?php elseif ($sciezkaPliku !== null): ?>
            <?php include $sciezkaPliku; ?>
        <?php endif; ?>
    </main>

    <footer>
        <button id="status" type="button">PHP Status</button>
        <p id="status-msg" role="status" aria-live="polite"></p>
        <p>Autor: Wiktor Groch | Projekt: <?php echo htmlspecialchars($idProjektu, ENT_QUOTES, 'UTF-8'); ?></p>
        
        <?php foreach ($mapaStron as $klucz => $dane): ?>
            <?php 
                $adres = ($klucz === 'glowna') ? 'index.php' : 'index.php?idp=' . urlencode($klucz);
                $czyAktywny = ($wybranyKlucz === $klucz && $bladKomunikat === null);
            ?>
            <a href="<?php echo $adres; ?>" <?php echo $czyAktywny ? 'aria-current="page"' : ''; ?>>
                <?php echo htmlspecialchars($dane['tytul'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
        <?php endforeach; ?>
        
        <a href="https://github.com/Torochh/ProgAppWWW_Groch" target="_blank">GitHub</a>
    </footer>
</body>
</html>