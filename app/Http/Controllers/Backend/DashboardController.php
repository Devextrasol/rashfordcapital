<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Trade;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class DashboardController extends Controller {
  public function index() {

    request()->session()->pull('firstTime');
    if (request()->session()->get('firstTime') !== 'true') {
      DB::insert('insert into log set user_id = ' . auth()->user()->id . " ,  created_at = '" . Carbon::now()->format('Y-m-d H:i:s') . "'");
      request()->session()->put('firstTime', 'true');
      request()->server('HTTP_REFERER', request()->fullUrl());
      $_SERVER['HTTP_REFERER'] = request()->fullUrl();
    }

    $usersCount = User::count();
    $activeUsersCount = User::where('status', User::STATUS_ACTIVE)->count();
    $blockedUsersCount = User::where('status', User::STATUS_BLOCKED)->count();

    $competitionsCount = Competition::count();
    $openCompetitionsCount = Competition::where('status', Competition::STATUS_OPEN)->orWhere('status', Competition::STATUS_IN_PROGRESS)->count();
    $closedCompetitionsCount = Competition::where('status', Competition::STATUS_COMPLETED)->orWhere('status', Competition::STATUS_CANCELLED)->count();

    $tradesCount = Trade::where('status', Trade::STATUS_CLOSED)->count();
    $profitableTradesCount = Trade::where('status', Trade::STATUS_CLOSED)->where('pnl', '>', 0)->count();
    $unprofitableTradesCount = Trade::where('status', Trade::STATUS_CLOSED)->where('pnl', '<=', 0)->count();

    return view('pages.backend.dashboard', [
      'users_count' => $usersCount,
      'active_users_count' => $activeUsersCount,
      'blocked_users_count' => $blockedUsersCount,

      'competitions_count' => $competitionsCount,
      'open_competitions_count' => $openCompetitionsCount,
      'closed_competitions_count' => $closedCompetitionsCount,

      'trades_count' => $tradesCount,
      'profitable_trades_count' => $profitableTradesCount,
      'unprofitable_trades_count' => $unprofitableTradesCount,
    ]);
  }

  public function updateAccounts(Request $request) {

    if (!empty(request()->input('BTC'))) {
      DB::table('deposit_accounts')->where('name', 'BTC')->update(['number' => request()->input('BTC')]);
    }
    if (!empty(request()->input('ETH'))) {
      DB::table('deposit_accounts')->where('name', 'ETH')->update(['number' => request()->input('ETH')]);
    }
    if (!empty(request()->input('LTC'))) {
      DB::table('deposit_accounts')->where('name', 'LTC')->update(['number' => request()->input('LTC')]);
    }
    return redirect()->back();
  }
}
