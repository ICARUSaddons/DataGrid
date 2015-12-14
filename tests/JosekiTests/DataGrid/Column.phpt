<?php

namespace JosekiTests\DataGrid;

use Joseki\DataGrid\Columns\TextColumn;
use Nette\Utils\ArrayHash;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class ColumnTest extends \Tester\TestCase
{

    public function testFormat()
    {
        $data = ArrayHash::from(
            [
                'foo' => 'aaa',
                'bar' => ArrayHash::from(
                    [
                        'hello' => 'bbb',
                    ]
                ),
            ]
        );

        $column = new TextColumn('foo', 'FOO');
        Assert::equal('aaa', $column->formatValue($data));

        $column = new TextColumn('bar.hello', 'HELLO');
        Assert::equal('bbb', $column->formatValue($data));

        Assert::exception(
            function () use($data) {
                $column = new TextColumn('bar.world', 'WORLD');
                $column->getChainedValue($data);
            },
            'Joseki\DataGrid\InvalidPropertyException'
        );

    }

}

\run(new ColumnTest());
