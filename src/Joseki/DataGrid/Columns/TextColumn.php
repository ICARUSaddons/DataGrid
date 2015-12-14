<?php

namespace Joseki\DataGrid\Columns;

use Nette\Utils\Callback;

class TextColumn extends Column
{

    public function formatValue($row)
    {
        if ($this->callback) {
            return Callback::invokeArgs($this->callback, [$row, $this]);
        }

        return $this->getChainedValue($row);
    }
}
