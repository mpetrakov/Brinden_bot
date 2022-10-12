<?php

$data = json_decode(file_get_contents('php://input'), TRUE);
file_put_contents('file.txt', '$data; '.print_r($data, 1)."\n", FILE_APPEND);