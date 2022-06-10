@extends('layouts.backend')

@section('title')
  {{ __('app.dashboard') }}
@endsection

@section('content')
  <?php
  /*if its only an admin then can update account details*/
  if(auth()->user()->role == 'ADMIN'){

  ?>
  <div class="ui equal width stackable grid container">
    <div class="row">
      <div class="left aligned column">

        <form class="ui form" method="post" action="{{ url('admin/update-accounts') }}">
          @csrf
          <div class="field">
            <label>BTC</label>
            <input type="text" name="BTC" placeholder="BTC  account number" required value="{{ \Illuminate\Support\Facades\DB::table('deposit_accounts')->where('name' , 'BTC')->get()[0]->number }}">
          </div>
          <div class="field">
            <label>ETH</label>
            <input type="text" name="ETH" placeholder="ETH  account number" required value="{{ \Illuminate\Support\Facades\DB::table('deposit_accounts')->where('name' , 'ETH')->get()[0]->number }}">
          </div>
          <div class="field">
            <label>LTC</label>
            <input type="text" name="LTC" placeholder="LTC  account number" required value="{{ \Illuminate\Support\Facades\DB::table('deposit_accounts')->where('name' , 'LTC')->get()[0]->number }}">
          </div>
          <button class="ui button" type="submit">Update</button>
        </form>
      </div>
    </div>
  </div>
  <?php  } ?>
  <div class="ui equal width stackable grid container">
    <div class="row">
      <div class="center aligned column">
        <div class="ui {{ $inverted }} segment">
          <div class="ui {{ $inverted }} statistic">
            <div class="value">
              {{ $users_count }}
            </div>
            <div class="label">
              {{ __('users.users') }}
            </div>
          </div>
        </div>
      </div>
      <div class="center aligned column">
        <div class="ui {{ $inverted }} segment">
          <div class="ui {{ $inverted }} green statistic">
            <div class="value">
              {{ $active_users_count }}
            </div>
            <div class="label">
              {{ __('users.status_' . \App\Models\User::STATUS_ACTIVE) }}
            </div>
          </div>
        </div>
      </div>
      <div class="center aligned column">
        <div class="ui {{ $inverted }} segment">
          <div class="ui {{ $inverted }} red statistic">
            <div class="value">
              {{ $blocked_users_count }}
            </div>
            <div class="label">
              {{ __('users.status_' . \App\Models\User::STATUS_BLOCKED) }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="center aligned column">
        <div class="ui {{ $inverted }} segment">
          <div class="ui {{ $inverted }} statistic">
            <div class="value">
              {{ $competitions_count }}
            </div>
            <div class="label">
              {{ __('app.competitions') }}
            </div>
          </div>
        </div>
      </div>
      <div class="center aligned column">
        <div class="ui {{ $inverted }} segment">
          <div class="ui {{ $inverted }} green statistic">
            <div class="value">
              {{ $open_competitions_count }}
            </div>
            <div class="label">
              {{ __('app.competition_status_' . \App\Models\Competition::STATUS_OPEN) }}
              /
              {{ __('app.competition_status_' . \App\Models\Competition::STATUS_IN_PROGRESS) }}
            </div>
          </div>
        </div>
      </div>
      <div class="center aligned column">
        <div class="ui {{ $inverted }} segment">
          <div class="ui {{ $inverted }} red statistic">
            <div class="value">
              {{ $closed_competitions_count }}
            </div>
            <div class="label">
              {{ __('app.competition_status_' . \App\Models\Competition::STATUS_COMPLETED) }}
              /
              {{ __('app.competition_status_' . \App\Models\Competition::STATUS_CANCELLED) }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="center aligned column">
        <div class="ui {{ $inverted }} segment">
          <div class="ui {{ $inverted }} statistic">
            <div class="value">
              {{ $trades_count }}
            </div>
            <div class="label">
              {{ __('app.closed_trades') }}
            </div>
          </div>
        </div>
      </div>
      <div class="center aligned column">
        <div class="ui {{ $inverted }} segment">
          <div class="ui {{ $inverted }} green statistic">
            <div class="value">
              {{ $profitable_trades_count }}
            </div>
            <div class="label">
              {{ __('app.profitable_trades') }}
            </div>
          </div>
        </div>
      </div>
      <div class="center aligned column">
        <div class="ui {{ $inverted }} segment">
          <div class="ui {{ $inverted }} red statistic">
            <div class="value">
              {{ $unprofitable_trades_count }}
            </div>
            <div class="label">
              {{ __('app.unprofitable_trades') }}
            </div>
          </div>
        </div>
      </div>
    </div>

    @packageview('pages.backend.dashboard')
  </div>
@endsection
