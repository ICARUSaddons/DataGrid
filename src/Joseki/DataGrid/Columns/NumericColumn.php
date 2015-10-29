<?php

namespace Joseki\DataGrid\Columns;

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
        $parts = explode('.', $this->getName());
        do {
            $name = array_shift($parts);
            $value = $row = $row->$name;
        } while (count($parts));

        if ($value) {
            return number_format($value, $this->precision, $this->decimalSeparator, $this->thousandSeparator);
        }
        return null;
    }

}
