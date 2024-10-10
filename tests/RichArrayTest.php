<?php

use PHPUnit\Framework\TestCase;
use Twelver313\RichArray\RichArray;

class RichArrayTest extends TestCase
{
  protected $array;

  protected function setUp(): void
  {
    $this->array = new RichArray([10, 20, 30, 40, 50]);
  }

  public function testAccessArrayElements()
  {
    $this->assertEquals(20, $this->array->at(1));
    $this->assertEquals(20, $this->array[1]);
  }

  public function testModifyArrayElementByIndex()
  {
    $this->array[1] = 21;
    $this->assertEquals([10, 21, 30, 40, 50], $this->array->toRaw());
  }

  public function testPushElements()
  {
    $this->array->push(60, 70);
    $this->assertEquals([10, 20, 30, 40, 50, 60, 70], $this->array->toRaw());
  }

  public function testUnshiftElements()
  {
    $this->array->unshift(0);
    $this->assertEquals([0, 10, 20, 30, 40, 50], $this->array->toRaw());
  }

  public function testPopElement()
  {
    $last = $this->array->pop();
    $this->assertEquals(50, $last);
    $this->assertEquals([10, 20, 30, 40], $this->array->toRaw());
  }

  public function testShiftElement()
  {
    $first = $this->array->shift();
    $this->assertEquals(10, $first);
    $this->assertEquals([20, 30, 40, 50], $this->array->toRaw());
  }

  public function testMapOperation()
  {
    $mapped = $this->array->map(function ($value) {
      return $value * 2;
    });
    $this->assertEquals([20, 40, 60, 80, 100], $mapped->toRaw());
  }

  public function testFilterOperation()
  {
    $filtered = $this->array->filter(function ($value) {
      return $value % 20 == 0;
    });
    $this->assertEquals([20, 40], $filtered->toRaw());
  }

  public function testReverseArray()
  {
    $this->array->reverse();
    $this->assertEquals([50, 40, 30, 20, 10], $this->array->toRaw());
  }

  public function testToReversed()
  {
    $reversed = $this->array->toReversed();
    $this->assertEquals([50, 40, 30, 20, 10], $reversed->toRaw());
    $this->assertEquals([10, 20, 30, 40, 50], $this->array->toRaw());
  }

  public function testFindElement()
  {
    $found = $this->array->find(function ($value) {
      return $value < 30;
    });
    $this->assertEquals(10, $found);
  }

  public function testFindIndexElement()
  {
    $foundIndex = $this->array->findIndex(function ($value) {
      return $value < 30;
    });
    $this->assertEquals(0, $foundIndex);
  }

  public function testFindLastElement()
  {
    $foundLast = $this->array->findLast(function ($value) {
      return $value > 30;
    });
    $this->assertEquals(50, $foundLast);
  }

  public function testFindLastIndexElement()
  {
    $foundLastIndex = $this->array->findLastIndex(function ($value) {
      return $value > 30;
    });
    $this->assertEquals(4, $foundLastIndex);
  }

  public function testIncludesValue()
  {
    $includes_20 = $this->array->includes(20);
    $this->assertTrue($includes_20);

    $includes_30 = $this->array->includes(30);
    $this->assertTrue($includes_30);
  }

  public function testReduceArray()
  {
    $sum = $this->array->reduce(function ($accumulator, $value) {
      return $accumulator + $value;
    }, 0);
    $this->assertEquals(150, $sum);
  }

  public function testSliceOperation()
  {
    $sliced = $this->array->slice(1, 3);
    $this->assertEquals([20, 30, 40], $sliced->toRaw());
  }

  public function testConcatOperation()
  {
    $concatenated = $this->array->concat([81, 91, 101]);
    $this->assertEquals([10, 20, 30, 40, 50, 81, 91, 101], $concatenated->toRaw());
  }

  public function testJoinArrayIntoString()
  {
    $joined = $this->array->join('-');
    $this->assertEquals('10-20-30-40-50', $joined);
  }

  public function testSortArrayWithMutation()
  {
    $arrayForSortingWithMutation = new RichArray([3, 4, 2, 1, 6]);
    $arrayForSortingWithMutation->sort(function ($a, $b) {
      return $a - $b;
    });
    $this->assertEquals([1, 2, 3, 4, 6], $arrayForSortingWithMutation->toRaw());
  }

  public function testSortArrayWithoutMutation()
  {
    $arrayForSortingWithoutMutation = new RichArray([3, 4, 2, 1, 6]);
    $sorted = $arrayForSortingWithoutMutation->toSorted(function ($a, $b) {
      return $b - $a;
    });
    $this->assertEquals([6, 4, 3, 2, 1], $sorted->toRaw());
    $this->assertEquals([3, 4, 2, 1, 6], $arrayForSortingWithoutMutation->toRaw());
  }

  public function testSpliceOperation()
  {
    $arrayToSplice = new RichArray([11, 22, 33, 44, 55, 66, 77, 88, 99]);
    $spliced = $arrayToSplice->splice(3, 2);
    $this->assertEquals([44, 55], $spliced->toRaw());
    $this->assertEquals([11, 22, 33, 66, 77, 88, 99], $arrayToSplice->toRaw());
  }

  public function testSomeOperationTrue()
  {
    $array = new RichArray([10, 20, 30, 40, 50]);

    $someTrue = $array->some(function ($value) {
      return $value > 30; // Should return true (since 40 and 50 are greater than 30)
    });

    $this->assertTrue($someTrue);
  }

  public function testSomeOperationFalse()
  {
    $array = new RichArray([10, 20, 30, 40, 50]);

    $someFalse = $array->some(function ($value) {
      return $value > 60; // Should return false (no elements greater than 60)
    });

    $this->assertFalse($someFalse);
  }

  public function testEveryOperationTrue()
  {
    $array = new RichArray([10, 20, 30, 40, 50]);

    $everyTrue = $array->every(function ($value) {
      return $value > 5; // Should return true (all elements are greater than 5)
    });

    $this->assertTrue($everyTrue);
  }

  public function testEveryOperationFalse()
  {
    $array = new RichArray([10, 20, 30, 40, 50]);

    $everyFalse = $array->every(function ($value) {
      return $value > 40; // Should return false (not all elements are greater than 40)
    });

    $this->assertFalse($everyFalse);
  }

  public function testReduceRight()
  {
    $array = new RichArray([10, 20, 30]);

    $sumRight = $array->reduceRight(function ($accumulator, $value) {
      return $accumulator + $value; // Should sum up values from right to left
    }, 0);

    $this->assertEquals(60, $sumRight); // 30 + 20 + 10 = 60
  }

  public function testIndexOf()
  {
    $array = new RichArray([4, 5, 6, 6, 7]);

    $indexOf6 = $array->indexOf(6);
    $indexOf8 = $array->indexOf(8);

    $this->assertEquals(2, $indexOf6); // First index of 6 is at position 2
    $this->assertEquals(-1, $indexOf8); // Element 8 is not in the array, should return -1
  }

  public function testLastIndexOf()
  {
    $array = new RichArray([4, 5, 6, 6, 7]);

    $lastIndexOf6 = $array->lastIndexOf(6);
    $lastIndexOf8 = $array->lastIndexOf(8);

    $this->assertEquals(3, $lastIndexOf6); // Last index of 6 is at position 3
    $this->assertEquals(-1, $lastIndexOf8); // Element 8 is not in the array, should return -1
  }
}
