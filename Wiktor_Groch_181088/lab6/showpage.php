<?php

function PobierzMenu(PDO $pdo): array
{
    $stmt = $pdo->query("SELECT alias, page_title FROM page_list WHERE status = 1 ORDER BY id");
    return $stmt->fetchAll();
}

function PokazPodstrone(PDO $pdo, string $alias): ?array
{
    $sql = "SELECT id, page_title, page_content 
            FROM page_list 
            WHERE alias = :alias AND status = 1 
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':alias' => $alias]);

    $rekord = $stmt->fetch();

    return $rekord !== false ? $rekord : null;
}