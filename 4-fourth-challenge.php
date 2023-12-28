<?php

/**
 * Fetches data from a remote API and prints names in two columns based on responses.
 */
function printNameColumns() {
    $json = file_get_contents('http://echo.jsontest.com/john/yes/tomas/no/belen/yes/peter/no/julie/no/gabriela/no/messi/no');
    $data = json_decode($json, true);

    $yesColumn = [];
    $noColumn = [];

    foreach ($data as $name => $response) {
        if ($response === 'yes') {
            $yesColumn[] = $name;
        } else {
            $noColumn[] = $name;
        }
    }

    // Print columns
    echo "No Column\tYes Column\n";
    $maxRows = max(count($yesColumn), count($noColumn));
    for ($i = 0; $i < $maxRows; $i++) {
        echo ($noColumn[$i] ?? ' ') . "\t\t" . ($yesColumn[$i] ?? ' ') . "\n";
    }
}

printNameColumns();
?>
