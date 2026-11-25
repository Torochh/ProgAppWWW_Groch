<?php
// includes/naglowek.php — wspólny nagłówek i nawigacja serwisu
$tytulStrony = $tytulStrony ?? 'Sklep z Kaczkami';
$menuPozycje = $menuPozycje ?? [];
$aktywnaStrona = $aktywnaStrona ?? null;
$docelowyAlias = $docelowyAlias ?? null;
$aktualnaStronaKatalogPhp = $aktualnaStronaKatalogPhp ?? false;
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
                <li>
                    <a href="lab4.php" <?php echo $aktualnaStronaKatalogPhp ? 'aria-current="page"' : ''; ?>>
                        Katalog PHP
                    </a>
                </li>
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
