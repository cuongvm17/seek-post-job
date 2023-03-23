<?php namespace Seek\Entities;

use Seek\Exceptions\InvalidArgumentException;

/**
 * Entity abstract class
 */
abstract class Entity
{
    abstract function getArray();
}
