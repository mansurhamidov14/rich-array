<?php

require_once "vendor/autoload.php";
use Twelver313\RichArray\RichArray;

$assoc_arr = new RichArray([
  ['name' => 'Mansur', 'age' => 30],
  ['name' => 'Tashulya', 'age' => 28],
  ['name' => 'Gulyarchi', 'age' => 2.5],
]);

$assoc_arr->push(
  ['name' => 'Mansur', 'age' => 32],
  ['name' => 'Fatya', 'age' => 28]
);

var_dump($assoc_arr[0]);
var_dump($assoc_arr->getLength());