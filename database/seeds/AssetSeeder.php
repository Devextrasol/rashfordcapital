<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get all symbols from the JSON file
        $data = collect(json_decode(file_get_contents(base_path() . '/database/seeds/data/coins.json')));

        // loop through coins and try to insert each coin if it was not added before
        foreach ($data as $item) {
            Asset::firstOrCreate(
                [
                    'symbol' => $item->symbol,
                ],
                [
                    'external_id' => $item->external_id,
                    'name' => $item->name,
                    'logo' => isset($item->logo) ? $item->logo : NULL,
                    'status' => Asset::STATUS_ACTIVE
                ]
            );
        }

        // mark those coins which were removed from the API as blocked
        Asset::whereNotIn('symbol', $data->pluck('symbol'))->update(['status' => Asset::STATUS_BLOCKED]);
    }
}
