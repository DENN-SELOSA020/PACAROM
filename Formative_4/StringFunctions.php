<?php
    $names = [
    "naruto", "sasuke", "sakura", "kakashi", "itachi",
    "jiraiya", "tsunade", "hinata", "neji", "shikamaru",
    "ino", "choji", "gaara", "rock lee", "tenten",
    "orochimaru", "madara", "obito", "minato", "kiba"
    ];

    echo "<div style='width: 90%; margin: 30px auto; text-align: center;'>";
    echo "<table border='1' cellpadding='10' cellspacing='0' style='margin: 0 auto; border-collapse: collapse; text-align: center;'>;
    <tr>
        <th>Name</th>
        <th>Number of characters</th>
        <th>Uppercase first character</th>
        <th>Replace vowels with @</th>
        <th>Check position of character 'a'</th>
        <th>Reverse name</th>
    </tr>";

    foreach ($names as $name) {
        $length = strlen($name);
        $upperCharFirst = ucfirst($name);
        $replaceVowels = str_replace('/[aeiouAEIOU]/', '@', $name);
        $position = strpos($name, 'a');
        $posDisplay = $position !== false ? $position : 'Not found';
        $reverse = strrev($name);

        echo "<tr>
                <td>$name</td>
                <td>$length</td>
                <td>$upperCharFirst</td>
                <td>$replaceVowels</td>
                <td>$posDisplay</td>
                <td>$reverse</td>
            </tr>";
    }

    echo "</table>";
    echo "</div>";
?>