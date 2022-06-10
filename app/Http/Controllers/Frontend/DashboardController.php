<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Competition;
use App\Models\Trade;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
  public function index() {

    if (request()->session()->get('firstTime') !== 'true') {
      DB::insert('insert into log set user_id = ' . auth()->user()->id . " ,  created_at = '" . Carbon::now()->format('Y-m-d H:i:s') . "'");
      request()->session()->put('firstTime', 'true');
      request()->server('HTTP_REFERER', request()->fullUrl());
      $_SERVER['HTTP_REFERER'] = request()->fullUrl();
    }

    $myCompetitions = Competition::whereHas('participants', function ($query) {
      $query->where('user_id', auth()->user()->id);
    })
      ->orderBy('end_time')
      ->get();

    $topTradedAssets = Asset::selectRaw('symbol, logo, COUNT(*) AS trades_count')
      ->where('assets.status', Asset::STATUS_ACTIVE)
      ->join('trades', 'assets.id', '=', 'trades.asset_id')
      ->groupBy('symbol', 'logo')
      ->orderBy('trades_count', 'desc')
      ->orderBy('symbol', 'asc')
      ->limit(6)
      ->get();

    $topTraders = Trade::selectRaw('user_id, COUNT(*) AS profitable_trades')
      ->where('status', Trade::STATUS_CLOSED)
      ->where('pnl', '>', 0)
      ->with('user')
      ->groupBy('user_id')
      ->orderBy('profitable_trades', 'desc')
      ->limit(6)
      ->get();

    $topTrades = Trade::where('status', Trade::STATUS_CLOSED)
      ->where('pnl', '>', 0)
      ->with('user', 'currency')
      ->orderBy('pnl', 'desc')
      ->limit(5)
      ->get();

    return view('pages.frontend.dashboard', [
      'my_competitions' => $myCompetitions,
      'top_traded_assets' => $topTradedAssets,
      'top_traders' => $topTraders,
      'top_trades' => $topTrades,
    ]);
  }
}
