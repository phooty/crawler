<?php
namespace Phooty\Crawler\Factory\Orm;

use Phooty\Crawler\Factory\DataFactory;

abstract class BaseFactory implements DataFactory
{
    abstract public function build(array $data = []);
}
