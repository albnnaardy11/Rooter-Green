<?php
$lines = file('storage/logs/laravel.log');
$errors = [];
foreach ($lines as $line) {
    if (strpos($line, 'local.ERROR') !== false || strpos($line, 'Exception') !== false) {
        $errors[] = $line;
    }
}
$last = array_slice($errors, -20);
echo implode('', $last);
