<?php
if (file_exists('teams.json')) {
    echo file_get_contents('teams.json');
} else {
    echo json_encode(['team1' => '', 'team2' => '']);
}
?>
