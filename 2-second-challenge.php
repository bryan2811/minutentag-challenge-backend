<?php

class LetterCounter {
    /**
     * Counts the occurrence of each letter in a string.
     *
     * @param string $str The input string.
     *
     * @return string A formatted string representing letter counts.
     */
    public static function CountLettersAsString($str) {
        $letterCounts = array_count_values(str_split(strtolower($str)));
        $result = [];

        foreach ($letterCounts as $letter => $count) {
            // Skip non-letter characters
            if (!ctype_alpha($letter)) continue;

            $result[] = $letter . ':' . str_repeat('*', $count);
        }

        return implode(', ', $result);
    }
}

// Example usage
$testString = "Interview";
echo "Counting letters in '{$testString}':\n";
echo LetterCounter::CountLettersAsString($testString);
?>
