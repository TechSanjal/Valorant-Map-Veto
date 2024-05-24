<?php
if (file_exists('teams.json')) {
    unlink('teams.json');
}
echo json_encode(['success' => true]);
?>
