<?php
include "db_connect.php";

header('Content-Type: application/json');
$numero_estudante = $data['numero_estudante'];
$n_bi = $data['n_bi'];

$stmt = $conn->prepare("SELECT id_estudante FROM estudante WHERE numero_estudante = :numero_estudante AND n_bi = :n_bi");
$stmt->execute(['numero_estudante' => $numero_estudante, 'n_bi' => $n_bi]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Número do estudante ou BI inválido.']);
}
?>