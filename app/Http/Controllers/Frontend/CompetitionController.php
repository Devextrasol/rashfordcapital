<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CloseTrade;
use App\Http\Requests\Frontend\JoinCompetition;
use App\Http\Requests\Frontend\OpenTrade;
use App\Models\Asset;
use App\Models\Competition;
use App\Models\Currency;
use App\Models\Sort\Frontend\CompetitionSort;
use App\Models\Sort\Frontend\CompetitionTradeSort;
use App\Models\Trade;
use App\Services\CompetitionService;
use App\Services\TradeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CompetitionController extends Controller {
  private $competitionModel;

  public function __construct(Competition $competition) {
    // save Competition model as a property and use it later in the controller methods,
    // so that other packages can bind their own implementations via IoC
    // If used directly (e.g. $c = Competition::where(...)->get()) bindings will not work and overridden model will not be used.
    $this->competitionModel = $competition;
  }

  public function index(Request $request) {
    $sort = new CompetitionSort($request);

    //old code

    // $competitions = $this->competitionModel::where('status', '!=', Competition::STATUS_CANCELLED)
    //     ->with('currency')
    //     ->withCount(['participants as is_participant' => function ($query) use ($request) {
    //         $query->where('user_id', $request->user()->id);
    //     }])
    //     ->orderBy($sort->getSortColumn(), $sort->getOrder())
    //     ->paginate($this->rowsPerPage);

    // return view('pages.frontend.competitions.index', [
    //     'competitions'  => $competitions,
    //     'sort'          => $sort->getSort(),
    //     'order'         => $sort->getOrder(),
    // ]);
    //old code
//route('frontend.account.show', [Auth::user()])
    //subhani code
    // var_dump($request);
    $user_balance = $request->user()->account->balance;
    if ($user_balance < 1) {
      return redirect()->route('frontend.account.show', $request->user());
    }

    $competition_latest = $this->competitionModel::where('status', '!=', Competition::STATUS_CANCELLED)
      ->with('currency')
      ->withCount(['participants as is_participant' => function ($query) use ($request) {
        $query->where('user_id', $request->user()->id);
      }])
      ->orderBy('created_at', 'desc')->take(1)->first();

    $is_joined = $competition_latest->is_participant;
    $is_able_to_join = (new \App\Rules\UserCanJoinCompetition($competition_latest, auth()->user()))->passes();


    if (!($is_joined) && $is_able_to_join) {
      $competitionService = new CompetitionService($competition_latest);
      $competitionService->join($request->user());

      return redirect()->route('frontend.competitions.show', $competition_latest);
    } else {
      return redirect()->route('frontend.competitions.show', $competition_latest);
    }
    //subhani code

  }

  // public function sidebar(Request $request)
  // {
  //     $sort = new CompetitionSort($request);

  //     $competition_latest = $this->competitionModel::where('status', '!=', Competition::STATUS_CANCELLED)
  //         ->with('currency')
  //         ->withCount(['participants as is_participant' => function ($query) use ($request) {
  //             $query->where('user_id', $request->user()->id);
  //         }])
  //         ->orderBy('created_at', 'desc')->take(1)->first();

  //     // var_dump($competition_latest);

  //     // return view('pages.frontend.competitions.sidebar', [
  //     //     'competition_latest'   => $competition_latest ]);

  // }

  public function show(Request $request, Competition $competition) {

    $competitionParticipant = $competition->participant($request->user());
    $redirect = $this->checkAccessOrRedirect($request, $competition, $competitionParticipant);
    if ($redirect)
      return $redirect;

    // var_dump($request->user()->account->balance);
    // var_dump($competitionParticipant->data->current_balance);
    if ($competitionParticipant->data->current_balance != $request->user()->account->balance) {
      echo "Old user issue: Please contact support";
      // die();
    }


    // get allowed assets for current competition
    $allowedAssets = $competition->assetsIds();
    $allowedAssetsCount = $allowedAssets->count();

    $currencyRate = config('settings.currency') == 'USD' ? 1 : Currency::where('code', 'USD')->first()->rate;

    $defaultAssetId = $request->session()->get('default_asset_id');
    if (($allowedAssetsCount == 0 && $defaultAssetId) || ($allowedAssetsCount > 0 && $allowedAssets->search($defaultAssetId, TRUE) !== FALSE)) {
      $asset = Asset::find($defaultAssetId);
    } else {
      $asset = Asset::where('status', Asset::STATUS_ACTIVE)->where('price', '>', 0)
        // limit returned assets if only specific assets are allowed
        ->when($allowedAssetsCount > 0, function ($query) use ($allowedAssets) {
          return $query->whereIn('id', $allowedAssets->toArray());
        })
        ->inRandomOrder()
        ->first();
    }

    return view('pages.frontend.competitions.show', [
      'competition' => $competition,
      'participant' => $competitionParticipant,
      'asset' => $asset,
      'currency_rate' => $currencyRate,
    ]);
  }

  public function leaderboard(Request $request, Competition $competition) {
    $competitionParticipant = $competition->participant($request->user());
    $redirect = $this->checkAccessOrRedirect($request, $competition, $competitionParticipant);
    if ($redirect)
      return $redirect;

    $leaderboard = $competition
      ->participants()
      ->selectRaw('users.id, users.name, users.avatar, COUNT(trades.id) AS trades_count, IF(MIN(trades.pnl)<0,MIN(trades.pnl),NULL) AS max_loss, IF(MAX(trades.pnl)>0,MAX(trades.pnl),NULL) AS max_profit, SUM(trades.volume*trades.lot_size*trades.price_open) AS total_volume')
      ->leftJoin('trades', function ($join) {
        $join->on('competition_participants.user_id', '=', 'trades.user_id');
        $join->on('competition_participants.competition_id', '=', 'trades.competition_id');
      })
      ->groupBy(
        'competition_participants.id',
        'users.id',
        'users.name',
        'users.avatar',
        // note that when adding pagination to such query Laravel automatically injects "users.*" to the select statement,
        // so all columns in the users table need to be added to group by clause
        'users.email',
        'users.role',
        'users.status',
        'users.password',
        'users.remember_token',
        'users.last_login_time',
        'users.last_login_ip',
        'users.created_at',
        'users.updated_at',
        'users.email_verified_at',
        // -------------
        'competition_participants.competition_id',
        'competition_participants.user_id',
        'competition_participants.place',
        'competition_participants.start_balance',
        'competition_participants.current_balance',
        'competition_participants.created_at',
        'competition_participants.updated_at'
      )
      ->orderByRaw('IF(place IS NOT NULL,-1,1), place') // implementation of "ORDER BY place NULLS LAST"
      ->orderBy('current_balance', 'desc')
      ->orderBy('competition_participants.user_id')
      ->paginate($this->rowsPerPage);

    return view('pages.frontend.competitions.leaderboard', [
      'competition' => $competition,
      'participant' => $competitionParticipant,
      'leaderboard' => $leaderboard,
      'rows_per_page' => $this->rowsPerPage,
    ]);
  }

  public function history(Request $request, Competition $competition) {
    $competitionParticipant = $competition->participant($request->user());
    $redirect = $this->checkAccessOrRedirect($request, $competition, $competitionParticipant);
    if ($redirect)
      return $redirect;

    $sort = new CompetitionTradeSort($request);

    $trades = Trade::select('trades.asset_id', 'trades.direction', 'trades.volume', 'trades.price_open', 'trades.id', 'trades.price_close', 'trades.pnl', 'trades.created_at', 'trades.closed_at')
      ->join('assets', 'assets.id', '=', 'trades.asset_id')
      ->where([
        ['competition_id', $competition->id],
        ['user_id', $request->user()->id],
        ['trades.status', Trade::STATUS_CLOSED]
      ])
      ->with('asset:id,symbol,name,logo')
      ->orderBy($sort->getSortColumn(), $sort->getOrder())
      ->paginate($this->rowsPerPage);

    return view('pages.frontend.competitions.history', [
      'competition' => $competition,
      'participant' => $competitionParticipant,
      'trades' => $trades,
      'sort' => $sort->getSort(),
      'order' => $sort->getOrder(),
    ]);
  }

  public function openPriceupdate(Request $request) {
    return DB::table('trades')->where('id', $request->id)->update($request->only(['price_open']));
  }

  public function join(JoinCompetition $request, Competition $competition) {
    // var_dump($request->user());
    // echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
    // var_dump($competition);
    // die();

    $competitionService = new CompetitionService($competition);
    $competitionService->join($request->user());

    return back()->with('success', __('app.competition_join_success', ['title' => $competition->title]));
  }

  /**
   * Search assets by name or symbol
   *
   * @param $query
   * @return array
   */
  public function searchAsset(Request $request, Competition $competition, $query) {
    $query = trim(strtolower($query));

    // get allowed assets for current competition
    $allowedAssets = $competition->assetsIds();

    // title field is required so correct result value is passed to onSelect() callback (Semantic UI search)
    $assets = Asset::where('status', Asset::STATUS_ACTIVE)
      ->where(function ($sql) use ($query) {
        $sql->whereRaw('LOWER(symbol) LIKE ?', [$query . '%']);
        $sql->orWhereRaw('LOWER(name) LIKE ?', ['%' . $query . '%']);
      })
      // limit returned assets if only specific assets are allowed
      ->when($allowedAssets->count() > 0, function ($query) use ($allowedAssets) {
        return $query->whereIn('id', $allowedAssets->toArray());
      })
      ->orderBy('symbol', 'asc') // should be sorted by symbol first, otherwise BTC selection doesn't work on front end
      ->orderBy('name', 'asc')
      ->limit(10)
      ->get();

    return [
      'success' => TRUE,
      'results' => $assets
    ];
  }

  /**
   * Save a new trade
   *
   * @param Request $request
   * @param Competition $competition
   */
  public function openTrade(OpenTrade $request, Competition $competition, Asset $asset) {
    $tradeService = new TradeService($competition, $request->user());
    return $tradeService->open($asset, $request->direction, $request->volume);
  }


  /**
   * Close an open trade
   *
   * @param CloseTrade $request
   * @param Competition $competition
   * @return array
   */
  public function closeTrade(CloseTrade $request, Competition $competition, Trade $trade) {
    $tradeService = new TradeService($competition, $request->user());
    return $tradeService->close($trade);
  }

  public function trades(Request $request, Competition $competition) {
    return Trade::where([
      ['competition_id', $competition->id],
      ['user_id', $request->user()->id],
      ['status', Trade::STATUS_OPEN]
    ])
      ->with('asset:id,symbol,name,price,logo')
      ->with('competition:id,leverage')
      ->latest()
      ->get();
  }

  public function participants(Competition $competition) {
    return $competition
      ->participants()
      ->orderBy('place', 'asc')
      ->orderBy('current_balance', 'desc')
      ->orderBy('created_at', 'asc')
      ->get();
  }

  private function checkAccessOrRedirect(Request $request, Competition $competition, $competitionParticipant) {
    $route = $request->route()->getName();

    if (in_array($competition->status, [Competition::STATUS_OPEN, Competition::STATUS_CANCELLED])) {
      return redirect()->route('frontend.competitions.index')->with('warning', trans_choice('app.competition_waiting_participants', $competition->slots_required - $competition->slots_taken, ['n' => $competition->slots_required - $competition->slots_taken]));
      // check if user participates in the competition, public access allowed only to the leaderboard tab when competition is closed
    } elseif (!$competitionParticipant && $route != 'frontend.competitions.leaderboard') {
      //return redirect()->route('frontend.competitions.leaderboard', $competition);
      return redirect()->route('frontend.account.show', $request->user());

    } elseif ($competition->status == Competition::STATUS_COMPLETED && $route == 'frontend.competitions.show') {
      //return redirect()->route('frontend.competitions.leaderboard', $competition);
      return redirect()->route('frontend.account.show', $request->user());
    }

    return NULL;
  }
}
