<?php

namespace Joseki\DataGrid;

use Nette\Utils\Callback;
use Nette\Utils\Strings;

class Link
{
    /** @var  callable */
    protected $condition;

    /** @var string */
    private $link;

    /** @var string */
    private $label;

    /** @var array */
    private $args = [];

    /** @var bool */
    private $usePrimary = true;

    /** @var DataGrid */
    private $grid;

    private $primaryArg;



    /**
     * @param string $link
     * @param string $label
     * @param DataGrid $grid
     */
    function __construct($link, $label, DataGrid $grid)
    {
        $this->link = $link;
        $this->label = $label;
        $this->grid = $grid;
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
    public function getLink()
    {
        return $this->link;
    }



    public function addArg($value, $key = null)
    {
        if (!$key) {
            $key = $this->grid->getPrimaryKey();
        }
        $this->args[$key] = $value;
    }



    public function setPrimaryName($key = null)
    {
        $this->usePrimary = true;
        $this->primaryArg = $key ?: $this->grid->getPrimaryKey();
    }



    public function getPrimaryArg()
    {
        return isset($this->primaryArg) ? $this->primaryArg : $this->grid->getPrimaryKey();
    }



    /**
     * @param null $row
     * @return array
     */
    public function getArgs($row = null)
    {
        if ($row && $this->isUsePrimary()) {
            $property = $this->grid->getPrimaryKey();
            $key = $this->getPrimaryArg();
            return array_merge([$key => $row->$property], $this->args);
        }
        return $this->args;
    }



    /**
     * @param array $args
     * @param bool $usePrimary @deprecated
     * @return $this
     */
    public function setArgs($args, $usePrimary = false)
    {
        $this->args = [];
        $this->usePrimary = false;
        foreach ($args as $key => $value) {
            $this->addArg($value, $key);
        }
        if ($usePrimary) {
            $this->setPrimaryName();
        }
        return $this;
    }



    /**
     * @return boolean
     */
    public function isUsePrimary()
    {
        return $this->usePrimary;
    }



    public function addCondition($callback)
    {
        Callback::check($callback);
        $this->condition = $callback;
    }



    public function isValid($row)
    {
        if ($this->condition) {
            return Callback::invokeArgs($this->condition, [$row]);
        }
        return true;
    }



    public function isSignal()
    {
        return Strings::endsWith($this->getLink(), '!');
    }

}
