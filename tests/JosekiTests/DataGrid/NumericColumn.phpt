<?php

namespace JosekiTests\DataGrid;

use Joseki\DataGrid\Columns\NumericColumn;
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

        $column = new NumericColumn('foo', 'FOO');
        Assert::equal('500.36', $column->formatValue($data));
        $column = new NumericColumn('zero', 'ZERO');
        Assert::equal('0.00', $column->formatValue($data));

        $column = new NumericColumn('bar.hello', 'HELLO');
        Assert::equal('100.10', $column->formatValue($data));
        $column = new NumericColumn('bar.world', 'WORLD');
        Assert::equal('121.21', $column->formatValue($data));

        Assert::exception(
            function () use ($data) {
                $column = new NumericColumn('bar.text', 'Text');
                $column->formatValue($data);
            },
            'Joseki\DataGrid\InvalidTypeException'
        );

    }

}

\run(new NumericColumnTest());
