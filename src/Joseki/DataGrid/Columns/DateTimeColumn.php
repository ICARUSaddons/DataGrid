<?php

namespace Netiso\Joseki\DataGrid\Columns;

use DateTime;

class DateTimeColumn extends Column
{
    const DATE_FORMAT_CZECH = 'd.m.Y';
    const DATE_FORMAT_INTERNATIONAL = 'Y-m-d';

    protected $dateFormat = self::DATE_FORMAT_CZECH;



    public function formatValue($row)
    {
        $parts = explode('.', $this->getName());
        do {
            $name = array_shift($parts);
            $value = $row = $row->$name;
        } while (count($parts));

        /** @var DateTime $value */
        if ($value) {
            return $value->format($this->dateFormat);
        }
        return null;
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
