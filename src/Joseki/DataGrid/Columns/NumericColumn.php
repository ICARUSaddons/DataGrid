<?php

namespace Joseki\DataGrid\Columns;

use Joseki\DataGrid\InvalidTypeException;
use Nette\Utils\Callback;

class NumericColumn extends Column
{

    private $thousandSeparator = ' ';

    private $decimalSeparator = '.';

    private $precision = 2;



    public function setFormat($precision = 2, $thousandSeparator = ' ', $decimalSeparator = '.')
    {
        $this->thousandSeparator = $thousandSeparator;
        $this->decimalSeparator = $decimalSeparator;
        $this->precision = $precision;
    }



    /**
     * @return string
     */
    public function getDecimalSeparator()
    {
        return $this->decimalSeparator;
    }



    /**
     * @param string $decimalSeparator
     */
    public function setDecimalSeparator($decimalSeparator)
    {
        $this->decimalSeparator = $decimalSeparator;
    }



    /**
     * @return int
     */
    public function getPrecision()
    {
        return $this->precision;
    }



    /**
     * @param int $precision
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }



    /**
     * @return string
     */
    public function getThousandSeparator()
    {
        return $this->thousandSeparator;
    }



    /**
     * @param string $thousandSeparator
     */
    public function setThousandSeparator($thousandSeparator)
    {
        $this->thousandSeparator = $thousandSeparator;
    }



    public function formatValue($row)
    {
        if ($this->callback) {
            return Callback::invokeArgs($this->callback, [$row, $this]);
        }

        $value = $this->getChainedValue($row);

        if (!is_numeric($value)) {
            $type = is_object($value) ? get_class($value) : gettype($value);
            throw new InvalidTypeException("Expected numeric value, but  '$type' given from '{$this->getName()}'");
        }
        return number_format($value, $this->precision, $this->decimalSeparator, $this->thousandSeparator);
    }

}
