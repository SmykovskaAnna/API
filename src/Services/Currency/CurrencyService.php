<?php

namespace App\Services\Currency;

use App\Entity\Currency;

class CurrencyService
{
    public function createCurrencyObject(string $asset, string $type)
    {
        $currency = new Currency();

        $currency->setAsset($requestBody['asset'] ?? null);
        $currency->setType($requestBody['type'] ?? "");

        return $currency;
    }
}