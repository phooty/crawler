<?php
namespace Phooty\Crawler\Processor\Node;

class GetPriorPlayers implements NodeProcessor
{
    public function process(\DOMNode $node)
    {
        if (isset($node->childNodes[1]->childNodes[0]->attributes[0])) {
            $a = $node->childNodes[1]->childNodes[0]->attributes[0];
            if (!preg_match('/(\d+\.html)$/', $a->value)) {
                return 0;
            }
            return (int) preg_replace('/\D/', '', $a->value);
        }
        return 0;
    }
}
