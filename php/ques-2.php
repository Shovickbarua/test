<?php
function removeDuplicates(array $arr) {
    $uniqueArray = [];

    foreach ($arr as $element) {
        if (!in_array($element, $uniqueArray)) {
            $uniqueArray[] = $element;
        }
    }

    return $uniqueArray;
}

$array = [1, 2, 2, 3, 4, 4, 5];
$result = removeDuplicates($array);
print_r($result); 
?>
