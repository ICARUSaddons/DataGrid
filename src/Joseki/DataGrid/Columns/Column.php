<?php

namespace Joseki\DataGrid\Columns;

abstract class Column
{

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
