<?php

namespace JosekiTests\DataGrid;

use Joseki\DataGrid\Columns\TextColumn;
use Joseki\DataGrid\DataGrid;
use Nette\Utils\ArrayHash;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class LinkTest extends \Tester\TestCase
{

    public function testArgs()
    {
        $row = ArrayHash::from(
            [
                'id' => 5,
                'foo' => 'aaa',
            ]
        );

        $datagrid = new DataGrid();
        $link = $datagrid->addLink(':Article:edit', 'Edit');

        Assert::equal([], $link->getArgs());
        Assert::equal([], $link->getArgs($row));

        $link->setPrimaryName();
        Assert::equal('id', $link->getPrimaryArg());
        Assert::equal(['id' => 5], $link->getArgs($row));

        $link->setPrimaryName('foo');
        Assert::equal('foo', $link->getPrimaryArg());
        Assert::equal(['foo' => 5], $link->getArgs($row));

        $datagrid->setPrimaryKey('foo');
        Assert::equal(['foo' => 'aaa'], $link->getArgs($row));

    }

}

\run(new LinkTest());
