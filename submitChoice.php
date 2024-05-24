<?php
$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['team']) && isset($data['action']) && isset($data['map'])) {
    $choices = [];
    if (file_exists('choices.json')) {
        $choices = json_decode(file_get_contents('choices.json'), true);
    }
    $choices[] = $data;
    file_put_contents('choices.json', json_encode($choices));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
