<?php

namespace Joseki\DataGrid\Columns;

use Nette\Utils\Callback;

class TextColumn extends Column
{

    private $callback;



    /**
     * @param mixed $callback
     */
    public function setCallback($callback)
    {
        Callback::check($callback);
        $this->callback = $callback;
    }



    public function formatValue($row)
    {
        if ($this->callback) {
            return Callback::invokeArgs($this->callback, [$row]);
        }

        $parts = explode('.', $this->getName());
        do {
            $name = array_shift($parts);
            $value = $row = $row->$name;
        } while (count($parts));
        return $value;
    }
}
