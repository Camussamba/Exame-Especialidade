<?php
include "db_connect.php";

$data = json_decode(file_get_contents("php://input"), true);

// Simulação de cálculo de resultado
$resultado_financas = 0;
$resultado_criacao = 0;

foreach ($data as $key => $value) {
    if (strpos($key, 'q') === 0 && $value === 'Sim') {
        $id_questao = substr($key, 1);
        $stmt = $conn->prepare("SELECT especialidade FROM questao WHERE id_questao = :id_questao");
        $stmt->execute(['id_questao' => $id_questao]);
        $questao = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($questao['especialidade'] === 'Finanças') {
            $resultado_financas += 2;
        } else {
            $resultado_criacao += 2;
        }
    }
}

// Determinar especialidade elegida
$stmt = $conn->prepare("SELECT media_financas, media_criacao FROM estudante WHERE id_estudante = 1"); // Simulação com id_estudante = 1
$stmt->execute();
$estudante = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado_financas > $resultado_criacao) {
    $especialidade_elegida = 'Finanças';
} elseif ($resultado_financas < $resultado_criacao) {
    $especialidade_elegida = 'Criação';
} else {
    $especialidade_elegida = ($estudante['media_financas'] > $estudante['media_criacao']) ? 'Finanças' : 'Criação';
}

echo json_encode(['success' => true, 'especialidade_elegida' => $especialidade_elegida]);
?>