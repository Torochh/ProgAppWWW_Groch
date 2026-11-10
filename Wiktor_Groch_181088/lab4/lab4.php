<?php
include __DIR__ . '/includes/naglowek.php';
require_once __DIR__ . '/includes/produkty.php';
$grupa_id = "GRUPA_4_LAB";
$kategoria_filter = $_GET['kategoria'] ?? 'wszystkie';
?>

<?php
session_start();

require_once __DIR__ . '/includes/produkty.php';

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
            } elseif ($ilosc > $wybrany_produkt['stan']) {
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

$dozwolone_kategorie = ['wszystkie', 'akcesoria', 'plyny','mydla'];
$kategoria_filter = $_GET['kategoria'] ?? 'wszystkie';

if (is_array($kategoria_filter) || !in_array($kategoria_filter, $dozwolone_kategorie, true)) {
    $komunikat_get = "Nieprawidłowa kategoria! Wyświetlono pełną listę produktów.";
    $kategoria_filter = 'wszystkie';
}

?>

<hr>

<!-- Formularz filtrowania GET -->
<section>
    <h2>Filtruj katalog (GET)</h2>
    <?php if ($komunikat_get): ?>
        <p style="color: orange; font-weight: bold;"><?php echo htmlspecialchars($komunikat_get, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form method="get" action="lab4.php">
        <label for="kategoria">Kategoria:</label>
        <select name="kategoria" id="kategoria">
            <option value="wszystkie" <?php echo $kategoria_filter === 'wszystkie' ? 'selected' : ''; ?>>Wszystkie</option>
            <option value="plyny" <?php echo $kategoria_filter === 'plyny' ? 'selected' : ''; ?>>Plyny</option>
            <option value="akcesoria" <?php echo $kategoria_filter === 'akcesoria' ? 'selected' : ''; ?>>Akcesoria</option>
            <option value="mydla" <?php echo $kategoria_filter === 'mydla' ? 'selected' : ''; ?>>Mydla</option>
        </select>
        <button type="submit">Filtruj</button>
    </form>
</section>

<!-- Tabela Produktow -->
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nazwa</th>
        <th>Kategoria</th>
        <th>Stan</th>
    </tr>

    <?php

    reset($produkty);
    while($item = current($produkty)):
        next($produkty);

        if ($kategoria_filter !== 'wszystkie' && $item['kategoria'] !== $kategoria_filter) {
            continue;
        }

        switch ($item['kategoria']) {
            case 'akcesoria':
                $etykieta = 'Akcesoria';
                break;
            case 'plyny':
                $etykieta = 'Płyny';
                break;
            case 'mydla':
                $etykieta = 'Mydła';
                break;
        }
        if ($item['stan'] == 0) {
            $stan = 'Niedostępny';
        } else if ($item['stan'] >= 1 && $item['stan'] <= 5) {
            $stan = 'Niski stan';
        } else {
            $stan = 'Dostępny';
        }
        ?>
        <tr>
        <td><?php echo $item['id']; ?></td>
        <td><?php echo htmlspecialchars($item['nazwa']); ?></td>
        <td><?php echo $etykieta; ?></td>
        <td><?php echo $stan; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- Wyświetlanie zapisanego wyboru z SESJI -->
<section>
    <h2>Ostatni zapisany wybór</h2>
    <?php if (isset($_SESSION['ostatni_wybor'])): ?>
        <?php 
            $zapisane_id = $_SESSION['ostatni_wybor']['id'];
            $zapisana_ilosc = $_SESSION['ostatni_wybor']['ilosc'];
            
            $nazwa_prod = "Produkt o ID " . $zapisane_id;
            foreach ($produkty as $p) {
                if ($p['id'] == $zapisane_id) {
                    $nazwa_prod = $p['nazwa'];
                    break;
                }
            }
        ?>
        <p style="color: green; font-weight: bold;">
            Zapisano w sesji: <?php echo htmlspecialchars($nazwa_prod, ENT_QUOTES, 'UTF-8'); ?> — Sztuk: <?php echo (int)$zapisana_ilosc; ?>
        </p>
    <?php else: ?>
        <p><em>Brak zapisanego wyboru w sesji.</em></p>
    <?php endif; ?>
</section>



<hr>


<!-- Formularz zapisu POST -->
<section>
    <h2>Zapisz wybór (POST)</h2>
    <?php if ($blad_post): ?>
        <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($blad_post, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form method="post" action="lab4.php">
        <div>
            <label for="produkt">Wybierz produkt:</label>
            <select name="produkt" id="produkt">
                <?php foreach ($produkty as $p): ?>
                    <option value="<?php echo $p['id']; ?>">
                        <?php echo htmlspecialchars($p['nazwa'], ENT_QUOTES, 'UTF-8'); ?> (Stan: <?php echo $p['stan']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <div>
            <label for="ilosc">Ilość:</label>
            <select name="ilosc" id="ilosc">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <br>
        <button type="submit">Zapisz wybór</button>
    </form>
</section>