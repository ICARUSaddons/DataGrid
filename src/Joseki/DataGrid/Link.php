<?php

namespace Netiso\Joseki\DataGrid;

use Nette\Utils\Callback;

class Link
{
    /** @var  callable */
    protected $condition;

    /** @var string */
    private $primaryArgName = 'id';

    /** @var string */
    private $link;

    /** @var string */
    private $label;

    /** @var array */
    private $args = [];

    /** @var bool */
    private $usePrimary = false;



    /**
     * @param string $link
     * @param string $label
     */
    function __construct($link, $label)
    {
        $this->link = $link;
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
    public function getLink()
    {
        return $this->link;
    }



    /**
     * @param null $row
     * @return array
     */
    public function getArgs($row = null)
    {
        if ($row && $this->isUsePrimary()) {
            return array_merge([$this->getPrimaryArgName() => $row->id], $this->args);
        }
        return $this->args;
    }



    /**
     * @param array $args
     * @param bool $usePrimary
     * @param string $primaryArgName
     * @return $this
     */
    public function setArgs($args, $usePrimary = false, $primaryArgName = 'id')
    {
        $this->args = $args;
        $this->usePrimary = $usePrimary;
        $this->primaryArgName = $primaryArgName;
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



    /**
     * @return string
     */
    public function getPrimaryArgName()
    {
        return $this->primaryArgName;
    }

}
