<?php

$value = $argv[1];

if($value % 15 == 0) {
    echo "FizzBuzz \n";
} else if($value % 3== 0) {
    echo "Fizz \n";
} else if($value % 5 == 0) {
    echo "Buzz \n";
} else {
    return $value;
}