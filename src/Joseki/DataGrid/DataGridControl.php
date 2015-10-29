<?php

namespace Joseki\DataGrid;

use Nette\Application\UI\Control;

abstract class DataGridControl extends Control
{

    abstract function dataCallback($filter = [], $orderBy = null, $lastKey = null);



    protected final function createComponentGrid()
    {
        $control = new DataGrid();
        $this->gridFactory($control);
        $control->setDataCallback($this->dataCallback);

        return $control;
    }



    abstract function gridFactory(DataGrid $dataGrid);
} 
