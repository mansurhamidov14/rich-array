<?php

require_once "vendor/autoload.php";
use Twelver313\RichArray\RichArray;

$assoc_arr = new RichArray([
  ['name' => 'Mansur', 'age' => 30],
  ['name' => 'Tashulya', 'age' => 28],
  ['name' => 'Gulyarchi', 'age' => 2.5],
]);

$new_arr = $assoc_arr->concat([
  ['name' => 'Mansur', 'age' => 32],
  ['name' => 'Fatya', 'age' => 28]
]);
