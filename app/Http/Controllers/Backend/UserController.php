<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UpdateUser;
use App\Models\Sort\Backend\UserSort;
use App\Models\User;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use GuzzleHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\Flash;
use Packages\Accounting\Models\Deposit;

class UserController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @param User $user
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function index(Request $request, User $user) {
    $sort = new UserSort($request);

    $users = User::orderBy($sort->getSortColumn(), $sort->getOrder())->with('profiles')->paginate($this->rowsPerPage);

    return view('pages.backend.users.index', [
      'users' => $users,
      'sort' => $sort->getSort(),
      'order' => $sort->getOrder(),
    ]);
  }

  /**
   * Display a listing of the resource for CRM.
   *
   * @param Request $request
   * @param User $user
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function leads(Request $request, User $user) {
    if (is_int(session()->get('impersonate_by'))) die(header('Location: ' . url('users/' . auth()->user()->id)));
    $authRole = strtoupper(auth()->user()->role);
    switch ($authRole) {
      case 'USER':
        $skiped = [
          '1',/*admin*/
          '2',/*user*/
          '3',/*sales*/
          '4',/*floor*/
        ];
        $users = User::where('u_status', 'make_lead')->orWhereNull('u_status')->orderBy('id' , 'DESC')->paginate(100);
        break;
      case 'SALES':
        $skiped = [
          '1',/*admin*/
          //'2',/*user*/
          '3',/*sales*/
          '4',/*floor*/
        ];
        $users = User::where('sales_id', auth()->user()->id)->where(function ($q) {
          $q->where('u_status', 'organic')->orWhere('u_status', 'make_lead');
        })->orderBy('id' , 'DESC')->paginate(100);
        break;
      case 'FLOOR_MANAGER':
        $skiped = [
          '1',/*admin*/
//        '2',/*user*/
//        '3',/*sales*/
          '4',/*floor*/
        ];
        $users = User::where('u_status', 'make_lead')->orWhereNull('u_status')->orderBy('id' , 'DESC')->paginate(100);
        break;
      case 'ADMIN':
        $skiped = [
//          '1',/*admin*/
//          '2',/*user*/
//          '3',/*sales*/
//          '4',/*floor*/
        ];
        $users = User::where('u_status', 'make_lead')->orWhere('u_status', 'organic')->orderBy('id' , 'DESC')->paginate(100);
        break;
    }
