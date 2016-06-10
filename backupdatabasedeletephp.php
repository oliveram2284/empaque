<?php

$path = $_POST['path'];

unlink($path);

echo json_encode(1);

?>