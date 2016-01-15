<?php

namespace Joseki\DataGrid\Columns;

class MoneyColumn extends NumericColumn
{
    const POSITION_BEFORE = 1;
    const POSITION_AFTER = 2;

    private $currencySymbol = '';

    private $currencyPosition = self::POSITION_AFTER;

    private $currencySeparator = '';



    public function setCurrency($symbol, $position, $currencySeparator = null)
    {
        $this->setCurrencySymbol($symbol);
        $this->setCurrencyPosition($position);
        if ($currencySeparator !== null) {
            $this->setCurrencySeparator($currencySeparator);
        }
    }



    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->currencySymbol;
    }



    /**
     * @param string $currencySymbol
     */
    public function setCurrencySymbol($currencySymbol)
    {
        $this->currencySymbol = $currencySymbol;
    }



    /**
     * @return int
     */
    public function getCurrencyPosition()
    {
        return $this->currencyPosition;
    }



    /**
     * @param int $currencyPosition
     */
    public function setCurrencyPosition($currencyPosition)
    {
        $this->currencyPosition = $currencyPosition;
    }



    /**
     * @return string
     */
    public function getCurrencySeparator()
    {
        return $this->currencySeparator;
    }



    /**
     * @param string $currencySeparator
     */
    public function setCurrencySeparator($currencySeparator)
    {
        $this->currencySeparator = $currencySeparator;
    }



    public function formatValue($row)
    {
        $value = parent::formatValue($row);
        if ($this->currencyPosition === self::POSITION_BEFORE) {
            $value = sprintf('%s%s%s', $this->currencySymbol, $this->currencySeparator, $value);
        } else {
            $value = sprintf('%s%s%s', $value, $this->currencySeparator, $this->currencySymbol);
        }

        return trim($value);
    }

}