//    $users = User::where('u_status', 'make_lead')->orWhereNull('u_status')->get();
    return view('pages.backend.users.leads', [
      'users' => $users,
    ]);
  }

  public function atsleads(Request $request, User $user) {
    if (is_int(session()->get('impersonate_by'))) die(header('Location: ' . url('users/' . auth()->user()->id)));
    $authRole = strtoupper(auth()->user()->role);
    switch ($authRole) {
      case 'USER':
        $skiped = [
          '1',/*admin*/
          '2',/*user*/
          '3',/*sales*/
          '4',/*floor*/
        ];
        $users = User::where('u_status', '!=', 'make_lead')->whereNotIn('role', $skiped)->orderBy('id' , 'DESC')->paginate(100);
        break;
      case 'SALES':
        $skiped = [
          '1',/*admin*/
          //'2',/*user*/
          '3',/*sales*/
          '4',/*floor*/
        ];
        $users = User::where('u_status', '!=', 'make_lead')->where('sales_id', auth()->user()->id)->whereNotIn('role', $skiped)->orderBy('id' , 'DESC')->paginate(100);
        break;
      case 'FLOOR_MANAGER':
        $skiped = [
          '1',/*admin*/
//        '2',/*user*/
//        '3',/*sales*/
          '4',/*floor*/
        ];
        $users = User::where('u_status', '!=', 'make_lead')->whereNotIn('role', $skiped)->orderBy('id' , 'DESC')->paginate(100);
        break;
      case 'ADMIN':
        $skiped = [
//          '1',/*admin*/
//          '2',/*user*/
//          '3',/*sales*/
//          '4',/*floor*/
        ];
        $users = User::where('u_status', '!=', 'make_lead')->whereNotIn('role', $skiped)->orderBy('id' , 'DESC')->paginate(100);
        break;
    }

    return view('pages.backend.users.atsleads', [
      'users' => $users,
    ]);
  }

  public function updateSessionAutorefresh(){
    return response()->json([Session::put('autoreffresh' , request()->input('isValue')) ,request()->input('isValue') ]);
  }

  public function update_status() {

    /*check if there is a data filter for bulk assign */
    if (request()->has('data')) {
      foreach (request()->input('data') as $r) {
        //self::update_statuswithPost($r);
      }
      return response()->json(['status' => 'success']);
    } else {
      $userDetails = User::find(['id' => request()->input('id')])->first();
      if (trim(request()->input('status')) == 'make_lead') {
        /*  insert role and if the password is empty then its user first time of deposit */
        self::postStatus($userDetails->id);
        DB::update("UPDATE `users` SET `u_status`='make_lead' where id = " . $userDetails->id);
        $res = self::makeNewDepositForUser($userDetails->email);
        dd($res);
        return ["success" => 1];
      } else {
        DB::update("UPDATE `users` SET `u_status`='" . (request()->input('status')) . "' where id = " . $userDetails->id);
        $req_status = request()->status;
//      $user = Sentinel::findById(request()->id);
//      $status = self::postStatus($user->id);
//      $useru = Sentinel::update($user, ['u_status' => $req_status]);
        /*insert user account profile data*/

        return ["success" => 1];
      }
    }
  }

  public function updateComment(Request $request) {
    return response()->json(User::where('id', $request->input('id'))->update([$request->input('col') => $request->input('val')]));
  }
  public function updateDepositComment(Request $request) {
    return response()->json(DB::table('deposits')->where('id' , $request->input('id'))->update(['comment' => $request->input('comment')]));
  }

  public function makeNewDepositForUser($email) {
    $amount = 1;
    $currency = 'BTC';
    $target_user_email = $email;
    $userDetails = DB::table('users')->where('email', $target_user_email)->first();

    $firstDeposit = false;
    if (is_numeric($userDetails->id)) {
      /*get account number from account table*/
      $AccDetails = DB::table('accounts')->where('user_id', $userDetails->id)->first();
      //var_dump($AccDetails);
      if ($AccDetails == null) {
        /*if there is a first time deposit */

        /*if there is no account details*/
        DB::table('accounts')->insert([
          'user_id' => $userDetails->id,
          'currency_id' => 3,
          'code' => $userDetails->id . '-' . substr(md5(time()), 0, 9),
          'balance' => $amount,
          'status' => 0,
        ]);

        $AccDetails = DB::table('accounts')->where('user_id', $userDetails->id)->first();
        $firstDeposit = true;
      }


      /*insert into deposits table*/
      $currencySelection = DB::table('payment_methods')->where('code', 'like', $currency)->first();

      Deposit::insert([
        "account_id" => $AccDetails->id,
        "payment_method_id" => ((isset($currencySelection->id)) ? $currencySelection->id : 1),
        "payment_amount" => $amount,
        "payment_currency_code" => "",
        "payment_fx_rate" => "0",
        "amount" => $amount,
        "status" => "1",
        "external_id" => "",
        'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString(),
      ]);

      /*update balance int accounts  table*/
      DB::table('accounts')->where('id', $AccDetails->id)->update(['balance' => ($amount + (($firstDeposit) ? 0 : $AccDetails->balance))]);

      DB::table('account_transactions')->insert([
        'account_id' => $AccDetails->id,
        'type' => 1,
        'amount' => $amount,
        'balance' => ($amount + $AccDetails->balance),
        'transactionable_type' => 'Packages\Accounting\Models\Deposit',
        'transactionable_id' => 121,
        'created_at' => Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString(),
      ]);
      return true;
    }
  }


  /**
   * Display the specified resource.
   *
   * @param \App\Models\User $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user) {
//        return view('pages.backend.users.show', ['user' => $user]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param \App\Models\User $user
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user) {
    return view('pages.backend.users.edit', ['user' => $user]);
  }

  /**
   * Fast Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function fast_update(Request $request) {

    if ($request->type == 'crm_status') {

      $user = User::find(['id' => $request->users])->first();
      $user->crm_status = $request->crm_status;
      $user->save();

    } elseif ($request->type == 'bulk') {

      if (isset($request->sales_id) && isset($request->crm_status)) {
        DB::table('users')->whereIn('id', $request->users)->update(['sales_id' => $request->sales_id, 'crm_status' => $request->crm_status]);
      } elseif (isset($request->sales_id)) {
        DB::table('users')->whereIn('id', $request->users)->update(['sales_id' => $request->sales_id]);
      } elseif (isset($request->crm_status)) {
        DB::table('users')->whereIn('id', $request->users)->update(['crm_status' => $request->crm_status]);
      }

    }

    return response()->json(['status' => 'success']);
  }

  public function ats_fast_update(Request $request) {

    if ($request->type == 'crm_status') {

      $user = User::find(['id' => $request->users])->first();
      $user->crm_status = $request->crm_status;
      $user->save();

    } elseif ($request->type == 'bulk') {

      if (isset($request->sales_id) && isset($request->crm_status)) {
        DB::table('users')->whereIn('id', $request->users)->update(['sales_id' => $request->sales_id, 'u_status' => $request->crm_status]);
      } elseif (isset($request->sales_id)) {
        DB::table('users')->whereIn('id', $request->users)->update(['sales_id' => $request->sales_id]);
      } elseif (isset($request->crm_status)) {
        DB::table('users')->whereIn('id', $request->users)->update(['u_status' => $request->crm_status]);
      }

    }

    return response()->json(['status' => 'success']);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\User $user
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateUser $request, User $user) {

    // validator passed, update fields
    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;
    $user->status = $request->status;
    $rolStatus = [
      'ADMIN' => '1',
      'USER' => '2',
      'SALES' => '3',
      'FLOOR_MANAGER' => '4',
    ];
    $roleAssigned = $rolStatus[$request->role];
    // avatar is uploaded or updated
    if ($request->hasFile('avatar')) {
      $avatar = $request->file('avatar');
      $avatarFileName = $user->id . '_' . time() . '.' . $avatar->getClientOriginalExtension();
      // resize image to 300px max height
      $avatarContents = (string)Image::make($avatar)
        ->resize(null, config('settings.user_avatar_height'), function ($constraint) {
          $constraint->aspectRatio();
        })
        ->encode();

      // store avatar
      if (Storage::put('avatars/' . $avatarFileName, $avatarContents)) {
        // delete previous avatar
        if ($user->avatar)
          Storage::delete('avatars/' . $user->avatar);
        // set uploaded avatar
        $user->avatar = $avatarFileName;
      }
      // avatar is deleted
    } else if ($user->avatar) {
      Storage::delete('avatars/' . $user->avatar);
      $user->avatar = NULL;
    }

    // update password if it was filled in
    if ($request->password) {
      $user->password = bcrypt($request->password);
    }

    $user->save();
    /*if all validations checked then update user status in roles_users table*/
    DB::table('role_users')->where('user_id', $user->id)->delete();
    /*insert new record*/
    DB::table('role_users')->insert(['user_id' => $user->id, 'role_id' => $roleAssigned]);
    return redirect()->route('backend.users.index')->with('success', __('users.saved', ['name' => $user->name]));
  }

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

