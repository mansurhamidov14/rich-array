<?php

namespace Twelver313\RichArray;

use ArrayAccess;
use Iterator;

class RichArray implements ArrayAccess, Iterator
{
  private $value;
  private $position;
  private $keys;

  public function __construct(array $value = [], bool $preserve_original = false) {
    if ($preserve_original) {
      $this->value = $value;
    } else {
      $this->value = &$value;
    }
    $this->position = 0;
    $this->resetKeys();
  }

  private function resetKeys() {
    $this->keys = array_keys($this->value);
  }

  public function rewind() {
    $this->position = 0; // Reset the position to the first key
  }

  public function current() {
    $key = $this->keys[$this->position]; // Get the key at the current position
    return $this->value[$key]; // Return the value for the current key
  }

  public function key() {
    return $this->keys[$this->position]; // Return the actual key at the current position
  }

  public function next() {
    ++$this->position;
  }

  public function valid(): bool {
    return isset($this->keys[$this->position]);
  }

  public function getLength(): int {
    return count($this->value);
  }

  public function toRaw(): array {
    return $this->value;
  }

  public function __get(string $name) {
    if ($name == 'length') {
      return $this->getLength();
    }

    return null;
  }

  public function offsetExists($offset): bool {
    return isset($this->value[$offset]);
  }

  public function offsetGet($offset) {
    return $this->value[$offset];
  }

  public function at($offset) {
    return $this->offsetGet($offset);
  }

  public function offsetSet($offset, $value) {
    $this->value[$offset] = $value;
  }

  public function offsetUnset($offset) {
    unset($this->value[$offset]);
  }

  public function forEach(callable $callback): void {
    foreach ($this->value as $key => $value) {
      $callback($value, $key);
    }
  }

  public function push(): int {
    $res = array_push($this->value, ...func_get_args());
    $this->resetKeys();
    return $res;
  }

  public function unshift(): int {
    $res = array_unshift($this->value, ...func_get_args());
    $this->resetKeys();
    $this->position++;
    return $res;
  }

  public function pop() {
    $res = array_pop($this->value);
    $this->resetKeys();
    return $res;
  }

  public function shift() {
    $res = array_shift($this->value);
    $this->resetKeys();
    if (!empty($this->position)) $this->position--;
    return $res;
  }

  public function map(callable $callback): RichArray {
    $mapped_arr = new self();
    foreach ($this->value as $key => $value) {
      $mapped_arr->offsetSet($key, $callback($value, $key));
    }
    return $mapped_arr;
  }

  public function filter(callable $callback): RichArray {
    $filtered_arr = new self();
    foreach ($this->value as $key => $value) {
      if ($callback($value, $key)) {
        $filtered_arr->push($value);
      }
    }
    return $filtered_arr;
  }

  public function reverse($preserve_keys = false) {
    $this->value = $this->toReversed($preserve_keys)->toRaw();
  }

  public function toReversed($preserve_keys = false): RichArray {
    return new self(array_reverse($this->value, $preserve_keys));
  }

  public function findEntry(callable $callback): RichArray {
    foreach ($this->value as $key => $value) {
      if ($callback($value, $key)) {
        return new self([$key, $value]);
      }
    }

    return new self([-1, null]);
  }

  public function find(callable $callback) {
    $entry = $this->findEntry($callback);
    return $entry[1];
  }

  public function findIndex(callable $callback) {
    $entry = $this->findEntry($callback);
    return $entry[0];
  }

  public function findLastEntry(callable $callback): RichArray {
    return $this->toReversed(true)->findEntry($callback);
  }

  public function findLast(callable $callback) {
    $entry = $this->findLastEntry($callback);
    return $entry[1];
  }

  public function findLastIndex(callable $callback): int {
    $entry = $this->findLastEntry($callback);
    return $entry[0];
  }

  public function includes($value, $strict = false): bool {
    return in_array($value, $this->value, $strict);
  }

  public function some(callable $callback): bool {
    return boolval($this->find($callback));
  }

  public function every(callable $callback): bool {
    foreach ($this->value as $k => $v) {
      if (!$callback($v, $k)) {
        return false;
      }
    }

    return true;
  }

  public function reduce(callable $callback, $initial = null) {
    $accumulator = $initial ?? new self();

    foreach ($this->value as $key => $value) {
      $accumulator = $callback($accumulator, $value, $key);
    }

    return $accumulator;
  }

  public function reduceRight(callable $callback, $initial = null) {
    return $this->toReversed()->reduce($callback, $initial);
  }

  public function slice(int $offset, int $length = null): RichArray {
    return new self(array_slice($this->value, $offset, $length));
  }

  public function splice(int $offset, int $length = null, array $replacement = []): RichArray {
    return new self(array_splice($this->value, $offset, $length, $replacement));
  }

  public function join(string $delimiter = ','): string {
    return implode($delimiter, $this->value);
  }

  public function concat(...$arrays): RichArray {
    $concat_arrays = [];
    foreach ($arrays as $array) {
      if (is_a($array, RichArray::class)) {
        $concat_arrays[] = $array->toRaw();
      } else {
        $concat_arrays[] = $array;
      }
    }
    return new self(array_merge($this->value, ...$concat_arrays));
  }

  public function indexOf($value) {
    $index = array_search($value, $this->value);
    if ($index === false) return -1;
    return $index;
  }

  public function lastIndexOf($value) {
    return $this->toReversed(true)->indexOf($value);
  }

  public function sort(callable $callback): RichArray {
    if ($callback) {
      usort($this->value, $callback);
    } else {
      sort($this->value);
    }

    return $this;
  }

  public function toSorted(callable $callback): RichArray {
    $copy = new self($this->value);
    return $copy->sort($callback);
  }
}