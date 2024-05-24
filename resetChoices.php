<?php
if (file_exists('choices.json')) {
    unlink('choices.json');
}
echo json_encode(['success' => true]);
?>
