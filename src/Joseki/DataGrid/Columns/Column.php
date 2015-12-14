<?php

namespace Joseki\DataGrid\Columns;

use Joseki\DataGrid\InvalidPropertyException;
use Nette\Utils\Callback;

abstract class Column
{

    protected $callback;

    private $name;

    private $label;

    private $size = null;



    function __construct($name, $label)
    {
        $this->name = $name;
        $this->label = $label;
    }



    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }



    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }



    /**
     * @param mixed $callback
     */
    public function setCallback($callback)
    {
        Callback::check($callback);
        $this->callback = $callback;
    }



    public function getChainedValue($row)
    {
        $parts = explode('.', $this->getName());
        do {
            $name = array_shift($parts);
            if (!property_exists($row, $name)) {
                throw new InvalidPropertyException("Property '$name' of '{$this->getName()}' does not exist");
            }
            $value = $row = $row->$name;
        } while (count($parts));
        return $value;
    }



    abstract public function formatValue($row);



    /**
     * @return float
     */
    public function getSize()
    {
        return $this->size;
    }



    /**
     * @param float $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }
}
