<?php

namespace JosekiTests\DataGrid;

use Joseki\DataGrid\Columns\NumericColumn;
use Joseki\DataGrid\DataGrid;
use Nette\Utils\ArrayHash;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class NumericColumnTest extends \Tester\TestCase
{

    public function testFormat()
    {
        $data = ArrayHash::from(
            [
                'foo' => 500.36,
                'zero' => 0,
                'bar' => ArrayHash::from(
                    [
                        'hello' => 100.1,
                        'world' => 121.21,
                        'text' => 'error',
                    ]
                ),
            ]
        );

        $datagrid = new DataGrid();

        $column = new NumericColumn('foo', 'FOO', $datagrid);
        Assert::equal('500.36', $column->formatValue($data));
        $column = new NumericColumn('zero', 'ZERO', $datagrid);
        Assert::equal('0.00', $column->formatValue($data));

        $column = new NumericColumn('bar.hello', 'HELLO', $datagrid);
        Assert::equal('100.10', $column->formatValue($data));
        $column = new NumericColumn('bar.world', 'WORLD', $datagrid);
        Assert::equal('121.21', $column->formatValue($data));

        Assert::exception(
            function () use ($data, $datagrid) {
                $column = new NumericColumn('bar.text', 'Text', $datagrid);
                $column->formatValue($data);
            },
            'Joseki\DataGrid\InvalidTypeException'
        );

    }

}

\run(new NumericColumnTest());
