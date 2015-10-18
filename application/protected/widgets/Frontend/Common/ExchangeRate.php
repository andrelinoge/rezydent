<?php

class ExchangeRate extends CWidget
{
    const EXCHANGE_URL = 'http://bank-ua.com/export/currrate.xml';

    public $xmlData;
    /** @var CurrencyModifier */
    protected $currencyModifier;

    public function init()
    {
        $this->xmlData = simplexml_load_file( self::EXCHANGE_URL );
        $this->currencyModifier = CurrencyModifier::getInstance();
    }

    public function run()
    {
        $currencyInfo = $this->getRate( 'USD' );
        $dollar = $currencyInfo->rate / $currencyInfo->size + $this->currencyModifier->getUsdModifier();

        $currencyInfo = $this->getRate( 'EUR' );
        $euro = $currencyInfo->rate / $currencyInfo->size + $this->currencyModifier->getEurModifier();

        $currencyInfo = $this->getRate( 'PLN' );
        $pln = $currencyInfo->rate / $currencyInfo->size + $this->currencyModifier->getPlnModifier();

        $this->render(
            'exchange-rate',
            array(
                'dollar' => $dollar,
                'euro' => $euro,
                'pln' => $pln
            )
        );
    }

    protected function getRate( $code )
    {
        $result = array();

        if ($this->xmlData !== FALSE)
        {
            foreach( $this->xmlData->children() as $item )
            {
                if ( $item->char3 == strtoupper( $code ) )
                {
                    return $item;
                }
            }
        }

        return $result;
    }
}