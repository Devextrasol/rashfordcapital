<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole {
  /**
   * Handle an incoming request.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next, $role) {

    /*first of all if its a ajaz request bypass all ajax as admin */

    if($request->ajax()){
      /*allow all ajax requests */
      return $next($request);
    }else{
      if (in_array($role, ['ADMIN', 'FLOOR_MANAGER', 'SALES','USER'])) {
        /*limiting user roles to see only desired pages*/
        $cRole = auth()->user()->role;
        if (in_array($cRole, ['FLOOR_MANAGER', 'SALES'])) {
          /*limit the routes to see*/
          $requestUrl = request()->fullUrl();
          if(strpos($requestUrl,'admin/license') !== false) return redirect()->back();
          if ($cRole == 'FLOOR_MANAGER') {
            $status = array_map(function ($v) use ($requestUrl) {
              return (strpos($requestUrl, $v) !== false) ? '1' : '0';
            }, [
              'admin?dashboard',
              'admin/imperstop',
              'admin/impersonate',
              'deposits',
              'withdrawals',
              'leads',
              'trades',
              'atsleads',
            ]);
            if (!in_array('1', $status)) return response(['sorry you are not allowed to view this page']);

          } elseif ($cRole == 'SALES') {
            /*else sales*/
            $status = array_map(function ($v) use ($requestUrl) {
              return (strpos($requestUrl, $v) !== false) ? '1' : '0';
            }, [
              'admin?dashboard',
              'admin/imperstop',
              'admin/impersonate',
              'trades',
              'leads',
              'deposits',
              'atsleads',
            ]);

            if (!in_array('1', $status)) return response(['sorry you are not allowed to view this page']);
          } elseif ($cRole == 'USER') {
            /*else sales*/
            $status = array_map(function ($v) use ($requestUrl) {
              return (strpos($requestUrl, $v) !== false) ? '1' : '0';
            }, [
              'leads'
            ]);
            if (!in_array('1', $status)) return response(['sorry you are not allowed to view this page']);
          }
          return $next($request);
        } else {
          return $next($request);
        }
      } else {/*!$request->user()->hasRole($role)*/
        return redirect()->route('frontend.index');
      }
    }

    /*return $next($request);*/
  }
}
