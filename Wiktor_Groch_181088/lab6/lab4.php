<?php
session_start();

$idProjektu = "sklep-z-kaczkami-v1.5";
$grupa_id = "GRUPA_4_LAB";
$tytulStrony = "Katalog PHP";
$menuPozycje = [];
$aktywnaStrona = null;
$docelowyAlias = null;
$aktualnaStronaKatalogPhp = true;

require_once __DIR__ . '/includes/produkty.php';
require_once __DIR__ . '/showpage.php';

try {
    require_once __DIR__ . '/cfg.php';
    $menuPozycje = PobierzMenu($pdo);
} catch (Throwable $e) {
    error_log("[Katalog PHP DB Error] " . $e->getMessage());
    $menuPozycje = [];
}

$blad_post = null;
$komunikat_get = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produkt_id_raw = $_POST['produkt'] ?? null;
    $ilosc_raw = $_POST['ilosc'] ?? null;

    if (is_array($produkt_id_raw) || is_array($ilosc_raw) || $produkt_id_raw === null || $ilosc_raw === null) {
        $blad_post = "Brak wymaganego pola lub nieprawidłowy format danych.";
    } else {
        $produkt_id = filter_var($produkt_id_raw, FILTER_VALIDATE_INT);
        $ilosc = filter_var($ilosc_raw, FILTER_VALIDATE_INT);

        if ($produkt_id === false || $ilosc === false) {
            $blad_post = "Identyfikator i ilość muszą być liczbami całkowitymi.";
        } else {
            $wybrany_produkt = null;
            foreach ($produkty as $p) {
                if ($p['id'] === $produkt_id) {
                    $wybrany_produkt = $p;
                    break;
                }
            }

            if (!$wybrany_produkt) {
                $blad_post = "Wybrany produkt nie istnieje.";
            } elseif ($ilosc < 1 || $ilosc > 5) {
                $blad_post = "Ilość musi mieścić się w przedziale od 1 do 5.";
            } elseif ($ilosc > (int)$wybrany_produkt['stan']) {
                $blad_post = "Nie można wybrać {$ilosc} szt. Dostępny stan magazynowy wynosi: {$wybrany_produkt['stan']}.";
            }
        }
    }

    if ($blad_post !== null) {
        http_response_code(400);
    } else {
        $_SESSION['ostatni_wybor'] = [
            'id' => $produkt_id,
            'ilosc' => $ilosc
        ];

        header("Location: lab4.php", true, 303);
        exit();
    }
}

$dozwolone_kategorie = ['wszystkie', 'akcesoria', 'plyny', 'mydla'];
$kategoria_filter = $_GET['kategoria'] ?? 'wszystkie';

if (is_array($kategoria_filter) || !in_array($kategoria_filter, $dozwolone_kategorie, true)) {
    $komunikat_get = "Nieprawidłowa kategoria! Wyświetlono pełną listę produktów.";
    $kategoria_filter = 'wszystkie';
}

include __DIR__ . '/includes/naglowek.php';
?>

<p>Identyfikator grupy: <strong><?php echo htmlspecialchars($grupa_id, ENT_QUOTES, 'UTF-8'); ?></strong></p>

<section>
    <h2>Filtruj katalog (GET)</h2>
    <?php if ($komunikat_get): ?>
        <p role="alert"><strong><?php echo htmlspecialchars($komunikat_get, ENT_QUOTES, 'UTF-8'); ?></strong></p>
    <?php endif; ?>

    <form method="get" action="lab4.php">
        <label for="kategoria">Kategoria:</label>
        <select name="kategoria" id="kategoria">
            <option value="wszystkie" <?php echo $kategoria_filter === 'wszystkie' ? 'selected' : ''; ?>>Wszystkie</option>
            <option value="plyny" <?php echo $kategoria_filter === 'plyny' ? 'selected' : ''; ?>>Płyny</option>
            <option value="akcesoria" <?php echo $kategoria_filter === 'akcesoria' ? 'selected' : ''; ?>>Akcesoria</option>
            <option value="mydla" <?php echo $kategoria_filter === 'mydla' ? 'selected' : ''; ?>>Mydła</option>
        </select>
        <button type="submit">Filtruj</button>
    </form>
</section>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nazwa</th>
                <th scope="col">Kategoria</th>
                <th scope="col">Stan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produkty as $item): ?>
                <?php
                    if ($kategoria_filter !== 'wszystkie' && $item['kategoria'] !== $kategoria_filter) {
                        continue;
                    }

                    $etykiety = [
                        'akcesoria' => 'Akcesoria',
                        'plyny'     => 'Płyny',
                        'mydla'     => 'Mydła',
                    ];
                    $etykieta = $etykiety[$item['kategoria']] ?? $item['kategoria'];

                    $stanLiczba = (int)$item['stan'];
                    if ($stanLiczba === 0) {
                        $stan = 'Niedostępny';
                    } elseif ($stanLiczba <= 5) {
                        $stan = 'Niski stan';
                    } else {
                        $stan = 'Dostępny';
                    }
                ?>
                <tr>
                    <td><?php echo (int)$item['id']; ?></td>
                    <td><?php echo htmlspecialchars($item['nazwa'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($etykieta, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($stan, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<section>
    <h2>Ostatni zapisany wybór</h2>
    <?php if (isset($_SESSION['ostatni_wybor'])): ?>
        <?php
            $zapisane_id = (int)$_SESSION['ostatni_wybor']['id'];
            $zapisana_ilosc = (int)$_SESSION['ostatni_wybor']['ilosc'];

            $nazwa_prod = "Produkt o ID " . $zapisane_id;
            foreach ($produkty as $p) {
                if ((int)$p['id'] === $zapisane_id) {
                    $nazwa_prod = $p['nazwa'];
                    break;
                }
            }
        ?>
        <p id="zapisany-wybor" class="komunikat-sukces">
            <strong>Zapisano w sesji: <?php echo htmlspecialchars($nazwa_prod, ENT_QUOTES, 'UTF-8'); ?> — Sztuk: <?php echo $zapisana_ilosc; ?></strong>
        </p>
    <?php else: ?>
        <p id="zapisany-wybor"><em>Brak zapisanego wyboru w sesji.</em></p>
    <?php endif; ?>
</section>

<section>
    <h2>Zapisz wybór (POST)</h2>
    <?php if ($blad_post): ?>
        <p role="alert" class="komunikat-blad"><strong><?php echo htmlspecialchars($blad_post, ENT_QUOTES, 'UTF-8'); ?></strong></p>
    <?php endif; ?>

    <form method="post" action="lab4.php">
        <label for="produkt">Wybierz produkt:</label>
        <select name="produkt" id="produkt">
            <?php foreach ($produkty as $p): ?>
                <option value="<?php echo (int)$p['id']; ?>">
                    <?php echo htmlspecialchars($p['nazwa'], ENT_QUOTES, 'UTF-8'); ?> (Stan: <?php echo (int)$p['stan']; ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label for="ilosc">Ilość:</label>
        <select name="ilosc" id="ilosc">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>

        <button type="submit">Zapisz wybór</button>
    </form>
</section>

<?php include __DIR__ . '/includes/stopka.php'; ?>
