<?php
if (file_exists('choices.json')) {
    echo file_get_contents('choices.json');
} else {
    echo json_encode([]);
}
?>
