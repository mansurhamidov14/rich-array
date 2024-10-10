<?php

namespace Twelver313\RichArray;

use ArrayAccess;
use Iterator;

class RichArray implements ArrayAccess, Iterator
{
  public function __construct(array $value = []) {
    $this->value = $value;
    $this->position = 0;
    $this->resetKeys();
  }

  use RichArrayTrait;
}