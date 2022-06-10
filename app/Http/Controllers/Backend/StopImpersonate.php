<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class Impersonate extends Controller {

  /**
   * Impersonate as a user
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */


  public function impersonate($id){
    $request = Crypt::decrypt($id);

    //$user = User::where('id', $request['id'])->first();

    session()->put('impersonate_by', auth()->id());

    \Auth::loginUsingId($request['id']);

    return redirect()->route('frontend.users.show', ['id' => $request['id']]);

  }
}
