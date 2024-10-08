<?php

namespace Twelver313\RichArray;

class RichArray implements \ArrayAccess
{
  private $value = [];

  public function __construct(array $value = []) {
    $this->value = $value;
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
    return array_push($this->value, ...func_get_args());
  }

  public function unshift(): int {
    return array_unshift($this->value, ...func_get_args());
  }

  public function pop() {
    return array_pop($this->value);
  }

  public function shift() {
    return array_shift($this->value);
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
    };
    return $filtered_arr;
  }

  public function reverse($preserve_keys = false): RichArray {
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
    return $this->reverse(true)->findEntry($callback);
  }

  public function findLast(callable $callback) {
    $entry = $this->findLastEntry($callback);
    return $entry[1];
  }

  public function findLastIndex(callable $callback): int {
    $entry = $this->findLastEntry($callback);
    return $entry[0];
  }

  public function includes($value): bool {
    foreach ($this->value as $k => $v) {
      if ($v == $value) {
        return true;
      }
    }

    return false;
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
    return $this->reverse()->reduce($callback, $initial);
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

  public function concat() {
    return new self(array_merge($this->value, ...func_get_args()));
  }

  public function indexOf($value) {
    foreach ($this->value as $k => $v) {
      if ($value == $v) {
        return $k;
      }
    }

    return -1;
  }

  public function lastIndexOf($value) {
    $reversed = array_reverse($this->value, true);
    foreach ($reversed as $k => $v) {
      if ($value == $v) {
        return $k;
      }
    }

    return -1;
  }

  public function sort(callable $callback): RichArray {
    $copy = $this->value;

    if ($callback) {
      usort($copy, $callback);
    } else {
      sort($copy);
    }

    return new self($copy);
  }
}