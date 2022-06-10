<?php

namespace Packages\Accounting\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Packages\Accounting\Models\Deposit;
use Packages\Accounting\Models\Sort\Backend\DepositSort;

class DepositController extends Controller {
  /**
   * Deposits listing
   *
   * @param Request $request
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function index(Request $request) {
    $sort = new DepositSort($request);

    $deposits = Deposit::select(
      'deposits.*',
      'users.id AS user_id',
      'users.name AS user_name',
      'payment_methods.code AS payment_method_code',
      'acc_currencies.code AS account_currency_code'
    )
      ->join('accounts', 'deposits.account_id', '=', 'accounts.id')
      ->join('users', 'accounts.user_id', '=', 'users.id')
      ->join('payment_methods', 'deposits.payment_method_id', '=', 'payment_methods.id')
      ->join('currencies AS acc_currencies', 'accounts.currency_id', '=', 'acc_currencies.id')
      ->where('deposits.amount', '>', 2)
      ->orderBy($sort->getSortColumn(), $sort->getOrder())
      ->paginate($this->rowsPerPage);

    $deposits_temp = DB::select("select `deposits_temp`.*, `users`.`id` as `user_id`, `users`.`name` as `user_name`, `payment_methods`.`code` as `payment_method_code`, `acc_currencies`.`code` as `account_currency_code` from `deposits_temp` left join `accounts` on `deposits_temp`.`account_id` = `accounts`.`id` left join `users` on `accounts`.`user_id` = `users`.`id` left join `payment_methods` on `deposits_temp`.`payment_method_id` = `payment_methods`.`id` left join `currencies` as `acc_currencies` on `accounts` .`currency_id` = `acc_currencies`.`id` where deposits_temp.amount > 2 order by `created_at` desc ");


    return view('accounting::pages.backend.deposits.index', [
      'deposits' => $deposits,
      'deposits_temp' => $deposits_temp,
      'sort' => $sort->getSort(),
      'order' => $sort->getOrder(),]);
  }

  public function savetodeposit(Request $request) {
    $depositTemp = DB::select("select * from deposits_temp where id = '" . ($request->input('id')) . "'");
    if (isset($depositTemp[0]->id)) {
      $AccDetails = DB::table('accounts')->where('id', $depositTemp[0]->account_id)->first();
      $userDetails = DB::table('users')->where('id', $AccDetails->user_id)->first();
      $insertionData = json_decode(json_encode($depositTemp), TRUE);
      unset($insertionData[0]['id']);

      Deposit::insert($insertionData);
      DB::table('accounts')->where('id', $AccDetails->id)->update(['balance' => ($depositTemp[0]->payment_amount + $AccDetails->balance)]);


      DB::delete("delete from deposits_temp where id = '" . ($depositTemp[0]->id) . "'");
      DB::table('account_transactions')->insert([
        'account_id' => $depositTemp[0]->account_id,
        'type' => 1,
        'amount' => $depositTemp[0]->payment_amount,
        'balance' => ($depositTemp[0]->payment_amount + $AccDetails->balance),
        'transactionable_type' => 'Packages\Accounting\Models\Deposit',
        'transactionable_id' => 121,
        'created_at' => Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString(),
      ]);
      /*setting up the competition details */
      $competition = DB::select('SELECT * FROM competitions ORDER BY id DESC limit 1');
      $isAlready = DB::select("select * from competition_participants where user_id = " . ($AccDetails->user_id) . "");
      if (count($isAlready) == 0) {
        DB::table('competition_participants')->insert([
          'competition_id' => $competition[0]->id,
          'user_id' => $AccDetails->user_id,
          'start_balance' => '1.00',
          'current_balance' => $depositTemp[0]->payment_amount,
        ]);
      }

      return ['status' => 'success', 'msg' => 'transaction approved successfully'];
    } else {
      return ['status' => 'error', 'msg' => 'sorry there this transaction is already processed or does not exist any more  '];
    }
  }

  public function makeNewDeposit(Request $request) {

    $target_user_email = $request->input('user');
    // $userdetails = DB::table('users')->where('email', auth()->user()->email)->first();
    $userdetails = DB::table('users')->where('email', $target_user_email)->first();

    $firstDepsoit = false;
    if (is_numeric($userdetails->id)) {
      /*get account number from account table*/
      $AccDetails = DB::table('accounts')->where('user_id', $userdetails->id)->first();
      //var_dump($AccDetails);
      if ($AccDetails == null) {
        /*if there is a first time deposit */

        /*if there is no account details*/
        DB::table('accounts')->insert([
          'user_id' => $userdetails->id,
          'currency_id' => 3,
          'code' => $userdetails->id . '-' . substr(md5(time()), 0, 9),
          'balance' => $request->input('amount'),
          'status' => 0,
        ]);

        $AccDetails = DB::table('accounts')->where('user_id', $userdetails->id)->first();
        $firstDepsoit = true;
      }


      /*insert into deposits table*/
      $currencySelection = DB::table('payment_methods')->where('code', 'like', $request->input('currency'))->first();

      Deposit::insert([
        "account_id" => $AccDetails->id,
        "payment_method_id" => ((isset($currencySelection->id)) ? $currencySelection->id : 1),
        "payment_amount" => request()->input('amount'),
        "payment_currency_code" => "",
        "payment_fx_rate" => "0",
        "amount" => request()->input('amount'),
        "status" => "1",
        "external_id" => "",
        'created_at' => Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString(),
      ]);

      /*update balance int accounts  table*/
      DB::table('accounts')->where('id', $AccDetails->id)->update(['balance' => (request()->input('amount') + (($firstDepsoit) ? 0 : $AccDetails->balance))]);

      DB::table('account_transactions')->insert([
        'account_id' => $AccDetails->id,
        'type' => 1,
        'amount' => request()->input('amount'),
        'balance' => (request()->input('amount') + $AccDetails->balance),
        'transactionable_type' => 'Packages\Accounting\Models\Deposit',
        'transactionable_id' => 121,
        'created_at' => Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString(),
      ]);

      return redirect()->back();
    }
  }
}
