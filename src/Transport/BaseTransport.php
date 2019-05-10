<?php
namespace Phooty\Crawler\Transport;

/**
 * Transport classes act as the mediator between the data extracted by the
 * crawler and a valid Entity.
 * 
 * Transport objects should be mutable until they become an Entity, whereas an
 * Entity, once created, should be immutable.
 * 
 * Currently very basic wrapper around ArrayObject.
 */
abstract class BaseTransport implements \JsonSerializable
{
    protected const SCALAR_FIELD = 'scalar';

    protected const NUMBER_FIELD = 'number';
    
    protected const BOOL_FIELD = 'bool';

    protected $id;

    protected $fields;

    protected $vals = [];

    public function __construct(array $items = [])
    {
        empty($items) ?: $this->setAll($items);
    }

    protected function fillEmptyAsNull()
    {
        if (!is_array($this->fields)) {
            return $this->vals;
        }
        $data = [];
        foreach ($this->fields as $field) {
            $data[$field] = $this->vals[$field] ?? null;
        }
        return $data;
    }

    protected function isValidField(string $field)
    {
        //dd($this);
        if (!is_array($this->fields) || empty($this->fields)) {
            return true;
        }
        return in_array($field, $this->fields);
    }

    public function get(string $field)
    {
        if (!isset($this->vals[$field])) {
            throw new \InvalidArgumentException("Invalid field: {$field}");
        }
        
        return $this->vals[$field];
    }

    public function set(string $field, $value)
    {
        if ('id' === $field) { 
            if (isset($this->id)) {
                throw new \InvalidArgumentException("Id is already set.");
            }
            $this->id = $value;
            return $this;
        }
        if (!$this->isValidField($field)) {
            throw new \InvalidArgumentException("Invalid field: {$field}");
        }
        $this->vals[$field] = $value;
        return $this;
    }

    public function setAll(array $data)
    {
        foreach ($data as $field => $val) {
            $this->set($field, $val);
        }
        return $this;
    }

    public function hasValueFor(string $field)
    {
        return isset($this->vals[$field]);
    }

    public function getAll()
    {
        return $this->fillEmptyAsNull();
        //return $this->vals;
    }

    public function jsonSerialize()
    {
        return $this->getAll();
    }
}
