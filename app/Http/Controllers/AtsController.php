<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Packages\Accounting\Models\Deposit;
use Validator;

class AtsController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    return 'Ats lead Controller';
  }

  public function createLead(Request $request) {
    file_put_contents('appendData.txt', json_encode($request->all()), LOCK_EX);
    /*Fields 	Type
      {
        "_token":"1222EC93B7282A118D1426493E8AB759",
        "first_name":"test",
        "last_name":"test",
        "email":"Herschel_test@mail.ru",
        "password":"1234567Aa",
        "phone":"4930120219",
        "status":"real",
        "country":"DE",
        "btag":"soTest"
      }
    */

    $rules = [

      'email' => 'required|unique:users|max:200',
      'phone' => 'required|max:20',
      'first_name' => 'max:200',
      'last_name' => 'max:200',
      'status' => 'max:12',
      'country' => 'required|max:100',
      'btag' => 'required|max:100'

    ];

    $validator = Validator::make($request->all(), $rules);
    if ($request->input('_token') != '1222EC93B7282A118D1426493E8AB759') {
      return ['msg' => 'sorry invalid token is provided'];
    }

    if (!$validator->fails()) {
      $request->request->add([
        'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
        'ats_data' => json_encode($request->all()),
        'role' => 'USER',
        'password' => bcrypt($request->input('password')),
        'country' => $request->input('country'),
        'u_status' => 'new',
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
      ]);

      DB::table('users')->insert($request->only([
        'email',
        'phone',
        'name',
        'status',
        'ats_data',
        'role',
        'password',
        'last_name',
        'country',
        'updated_at'
      ]));
      $lastId = DB::getPdo()->lastInsertId();
      $userStatatus = User::select('u_status')->findOrFail($lastId)->u_status;


      /*
       * at this stage we need to create user account
       */
      $target_user_email = $request->input('email');
      // $userdetails = DB::table('users')->where('email', auth()->user()->email)->first();
      $userdetails = DB::table('users')->where('email', $target_user_email)->first();
      $userFirstTimeDeposit = 1;
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
            'balance' => $userFirstTimeDeposit,
            'status' => 0,
          ]);

          $AccDetails = DB::table('accounts')->where('user_id', $userdetails->id)->first();
          $firstDepsoit = true;
        }


        /*insert into deposits table*/
        $currencySelection = DB::table('payment_methods')->where('code', 'like', 'BTC')->first();

        Deposit::insert([
          "account_id" => $AccDetails->id,
          "payment_method_id" => ((isset($currencySelection->id)) ? $currencySelection->id : 1),
          "payment_amount" => $userFirstTimeDeposit,
          "payment_currency_code" => "",
          "payment_fx_rate" => "0",
          "amount" => $userFirstTimeDeposit,
          "status" => "1",
          "external_id" => "",
          'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        /*update balance int accounts  table*/
        DB::table('accounts')->where('id', $AccDetails->id)->update([
          'balance' => (
            $userFirstTimeDeposit + (($firstDepsoit) ? 0 : $AccDetails->balance)
          )]);

        DB::table('account_transactions')->insert([
          'account_id' => $AccDetails->id,
          'type' => 1,
          'amount' => $userFirstTimeDeposit,
          'balance' => ($userFirstTimeDeposit + $AccDetails->balance),
          'transactionable_type' => 'Packages\Accounting\Models\Deposit',
          'transactionable_id' => 121,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
        ]);


        /*if there is a new lead then we will set as new as u_status in DB*/
        return ([

          'msg' => 'success',
          'trader_id' => $lastId,
          'status' => ((empty($userStatatus)) ? 'new' : (($userStatatus == 'organic') ? 'new' : $userStatatus)),
          'url' => str_replace('{{id}}', encrypt($lastId), url('ats/auto/login/{{id}}')),

        ]);
      } else {
        return (['msg' => 'error', 'data' => $validator->messages(), 'status' => 'false']);
      }
    }
  }

  public function update(Request $request) {
    file_put_contents('appendData-status.txt', json_encode($request->all()), LOCK_EX);
    if ($request->input('api_key') != '1222EC93B7282A118D1426493E8AB759') {
      return ['msg' => 'sorry invalid token is provided'];
    } else {

      $userStatatus = DB::select("select u_status as status  , id as trader_id , email from users where u_status <> '' ");
      if (($userStatatus)) {


        $leads = array_map(function ($v) {
          return [
            'trader_id' => $v->trader_id,
            'email' => $v->email,
            'type' => 'lead',
            'status' => (($v->status == 'organic') ? 'new' : (($v->status == 'make_lead') ? 'deposited' : $v->status)),
          ];
        }, $userStatatus);
        return $leads;
      } else {
        return ([
          'msg' => 'sorry trader id does not match any record',
          'status' => 'error',
        ]);
      }

    }
  }

  public function statuspost(Request $request) {
    file_put_contents('appendData.txt', json_encode($request->all()), FILE_APPEND | LOCK_EX);
  }

  /*other controller udate methods */

  public function postStatus($id) {
    $users = User::where(['id' => $id])->get();
    $client = new GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/x-www-form-urlencoded']]);
    $token = 'bbd68e8c0f9';
    $merchantId = 1;

    if (count($users) > 0) {
      foreach ($users as $user) {
        /*creating a new user*/
        $dataCreate = [
          'action' => 'add_customer',
          'apiToken' => $token,
          'merchant_id' => $merchantId,
          'saleStatus' => (request()->input('status') == null) ? 'new' : request()->input('status'),
          'trader_id' => $user->id,
        ];

        $res = $client->request('POST', 'https://go.click4ads.net/affiliatetsapi?' . http_build_query($dataCreate), $dataCreate);
        /*update user status*/
        if ($res->getStatusCode() == 200) {
          $dataUpdate = [
            'action' => 'update_customer',
            'apiToken' => $token,
            'merchant_id' => $merchantId,
            'saleStatus' => (request()->input('status') == null) ? 'new' : request()->input('status'),
            'trader_id' => $user->id,
          ];
          $res = $client->request('POST', 'https://go.click4ads.net/affiliatetsapi?' . http_build_query($dataUpdate), $dataUpdate);
        }

        if ($res->getStatusCode() != 200) break;
      }
    };
    return ($res->getStatusCode() == 200) ? (['status' => 'success', 'body' => $res->getBody()]) : ['status' => 'error', 'body' => $res->getBody()];
  }


}
