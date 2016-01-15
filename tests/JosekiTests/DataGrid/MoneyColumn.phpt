<?php

namespace JosekiTests\DataGrid;

use Joseki\DataGrid\Columns\MoneyColumn;
use Joseki\DataGrid\DataGrid;
use Nette\Utils\ArrayHash;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class MoneyColumnTest extends \Tester\TestCase
{

    public function testFormat()
    {
        $data = ArrayHash::from(
            [
                'left' => 500.36,
                'right' => 4000.366,
            ]
        );

        $datagrid = new DataGrid();

        $column = new MoneyColumn('left', 'Left', $datagrid);
        Assert::equal('500.36', $column->formatValue($data));

        $column = new MoneyColumn('right', 'Right', $datagrid);
        Assert::equal('4 000.37', $column->formatValue($data));

        $column->setCurrency('$', MoneyColumn::POSITION_BEFORE);
        Assert::equal('$4 000.37', $column->formatValue($data));

        $column->setCurrency('Kč', MoneyColumn::POSITION_AFTER);
        Assert::equal('4 000.37Kč', $column->formatValue($data));

        $column->setCurrency('Kč', MoneyColumn::POSITION_AFTER, ',- ');
        Assert::equal('4 000.37,- Kč', $column->formatValue($data));
    }

}

\run(new MoneyColumnTest());
