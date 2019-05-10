<?php
namespace Phooty\Crawler\Factory;

use Ramsey\Uuid\Uuid;

abstract class BaseFactory implements DataFactory
{
    abstract public function build(array $data = []);

    protected function generateUuid()
    {
        return Uuid::uuid1()->toString();
    }
}
