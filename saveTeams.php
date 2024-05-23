<?php
$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['team1']) && isset($data['team2'])) {
    file_put_contents('teams.json', json_encode($data));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
