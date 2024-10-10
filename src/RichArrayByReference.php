<?php

namespace Twelver313\RichArray;

class RichArrayByReference
{
  use RichArrayTrait;

  public function __construct(&$value = []) {
    $this->value = &$value;
    $this->position = 0;
    $this->resetKeys();
  }
}