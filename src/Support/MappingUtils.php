<?php
namespace Phooty\Crawler\Support;

use Phooty\Crawler\Mappings\Mapping;

class MappingUtils
{
    /**
     * Attempts to transform a Node into an array conforming to the given
     * MappingsInterface.
     *
     * @param \DOMElement $node
     * @return array
     */
    public static function mapNode(\DOMNode $node, Mapping $mappings)
    {
        $i = 0;
        $data = [];
        foreach ($node->childNodes as $col) {
            $data[$mappings->mappings()[$i]] = $col->textContent;
            $i++;
        }
        return $data;
    }
}
