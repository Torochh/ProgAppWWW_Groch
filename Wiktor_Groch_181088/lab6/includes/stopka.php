<?php
// includes/stopka.php — wspólna stopka serwisu
$idProjektu = $idProjektu ?? 'sklep-z-kaczkami-v1.5';
$menuPozycje = $menuPozycje ?? [];
$aktywnaStrona = $aktywnaStrona ?? null;
$docelowyAlias = $docelowyAlias ?? null;
$aktualnaStronaKatalogPhp = $aktualnaStronaKatalogPhp ?? false;
?>
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
        <a href="lab4.php" <?php echo $aktualnaStronaKatalogPhp ? 'aria-current="page"' : ''; ?>>Katalog PHP</a>

        <a href="https://github.com/Torochh/ProgAppWWW_Groch" target="_blank">GitHub</a>
    </footer>
</body>
</html>
