<?php
include "db_connect.php";

$stmt = $conn->query("SELECT * FROM questao");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($questions);
?>