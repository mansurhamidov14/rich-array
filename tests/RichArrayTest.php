<?php

use PHPUnit\Framework\TestCase;
use Twelver313\RichArray\RichArray;

class RichArrayTest extends TestCase
{
  public function testGetLength()
  {
    $array = new RichArray(['apple', 'banana', 'cherry']);
    $this->assertEquals(3, $array->length);
  }

  public function testArrayAccess()
  {
    $array = new RichArray(['apple', 'banana', 'cherry']);
    $this->assertEquals('banana', $array[1]);

    $array[1] = 'blueberry';
    $this->assertEquals('blueberry', $array[1]);

    unset($array[1]);
    $this->assertFalse(isset($array[1]));
  }

  public function testForEach()
  {
    $array = new RichArray([10, 20, 30]);
    $output = [];
    $array->forEach(function($value, $key) use (&$output) {
      $output[$key] = $value * 2;
    });

    $this->assertEquals([20, 40, 60], $output);
  }

  public function testPushAndPop()
  {
    $array = new RichArray(['cat', 'dog']);
    $array->push('elephant');
    $this->assertEquals(['cat', 'dog', 'elephant'], $array->toRaw());

    $popped = $array->pop();
    $this->assertEquals('elephant', $popped);
    $this->assertEquals(['cat', 'dog'], $array->toRaw());
  }

  public function testUnshiftAndShift()
  {
    $array = new RichArray(['dog', 'cat']);
    $array->unshift('elephant');
    $this->assertEquals(['elephant', 'dog', 'cat'], $array->toRaw());

    $shifted = $array->shift();
    $this->assertEquals('elephant', $shifted);
    $this->assertEquals(['dog', 'cat'], $array->toRaw());
  }

  public function testMap()
  {
    $array = new RichArray([2, 4, 6]);
    $mapped = $array->map(function ($value) {
      return $value * 2;
    });

    $this->assertEquals([4, 8, 12], $mapped->toRaw());
  }

  public function testFilter()
  {
    $array = new RichArray([5, 10, 15, 20]);
    $filtered = $array->filter(function ($value) {
      return $value >= 15;
    });

    $this->assertEquals([15, 20], $filtered->toRaw());
  }

  public function testFind()
  {
    $array = new RichArray([10, 20, 30, 40]);
    $found = $array->find(function ($value) {
      return $value > 25;
    });

    $this->assertEquals(30, $found);
  }

  public function testFindEntry()
  {
    $array = new RichArray([100, 200, 300, 400]);
    $entry = $array->findEntry(function ($value) {
      return $value >= 300;
    });

    $this->assertEquals([2, 300], $entry->toRaw());
  }

  public function testIncludes()
  {
    $array = new RichArray(['red', 'blue', 'green']);
    $this->assertTrue($array->includes('blue'));
    $this->assertFalse($array->includes('yellow'));
  }

  public function testSomeAndEvery()
  {
    $array = new RichArray([5, 10, 15, 20]);

    // Test some
    $this->assertTrue($array->some(function ($value) {
      return $value > 15;
    }));
    $this->assertFalse($array->some(function ($value) {
      return $value > 25;
    }));

    // Test every
    $this->assertTrue($array->every(function ($value) {
      return $value > 0;
    }));
    $this->assertFalse($array->every(function ($value) {
      return $value > 15;
    }));
  }

  public function testReduce()
  {
    $array = new RichArray([1, 2, 3]);
    $result = $array->reduce(function ($accumulator, $value) {
      return $accumulator + $value;
    }, 0);

    $this->assertEquals(6, $result);
  }

  public function testReverse()
  {
    $array = new RichArray(['alpha', 'beta', 'gamma']);
    $reversed = $array->reverse();

    $this->assertEquals(['gamma', 'beta', 'alpha'], $reversed->toRaw());
  }

  public function testSort()
  {
    $array = new RichArray(['banana', 'apple', 'cherry']);
    $sorted = $array->sort(function ($a, $b) {
      return strcmp($a, $b);
    });

    $this->assertEquals(['apple', 'banana', 'cherry'], $sorted->toRaw());
  }

  public function testConcat()
  {
    $array1 = new RichArray(['red', 'green']);
    $array2 = new RichArray(['blue', 'yellow']);

    $concatenated = $array1->concat($array2->toRaw());

    $this->assertEquals(['red', 'green', 'blue', 'yellow'], $concatenated->toRaw());
  }

  public function testSlice()
  {
    $array = new RichArray([10, 20, 30, 40]);
    $slice = $array->slice(1, 2);

    $this->assertEquals([20, 30], $slice->toRaw());
  }

  public function testJoin()
  {
    $array = new RichArray(['one', 'two', 'three']);
    $joined = $array->join('-');

    $this->assertEquals('one-two-three', $joined);
  }

  public function testIndexOf()
  {
    $array = new RichArray([100, 200, 300]);
    $index = $array->indexOf(200);

    $this->assertEquals(1, $index);
  }

  public function testLastIndexOf()
  {
    $array = new RichArray([10, 20, 20, 30]);
    $lastIndex = $array->lastIndexOf(20);

    $this->assertEquals(2, $lastIndex);
  }
}
