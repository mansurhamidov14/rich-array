# RichArray

**RichArray** is a PHP library designed to bring the flexibility and familiarity of JavaScript's array methods to PHP. It allows developers, especially those coming from JavaScript, to work with arrays in PHP using methods like `forEach`, `filter`, `find`, and more—all.

## Features
- Access elements using array-like syntax (e.g., `$richArray[0]`)
- JavaScript-style methods like `forEach`, `filter`, `find`, and more
- Fully compatible with PHP's array access and `foreach` loops
- Easily extensible for additional custom methods

## Installation

You can install the package via Composer:

```bash
composer require twelver313/rich-array
```

## Usage

### Basic Example

Here’s how you can use **RichArray** to make your PHP arrays behave more like JavaScript arrays:

```php
<?php

use Twelver313\RichArray\RichArray;

// Initialize a RichArray
$richArray = new RichArray(
  [1, 2, 3], 
  true  // This parameter is optional. If not passed all mutations of RichArray instance will affect original array. For performance reasons it's `false` by default
);


// Access elements like an array
echo $richArray[0]; // Output: 1

// Use forEach (just like JavaScript)
$richArray->forEach(function ($value, $key) {
    echo "Index: $key, Value: $value\n";
});

// Find an element (returns the first match)
$found = $richArray->find(function ($value) {
    return $value === 2;
});
echo $found; // Output: 2

// Filter elements (returns a new RichArray)
$filtered = $richArray->filter(function ($value) {
    return $value > 1;
});
$filtered->forEach(function ($value) {
    echo $value . ' '; // Output: 2 3
});

// The original array remains unchanged
print_r($richArray); // Output: [1, 2, 3]
```

### Methods Overview

#### `forEach(callable $callback): void`
Iterate over each element, just like JavaScript's `Array.prototype.forEach()`.

```php
$richArray->forEach(function ($value, $key) {
    // Custom logic for each element
});
```

#### `find(callable $callback): mixed`
Find and return the first element that matches the condition.

```php
$found = $richArray->find(function ($value) {
    return $value === 2;
});
```

#### `filter(callable $callback): RichArray`
Filter elements and return a new `RichArray` with the matched elements.

```php
$filtered = $richArray->filter(function ($value) {
    return $value > 1;
});
```

### Full API

- `getLength()` or `length`
- `toRaw()` - library specific method
- `at(int $index)`
- `include($value)`
- `indexOf($value)`
- `lastIndexOf($value)`
- `push(...$values)`
- `pop()`
- `unshift(...$values)`
- `shift()`
- `join(string $delimiter = '')`
- `concat(array ...$array)`
- `slice(int $offset, int $length)`
- `splice(int $offset, int $length, array $replacement = [])`
- `forEach(callable $callback)`
- `filter(callable $callback)`
- `map(callable $callback)`
- `reduce(callable $callback)`
- `reduceRight(callable $callback)`
- `findEntry(callbable $callback)`
- `find(callable $callback)`
- `findIndex(callable $callback)`
- `findLastEntry(callbable $callback)`
- `findLast(callable $callback)`
- `findLastIndex(callable $callback)`
- `some(callable $callback)`
- `every(callable $callback)`
- `sort(callable $callback)`
- `reverse(bool $preserve_key)`
- `toSorted(callable $callback)`
- `toReversed(bool $preserve_key)`

## Why RichArray?

**RichArray** is perfect for developers coming from a JavaScript background who miss the convenience of JavaScript's array methods while working in PHP. This library aims to ease the transition by providing familiar functionality in a PHP-friendly way.

With **RichArray**, you can enjoy:
- Cleaner, more readable code
- Familiar methods and practices
- No need to reinvent array operations in PHP

## License

This library is open-sourced software licensed under the [MIT license](LICENSE).

---

This README introduces **RichArray**, highlights its usefulness for JavaScript developers, and provides basic examples to get started. It should make it clear how to install and use the library, as well as showcase its immutability and similarity to JavaScript array methods.