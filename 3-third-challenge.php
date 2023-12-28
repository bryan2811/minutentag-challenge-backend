<?php

/**
 * Fetches the current date from a remote API and formats it.
 *
 * @return string Formatted current date.
 */
function getCurrentDateFormatted() {
    $json = file_get_contents('http://date.jsontest.com/');
    $data = json_decode($json, true);

    $date = new DateTime($data['date']);
    return $date->format('l jS \of F, Y - h:i A');
}

echo getCurrentDateFormatted();
?>