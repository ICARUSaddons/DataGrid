<?php

namespace Joseki\DataGrid;

class InvalidArgumentException extends \InvalidArgumentException
{

}

class InvalidStateException extends \RuntimeException
{

}

class InvalidPropertyException extends InvalidArgumentException
{

}

class InvalidTypeException extends InvalidStateException
{

}
