<?php

require_once "vendor/autoload.php";

use Twelver313\RichArray\RichArray;

// Create an instance of RichArray
$array = new RichArray([10, 20, 30, 40, 50]);

echo "Accessing array elements: \n";
echo "Accessing element at index 1 with 'at()' method: " . $array->at(1) . "\n";
echo "Accessing element at index 1 with traditional method: " . $array[1] . "\n\n";

echo "Modifying array element by index:\n";
echo "\$array[1] = 21;\n";
$array[1] = 21;
echo "After modifying index 1: [" . implode(', ', $array->toRaw()) . "]\n\n";

// Push elements to the array
$array->push(60, 70);
echo "\$array->push(60, 70)\n";
echo "After push: [" . implode(', ', $array->toRaw()) . "]\n\n";

// Unshift elements to the beginning
$array->unshift(0);
echo "\$array->unshift(0)\n";
echo "After unshift: [" . implode(', ', $array->toRaw()) . "]\n\n";

// Pop the last element
$last = $array->pop();
echo "\$array->pop()\n";
echo "Popped element: $last\n";
echo "After pop: [" . implode(', ', $array->toRaw()) . "]\n\n";

// Shift the first element
$first = $array->shift();
echo "\$array->shift()\n";
echo "Shifted element: $first\n";
echo "After shift: [" . implode(', ', $array->toRaw()) . "]\n\n";

// Map operation
$mapped = $array->map(function ($value) {
  return $value * 2;
});
echo "\$mapped = \$array->map(function (\$value) {
  return \$value * 2;
});\n";
echo "Mapped array (values * 2): [" . implode(', ', $mapped->toRaw()) . "]\n\n";

// Filter operation (keep only even numbers)
$filtered = $array->filter(function ($value) {
  return $value % 20 == 0;
});
echo "\$filtered = \$array->filter(function (\$value) {
  return \$value % 20 == 0;
});\n";
echo "Filtered array: [" . implode(', ', $filtered->toRaw()) . "]\n\n";

// Reverse the array
$array->reverse();
echo "\$array->reverse()\n";
echo "Reversed array: [" . implode(', ', $array->toRaw()) . "]\n\n";

$reversed = $array->toReversed();
echo "\$reversed = \$array->toReversed()\n";
echo "Original array (it was reversed in previous call): [" . implode(', ', $array->toRaw()) . "]\n";
echo "New reversed array: [" . implode(', ', $reversed->toRaw()) . "]\n\n";

// Find element
$found = $array->find(function ($value) {
  return $value < 30;
});
echo "\$found = \$array->find(function (\$value) {
  return \$value < 30;
});\n";
echo "First element in [" . implode(', ', $array->toRaw()) . "] smaller than 30 is: " . $found . "\n\n";

// Find index of element
$foundIndex = $array->findIndex(function ($value) {
  return $value < 30;
});
echo "\$foundIndex = \$array->findIndex(function (\$value) {
  return \$value < 30;
});\n";
echo "Index of first element in [" . implode(', ', $array->toRaw()) . "] smaller than 30 is: " . $foundIndex . "\n\n";

// Find last element
$foundLast = $array->findLast(function ($value) {
  return $value > 30;
});
echo "\$foundLast = \$array->findLast(function (\$value) {
  return \$value > 30;
});\n";
echo "Last element in [" . implode(', ', $array->toRaw()) . "] greater than 30: " . $foundLast . "\n\n";

// Find last index of element
$foundLastIndex = $array->findLastIndex(function ($value) {
  return $value > 30;
});

echo "\$foundLastIndex = \$array->findLastIndex(function (\$value) {
  return \$value > 30;
});\n";
echo "Index of last element in [" . implode(', ', $array->toRaw()) . "] greater than 30: " . $foundLastIndex . "\n\n";

// Check if array includes a value
$includes_20 = $array->includes(20);
echo "\$includes_20 = \$array->includes(20);\n";
echo "Array [" . implode(', ', $array->toRaw()) . "] includes 20: " . ($includes_20 ? 'true' : 'false') . "\n\n";

$includes_30 = $array->includes(30);
echo "\$includes_30 = \$array->includes(30);\n";
echo "Array [" . implode(', ', $array->toRaw()) . "] includes 30: " . ($includes_30 ? 'true' : 'false') . "\n\n";

// Reduce array (sum of all elements)
$sum = $array->reduce(function ($accumulator, $value) {
  return $accumulator + $value;
}, 0);
echo "\$sum = \$array->reduce(function (\$accumulator, \$value) {
  return \$accumulator + \$value;
}, 0);\n";
echo "Sum of array [" . implode(', ', $array->toRaw()) . "] elements: " . $sum . "\n\n";

// Slice operation
$sliced = $array->slice(1, 3);
echo "\$sliced = \$array->slice(1, 3);\n";
echo "Original array is [" . implode(', ', $array->toRaw()) . "].\nSliced array (from index 1, length 3): " . implode(', ', $sliced->toRaw()) . "\n\n";

// Concat operation
$concatenated = $array->concat([81, 91, 101]);
echo "\$concatenated = \$array->concat([81, 91, 101]);\n";
echo "Original array: [" . implode(', ', $array->toRaw()) . "]\n";
echo "Concatenated array: [" . implode(', ', $concatenated->toRaw()) . "]\n\n";

