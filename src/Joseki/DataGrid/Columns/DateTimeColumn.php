<?php

namespace Joseki\DataGrid\Columns;

use DateTime;
use Joseki\DataGrid\InvalidTypeException;

class DateTimeColumn extends Column
{
    const DATE_FORMAT_CZECH = 'd.m.Y';
    const DATE_FORMAT_INTERNATIONAL = 'Y-m-d';

    protected $dateFormat = self::DATE_FORMAT_CZECH;



    public function formatValue($row)
    {
        $value = $this->getChainedValue($row);

        if (!$value instanceof DateTime) {
            $type = is_object($value) ? get_class($value) : gettype($value);
            throw new InvalidTypeException("Expected object of class 'DateTime', but  '$type' given from '{$this->getName()}'");
        }
        return $value->format($this->dateFormat);
    }



    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }



    /**
     * @param string $dateFormat
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }

}
