<?php

// 1. KONFIGURACJA I FUNKCJE POMOCNICZE 

$idProjektu = "sklep-z-kaczkami-v1.5";

require_once __DIR__ . '/showpage.php';

$menuPozycje = [];
$aktywnaStrona = null;
$bladKomunikat = null;
$tytulStrony = "Sklep z Kaczkami";

$idpRaw = $_GET['idp'] ?? '';
$docelowyAlias = null;

if ($idpRaw === '') {
    $docelowyAlias = 'glowna';
} elseif (!is_string($idpRaw) || !preg_match('/^[a-z0-9-]{1,20}$/', $idpRaw)) {
    http_response_code(404);
    $bladKomunikat = "Błąd 404: Nie znaleziono żądanej podstrony.";
    $tytulStrony = "Nie znaleziono strony (404)";
} else {
    $docelowyAlias = $idpRaw;
}


// 2. POŁĄCZENIE Z BAZĄ I POBRANIE DANYCH 

try {
    require_once __DIR__ . '/cfg.php';

    $stmtMenu = $pdo->query("SELECT alias, page_title FROM page_list WHERE status = 1 ORDER BY id");
    $menuPozycje = $stmtMenu->fetchAll();

    if ($docelowyAlias !== null) {
        $aktywnaStrona = PokazPodstrone($pdo, $docelowyAlias);

        if ($aktywnaStrona === null) {
            http_response_code(404);
            $bladKomunikat = "Błąd 404: Podana podstrona nie istnieje lub nie została opublikowana.";
            $tytulStrony = "Nie znaleziono strony (404)";
        } else {
            $tytulStrony = $aktywnaStrona['page_title'];
        }
    }
} catch (Throwable $e) {
    error_log("[CMS DB Error] " . $e->getMessage());
    http_response_code(500);
    $bladKomunikat = "Błąd 500: Wewnętrzny błąd serwera. Spróbuj ponownie później.";
    $tytulStrony = "Błąd serwera (500)";
    $menuPozycje = [];
    $aktywnaStrona = null;
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
                <?php foreach ($menuPozycje as $pozycja): ?>
                    <?php
                        $alias = $pozycja['alias'];
                        $adres = ($alias === 'glowna') ? 'index.php' : 'index.php?idp=' . urlencode($alias);
                        $czyAktywny = ($aktywnaStrona !== null && $docelowyAlias === $alias);
                    ?>
                    <li>
                        <a href="<?php echo $adres; ?>" <?php echo $czyAktywny ? 'aria-current="page"' : ''; ?>>
                            <?php echo htmlspecialchars($pozycja['page_title'], ENT_QUOTES, 'UTF-8'); ?>
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
        <?php elseif ($aktywnaStrona !== null): ?>
            <?php echo $aktywnaStrona['page_content']; ?>
        <?php endif; ?>
    </main>

    <footer>
        <button id="status" type="button">PHP Status</button>
        <p id="status-msg" role="status" aria-live="polite"></p>
        <p>Autor: Wiktor Groch | Projekt: <?php echo htmlspecialchars($idProjektu, ENT_QUOTES, 'UTF-8'); ?></p>

        <?php foreach ($menuPozycje as $pozycja): ?>
            <?php
                $alias = $pozycja['alias'];
                $adres = ($alias === 'glowna') ? 'index.php' : 'index.php?idp=' . urlencode($alias);
                $czyAktywny = ($aktywnaStrona !== null && $docelowyAlias === $alias);
            ?>
            <a href="<?php echo $adres; ?>" <?php echo $czyAktywny ? 'aria-current="page"' : ''; ?>>
                <?php echo htmlspecialchars($pozycja['page_title'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
        <?php endforeach; ?>

        <a href="https://github.com/Torochh/ProgAppWWW_Groch" target="_blank">GitHub</a>
    </footer>
</body>
</html>