// Join array into string
$joined = $array->join('-');
echo "\$joined = \$array->join('-');\n";
echo "Joined array [" . implode(', ', $array->toRaw()) . "] (with '-'): " . $joined . "\n\n";

// Sort array
$array_for_sorting_with_mutation = new RichArray([3, 4, 2, 1, 6]);
$array_for_sorting_with_mutation->sort(function ($a, $b) {
  return $a - $b;
});
echo "\$array_for_sorting_with_mutation = new RichArray([3, 4, 2, 1, 6]);
\$array_for_sorting_with_mutation->sort(function (\$a, \$b) {
  return \$a - \$b;
});\n";
echo "Array was sorted as: " . implode(', ', $array_for_sorting_with_mutation->toRaw()) . "\n\n";

$array_for_sorting_without_mutation = new RichArray([3, 4, 2, 1, 6]);
$sorted = $array_for_sorting_without_mutation->toSorted(function ($a, $b) {
  return $b - $a;
});
echo "\$array_for_sorting_without_mutation = new RichArray([3, 4, 2, 1, 6]);
\$sorted = \$array_for_sorting_without_mutation->toSorted(function (\$a, \$b) {
  return \$b - \$a;
});\n";
echo "Original array is [" . implode(', ', $array_for_sorting_without_mutation->toRaw()) . "]\n";
echo "Sorted new array is [" . implode(', ', $sorted->toRaw()) . "]\n\n";

// Splice operation
$array_to_splice = new RichArray([11, 22, 33, 44, 55, 66, 77, 88, 99]);
$spliced = $array_to_splice->splice(3, 2);
echo "\$array_to_splice = new RichArray([11, 22, 33, 44, 55, 66, 77, 88, 99]);\n";
echo "\$spliced = \$array_to_splice->splice(3, 2);\n";
echo "Spliced chunk is: [" . implode(', ', $spliced->toRaw()) . "]\n";
echo "Original array became: [" . implode(', ', $array_to_splice->toRaw()) . "]\n";

echo "Some operation (check if some elements are greater than 60):\n";
$someFalse = $array->some(function ($value) {
  return $value > 60; // None are greater than 60
});
echo "\$someFalse = \$array->some(function (\$value) {
  return \$value > 60;
});\n";
echo "Some elements greater than 60: " . ($someFalse ? 'true' : 'false') . "\n\n";

echo "Some operation (check if some elements are greater than 30):\n";
$someTrue = $array->some(function ($value) {
  return $value > 30; // Some are greater than 30
});
echo "\$someTrue = \$array->some(function (\$value) {
  return \$value > 30;
});\n";
echo "Some elements greater than 30: " . ($someTrue ? 'true' : 'false') . "\n\n";

echo "Every operation (check if all elements are greater than 5):\n";
$everyTrue = $array->every(function ($value) {
  return $value > 5; // All are greater than 5
});
echo "\$everyTrue = \$array->every(function (\$value) {
  return \$value > 5;
});\n";
echo "All elements greater than 5: " . ($everyTrue ? 'true' : 'false') . "\n\n";

echo "Every operation (check if all elements are greater than 40):\n";
$everyFalse = $array->every(function ($value) {
  return $value > 40; // Not all are greater than 40
});
echo "\$everyFalse = \$array->every(function (\$value) {
  return \$value > 40;
 });\n";
echo "All elements greater than 40: " . ($everyFalse ? 'true' : 'false') . "\n\n";

echo "ReduceRight operation (sum of all elements from right to left):\n";
$sumRight = $array->reduceRight(function ($accumulator, $value) {
  return $accumulator + $value;
}, 0);
echo "\$sumRight = \$array->reduceRight(function (\$accumulator, \$value) {
  return \$accumulator + \$value;
}, 0);\n";
echo "Sum from right: " . $sumRight . "\n\n";

echo "IndexOf operation (find index of element 6):\n";
$index_of_test_case = new RichArray([4, 5, 6, 6, 7]);
$index_of_6 = $index_of_test_case->indexOf(6);
$index_of_8 = $index_of_test_case->indexOf(8);
echo "\$index_of_6 = \$index_of_test_case->indexOf(6);\n";
echo "\$index_of_8 = \$index_of_test_case->indexOf(8);\n";
echo "Index of element 6: " . $index_of_6 . "\n";
echo "Index of element 8: " . $index_of_8 . "\n\n";

echo "LastIndexOf operation (find last index of element 6):\n";
$last_index_of_test_case = new RichArray([4, 5, 6, 6, 7]);
$last_index_of_6 = $last_index_of_test_case->lastIndexOf(6);
$last_index_of_8 = $last_index_of_test_case->lastIndexOf(8);
echo "\$index_of_6 = \$last_index_of_test_case->lastIndexOf(6);\n";
echo "\$index_of_8 = \$last_index_of_test_case->lastIndexOf(8);\n";
echo "Last index of element 6: " . $last_index_of_6 . "\n";
echo "Last index of element 8: " . $last_index_of_8 . "\n\n";
