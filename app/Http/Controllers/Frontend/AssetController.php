<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Asset;
use App\Http\Controllers\Controller;
use App\Models\Sort\Frontend\AssetSort;
use App\Services\AssetService;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $sort = new AssetSort($request);

        $assets = Asset::where('status', Asset::STATUS_ACTIVE)
            ->withCount('trades')
            ->orderBy($sort->getSortColumn(), $sort->getOrder())
            ->paginate($this->rowsPerPage);

        return view('pages.frontend.assets.index', [
            'assets'    => $assets,
            'sort'      => $sort->getSort(),
            'order'     => $sort->getOrder(),
        ]);
    }

    public function all(Request $request)
    {
        $sort = new AssetSort($request);

        $assets = Asset::where('status', Asset::STATUS_ACTIVE)
        ->where('status', Asset::STATUS_ACTIVE)
        ->orderBy($sort->getSortColumn(), $sort->getOrder())
        ->limit(10)
        ->get();


        return [
            'success' => TRUE,
            'results' => $assets
        ];
    }


    /**
     * Save asset ID in session
     *
     * @param Request $request
     * @param Asset $asset
     * @return array
     */
    public function remember(Request $request, Asset $asset)
    {
        session(['default_asset_id' => $asset->id]);
        return ['success' => TRUE];
    }

    /**
     * Search assets by name or symbol
     *
     * @param $query
     * @return array
     */
    public function search($query) {
        $query = strtolower($query);

        // title field is required so correct result value is passed to onSelect() callback (Semantic UI search)
        $assets = Asset::select('name', 'id AS value')
            ->where('status', Asset::STATUS_ACTIVE)
            ->where(function($sql) use($query) {
                $sql->whereRaw('LOWER(symbol) LIKE ?', [$query.'%']);
                $sql->orWhereRaw('LOWER(name) LIKE ?', ['%'.$query.'%']);
            })
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get()
            ->makeHidden(['logo_url', 'title']); // hide custom logo_url and title attributes appended by default

        return [
            'success' => TRUE,
            'results' => $assets
        ];
    }

    public function info(Request $request)
    {
        $assetsIds = array_filter($request->ids ?: [], function ($id) {
            return intval($id) > 0;
        });

        $assets = [];

        if (!empty($assetsIds)) {
            $assetService = new AssetService();
            foreach ($assetsIds as $assetId) {
                $asset = Asset::findOrFail($assetId);
                if ($asset->status == Asset::STATUS_ACTIVE) {
                    $assets[] = $assetService->asset($asset);
                }
            }
        }

        return $assets;
    }
}
