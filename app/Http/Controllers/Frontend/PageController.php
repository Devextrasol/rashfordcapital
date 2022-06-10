<?php

namespace App\Http\Controllers\Frontend;

// new code for assets table
use App\Models\Asset;
use App\Models\Sort\Frontend\AssetSort;
use App\Services\AssetService;
use Illuminate\Http\Request;
// new code for assets table
use App\Models\Trade;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{
    public function index() {
        $recentTrades = Trade::with('asset', 'currency')->orderBy('trades.id', 'desc')->limit(5)->get();
        return view('pages.frontend.index', ['recent_trades' => $recentTrades]);
    }
    //new home page
    public function index_new(Request $request) {
        $recentTrades = Trade::with('asset', 'currency')->orderBy('trades.id', 'desc')->limit(5)->get();

        $sort = new AssetSort($request);

        $assets = Asset::where('status', Asset::STATUS_ACTIVE)
            ->withCount('trades')
            ->orderBy($sort->getSortColumn(), $sort->getOrder())
            ->paginate($this->rowsPerPage);


        return view('pages.frontend.index_new', [
            'assets'    => $assets,
            'sort'      => $sort->getSort(),
            'order'     => $sort->getOrder(),
        ]);
    }
    //new home page


    public function help() {
        return view('pages.frontend.help');
    }

    /**
     * Display static page
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function display($slug)
    {
        return view()->exists('pages.frontend.static.' . $slug . '-udf') // try to load user defined view first
            ? view('pages.frontend.static.' . $slug . '-udf')
            : (view()->exists('pages.frontend.static.' . $slug)
                ? view('pages.frontend.static.' . $slug)
                : abort(404));
    }

    public function acceptCookies() {
        Cookie::queue(Cookie::make('cookie_usage_accepted', 1, 525600)); // 60*24*365 = 1 year
        return ['success' => TRUE];
    }
}
