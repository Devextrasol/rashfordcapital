<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class Impersonate extends Controller {

  /**
   * Impersonate as a user
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */


  public function impersonate($id) {
    $request = Crypt::decrypt($id);

    //$user = User::where('id', $request['id'])->first();

    session()->put('impersonate_by', auth()->id());

    \Auth::loginUsingId($request['id']);

    return redirect()->route('frontend.users.show', ['id' => $request['id']]);

  }

  public function stop() {

    \Auth::loginUsingId(session('impersonate_by'));

    session()->forget('impersonate_by');

    return redirect('/admin/leads');
  }

  public function autologinAts($id) {
    $userId = decrypt($id);
    $userDetails = User::find($userId)->toArray();
    if (is_numeric($userId) && count($userDetails) > 0) {
      \Auth::loginUsingId($userId);
      return redirect()->to(url('users/' . $userId . '/account'));
    } else {
      dd('Sorry this URL is no longer valid');
    }
  }

}
