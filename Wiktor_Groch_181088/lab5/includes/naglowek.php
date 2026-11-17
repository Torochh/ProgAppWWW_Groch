<?php
// includes/naglowek.php
$identyfikatorGrupy = "GRUPA_4_LAB";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog PHP - Sklep z Kaczkami</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <h1><?php echo "Katalog PHP - Identyfikator: " . htmlspecialchars($identyfikatorGrupy, ENT_QUOTES, 'UTF-8'); ?></h1>
    <nav>
        <a href="index.php">Strona Główna</a> | 
        <a href="lab4.php">Katalog PHP</a>
    </nav>
    <hr>
</header>
<main>