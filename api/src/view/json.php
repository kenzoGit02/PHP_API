<?php
// api/views/json.php

function render($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
}
?>