<?php

namespace JosekiTests\DataGrid;

use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class ExampleTest extends \Tester\TestCase
{

    public function testFoo()
    {
        Assert::true(true);
    }

}

\run(new ExampleTest());
