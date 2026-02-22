<?php
$lines = file('storage/logs/laravel.log');
$last = array_slice($lines, -150);
file_put_contents('error_context.txt', implode('', $last));
