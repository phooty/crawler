<?php
namespace Phooty\Crawler\Processor\Node;

interface NodeProcessor
{
    public function process(\DOMNode $node);
}