//        $res = $client->request('POST', 'https://go.click4ads.net/affiliatetsapi?' . http_build_query($dataCreate), $dataCreate);
        /*update user status*/
//        if ($res->getStatusCode() == 200) {
          $dataUpdate = [
            'action' => 'update_customer',
            'apiToken' => $token,
            'merchant_id' => $merchantId,
            'saleStatus' => (request()->input('status') == null) ? 'new' : request()->input('status'),
            'trader_id' => $user->id,
          ];
//          $res = $client->request('POST', 'https://go.click4ads.net/affiliatetsapi?' . http_build_query($dataUpdate), $dataUpdate);
//        }

//        if ($res->getStatusCode() != 200) break;
      }
    };
//    return ($res->getStatusCode() == 200) ? (['status' => 'success', 'body' => $res->getBody()]) : ['status' => 'error', 'body' => $res->getBody()];
    return ['status' => 'success', 'body' => ['success']];
  }


  /**
   * Display a page to confirm deleting a user
   *
   * @param \App\Models\User $user
   */
  public function delete(Request $request, User $user) {
    // check that the user being deleted is not current
    if ($request->user()->id == $user->id) {
      return redirect()
        ->back()
        ->withErrors(['user' => __('users.error_delete_self')]);
    }

    $request->session()->flash('warning', __('users.delete_warning'));
    return view('pages.backend.users.delete', ['user' => $user]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\User $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, User $user) {
    // check that the user being deleted is not current
    if ($request->user()->id == $user->id) {
      return redirect()
        ->back()
        ->withErrors(['user' => __('users.error_delete_self')]);
    }

    $userName = $user->name;

    // delete avatar
    if ($user->avatar)
      Storage::delete('avatars/' . $user->avatar);

    // delete user
    $user->delete();

    return redirect()
      ->route('backend.users.index')
      ->with('success', __('users.deleted', ['name' => $userName]));
  }

  /**
   * Generate users (bots)
   *
   * @param Request $request
   * @return $this|\Illuminate\Http\RedirectResponse
   */
  public function generate(Request $request) {
    try {
      Artisan::call('generate:users', [
        'count' => $request->count
      ]);
    } catch (\Exception $e) {
      return back()->withInput()->withErrors($e->getMessage());
    }

    return redirect()
      ->route('backend.users.index')
      ->with('success', __('users.bots_generated', ['n' => $request->count]));
  }

  public function getpaymentStatus(Request $request) {

    $roleId = DB::select("select * from role_users where user_id = '" . (auth()->user()->id) . "'");

    if (isset($roleId[0]->role_id) && in_array($roleId[0]->role_id, [1, 4])) {
      $today = Carbon::today()->format('Y-m-d');

      $deposit = DB::select("select count(id) as c from deposits where created_at like '%" . ($today) . "%' ");/*2019-03-07*/
      $withdraw = DB::select("select count(id) as c from withdrawals where created_at like '%" . ($today) . "%' ");
      $newUser = DB::select("select count(id) as c from users where password<>'' and created_at like '%" . ($today) . "%' ");
      $hotleads = DB::select("select count(id) as c from users where password = '' and created_at like '%" . ($today) . "%' ");

      $newLogins = DB::select("select users.name , log.created_at from log , users  where log.user_id = users.id   and  log.created_at > '" . (Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s')) . "' ");

      /*new logins logics */
      $newLoginsPusher = [];
      foreach ($newLogins as $r) {
        $newLoginsPusher[] = "user " . $r->name . ' logged in at ' . $r->created_at;
      }

      return response()->json([

        'deposit' => (isset($deposit[0]->c) && $deposit[0]->c > 0) ? 'you have ' . $deposit[0]->c . ' new deposits today ' : '',
        'withdraw' => (isset($withdraw[0]->c) && $withdraw[0]->c > 0) ? 'you have ' . $withdraw[0]->c . ' new withdraw\'s requests today ' : '',
        'newUser' => (isset($newUser[0]->c) && $newUser[0]->c > 0) ? 'you have ' . $newUser[0]->c . ' new users signed up today' : '',
        'hotleads' => (isset($hotleads[0]->c) && $hotleads[0]->c > 0) ? ('<span style="display: none">' . $hotleads[0]->c . '</span>Hot Lead sign up') : '',
        'newLogins' => ((count($newLogins) > 0) ? $newLoginsPusher : []),

      ]);
    } else {
      $today = Carbon::today()->format('Y-m-d');

      $newLogins = DB::select("select users.name , log.created_at from log , users  where log.user_id = users.id   and  log.created_at > '" . (Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s')) . "' ");

      $deposit = DB::select("select count(id) as c from deposits where created_at like '%" . ($today) . "%' ");/*2019-03-07*/
      $withdraw = DB::select("select count(id) as c from withdrawals where created_at like '%" . ($today) . "%' ");

      /*new logins logics */
      $newLoginsPusher = [];
      foreach ($newLogins as $r) {
        $newLoginsPusher[] = "user " . $r->name . ' logged in at ' . $r->created_at;
      }

      return response()->json([

        'deposit' => (isset($deposit[0]->c) && $deposit[0]->c > 0) ? 'you have ' . $deposit[0]->c . ' new deposits today ' : '',
        'withdraw' => (isset($withdraw[0]->c) && $withdraw[0]->c > 0) ? 'you have ' . $withdraw[0]->c . ' new withdraw\'s requests today ' : '',
        'newLogins' => ((count($newLogins) > 0) ? $newLoginsPusher : []),

      ]);
    }
  }


  public function pendingLeads(Request $request) {
    $leadsCount = DB::select("select count(id) as c from sales_users where sales_id = " . auth()->user()->id . " and is_seen = '0' ");
    DB::update("UPDATE `sales_users` SET `is_seen`= '1' where sales_id =  " . auth()->user()->id);
    if (isset($leadsCount[0]->c) && ($leadsCount[0]->c) > 0) {
      return (['msg' => "you have been assigned with " . ($leadsCount[0]->c) . " new leads "]);
    } else {
      return (['msg' => ""]);
    }
  }

}
