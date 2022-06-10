<?php

namespace App\Services\API;

class CoinCapApi extends API
{
    protected $baseUri = 'https://api.coincap.io/v2/';

    public function quote($id) {
        return $this->getJson('assets/' . $id);
    }

    public function quotes() {
        return $this->getJson('assets?limit=2000');
    }
}