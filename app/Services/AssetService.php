<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\Currency;
use App\Services\API\CoinCapApi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AssetService extends Service
{
    private $api;

    public function __construct()
    {
        $this->api = new CoinCapApi();
    }

    /**
     * Return asset either from cache or from database
     *
     * @param Asset $asset
     * @return Asset
     */
    public function asset(Asset $asset) {
        $cacheTime = intval(config('settings.assets_quotes_rest_api_poll_freq')) / 60; // cache time in minutes
        return Cache::remember('asset-' . $asset->id, $cacheTime, function () use ($asset) {
            return $this->updateMarketData($asset);
        });
    }

    /**
     * Refresh data for a given asset and return it back
     *
     * @param Asset $asset
     * @return Asset
     */
    public function updateMarketData(Asset $asset) {
        if ($asset->external_id) {
            $data = $this->api->quote($asset->external_id); 
            if (isset($data->data)) {
                $quote = $data->data;
                Log::info(json_encode($quote));
                $baseCurrencyRate = $this->baseCurrencyRate();
                $asset->price = $quote->priceUsd ? $quote->priceUsd / $baseCurrencyRate : 0;
                $asset->volume = $quote->volumeUsd24Hr ? $quote->volumeUsd24Hr / $baseCurrencyRate : 0;
                $asset->supply = $quote->supply ?: 0;
                $asset->market_cap = $quote->marketCapUsd ? $quote->marketCapUsd / $baseCurrencyRate : 0;
                $asset->save();
            }
        }

        return $asset;
    }

    public function bulkUpdateMarketData() {
        // pull current quotes (bulk) from API and convert them to an array of objects keyed by symbol
        $quotes = collect((array) $this->api->quotes()->data)->keyBy('symbol');
        $baseCurrencyRate = $this->baseCurrencyRate();

        // loop through assets in the DB and update quotes
        foreach (Asset::cursor() as $asset) {
            if ($quote = $quotes->get($asset->symbol)) {
                $asset->external_id = $quote->id;
                $asset->price       = $quote->priceUsd ? $quote->priceUsd / $baseCurrencyRate : 0;
                $asset->change_pct  = $quote->changePercent24Hr ? round($quote->changePercent24Hr, 2) : 0;
                $asset->change_abs  = $asset->price * $asset->change_pct / (100 + $asset->change_pct);
                $asset->volume      = $quote->volumeUsd24Hr ? $quote->volumeUsd24Hr / $baseCurrencyRate : 0;
                $asset->supply      = $quote->supply ?: 0;
                $asset->market_cap  = $quote->marketCapUsd ? $quote->marketCapUsd / $baseCurrencyRate : 0;
                $asset->save();
            }
        }
    }

    /**
     * Get base currency rate
     *
     * @return int
     */
    private function baseCurrencyRate() {
        // asset quotes are retrieved in USD,
        // so if default currency is different quotes need to be converted from USD to default currency
        if (config('settings.currency') != 'USD') {
            // in this case USD currency rate will be different from 1
            $baseCurrencyRate = Currency::find(1)->rate ?: 1;
        } else {
            $baseCurrencyRate = 1;
        }

        return $baseCurrencyRate;
    }
}
