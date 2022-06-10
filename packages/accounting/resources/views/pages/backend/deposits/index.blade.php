@extends('layouts.backend')

@section('title')
  {{ __('accounting::text.deposits') }}
@endsection

@section('content')
  <?php
  $role = auth()->user()->role;
  $roleAllowed = ['ADMIN', 'FLOOR_MANAGER'];

  ?>
  <div class="ui one column tablet stackable grid container">

    <button style=" margin-left: 17px;border: 1px solid #569211; padding: 7px 10px; border-radius: 3px; color: white; background-color: #8BC34A;" class="btn btn-xs btn-success custombtn open-model">New deposit</button>
    <div class="ui basic modal">
      <div class="ui icon header ">
        <i class="archive icon"></i>
        New Deposit
      </div>
      <div class="content">
        <form class="ui form modalcustom" action="{{ url('admin/deposits/newdeposit') }}" method="post">
          @csrf
          <div class="field">
            <div class="two fields">
              <div class="field">
                <label>Amount</label>
                <input type="number" name="amount" placeholder="amount">
              </div>
              <div class="field">
                <label>Currency</label>
                <select class="ui fluid dropdown" name="currency">
                  <?php
                  $paymentMethodCurrencies = DB::select("select  * from currencies where code like 'BTC' OR code like 'eth' OR code like 'ltc'");
                  if (is_array($paymentMethodCurrencies) && count($paymentMethodCurrencies) > 0) {
                    foreach ($paymentMethodCurrencies as $r) {
                      echo "<option value='$r->code'>$r->code</option>";
                    }
                  } ?>
                </select>
              </div>
            </div>
            <div class="two fields">
              <div class="field">
                <label>User</label>
                <select class="ui fluid select2" name="user"  >
                  <?php
                  $users = DB::select("select  * from users ");
                  if (is_array($users) && count($users) > 0) {
                    foreach ($users as $r) {
                      echo "<option value='$r->email'>$r->email</option>";
                    }
                  } ?>
                </select>
              </div>
              <div class="field">

              </div>
            </div>
          </div>

          <button class="ui button" type="submit" tabindex="0">Deposit</button>
        </form>


      </div>
      <?php if(in_array($role, $roleAllowed)){ ?>
      <div class="actions">
        <div class="ui red basic cancel inverted button">
          <i class="remove icon"></i>
          Close
        </div>

      </div>
      <?php } ?>
    </div>
    <?php if(in_array($role, $roleAllowed)){ ?>
    <div class="column">
      @if($deposits->isEmpty())
        <div class="ui segment">
          <p>{{ __('accounting::text.deposits_empty2') }}</p>
        </div>
      @else
        <table class="ui selectable tablet stackable {{ $inverted }} table">
          <thead>
          <tr>
            @component('components.tables.sortable-column', ['id' => 'user', 'sort' => $sort, 'order' => $order])
              {{ __('accounting::text.user') }}
            @endcomponent
            @component('components.tables.sortable-column', ['id' => 'payment_method', 'sort' => $sort, 'order' => $order])
              {{ __('accounting::text.payment_method') }}
            @endcomponent
            @component('components.tables.sortable-column', ['id' => 'payment_id', 'sort' => $sort, 'order' => $order])
              {{ __('accounting::text.payment_id') }}
            @endcomponent
            @component('components.tables.sortable-column', ['id' => 'status', 'sort' => $sort, 'order' => $order])
              {{ __('accounting::text.status') }}
            @endcomponent
            @component('components.tables.sortable-column', ['id' => 'amount', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
              {{ __('accounting::text.amount') }}
            @endcomponent
            @component('components.tables.sortable-column', ['id' => 'comment', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
              comment
            @endcomponent
            @component('components.tables.sortable-column', ['id' => 'created', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
              {{ __('accounting::text.created') }}
            @endcomponent
            @component('components.tables.sortable-column', ['id' => 'updated', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
              {{ __('accounting::text.updated') }}
            @endcomponent
          </tr>
          </thead>
          <tbody>
          @foreach ($deposits as $deposit)
            <tr>
              <td data-title="{{ __('accounting::text.user') }}">
                <a href="{{ route('backend.users.edit', [$deposit->user_id]) }}">
                  {{ $deposit->user_name }}
                </a>
              </td>
              <td data-title="{{ __('accounting::text.payment_method') }}">{{ __('accounting::text.method_' . $deposit->payment_method_id) }}</td>
              <td data-title="{{ __('accounting::text.payment_id') }}">{{ $deposit->external_id }}</td>
              <td data-title="{{ __('accounting::text.status') }}"
                  class="{{ $deposit->status == Packages\Accounting\Models\Deposit::STATUS_COMPLETED ? 'positive' : ($deposit->status == Packages\Accounting\Models\Deposit::STATUS_CANCELLED ? 'negative' : '') }}">{{ __('accounting::text.deposit_status_' . $deposit->status) }}</td>
              <td data-title="{{ __('accounting::text.amount') }}" class="right aligned">

                @if($deposit->account_currency_code != $deposit->payment_currency_code)
                  <span
                      data-tooltip="{{ __('accounting::text.deposit_amount_tooltip', ['amount' => $deposit->_payment_amount, 'ccy' => $deposit->payment_currency_code, 'ccy1' => $deposit->account_currency_code, 'ccy2' => $deposit->payment_currency_code, 'x' => $deposit->payment_fx_rate]) }}">
                                        <i class="calculator tooltip icon"></i>
                                    </span>
                @endif
                {{ $deposit->_amount }} {{ $deposit->account_currency_code }}
              </td>
              <td>
                <button class="ui olive basic button" type="button" onclick="return showComment('{{ $deposit->id }}' , '{{ base64_encode($deposit->comment) }}' )"><i class="comment icon"></i>
                </button>
              </td>
              <td data-title="{{ __('accounting::text.created') }}" class="right aligned">
                {{--{{ $deposit->created_at->diffForHumans() }}--}}
                <span data-tooltip="{{ $deposit->created_at }}">
                                    <i class="calendar outline tooltip icon"></i>
                                </span>
              </td>
              <td data-title="{{ __('accounting::text.updated') }}" class="right aligned">
                {{--                                {{ $deposit->updated_at->diffForHumans() }}--}}
                <span data-tooltip="{{ $deposit->updated_at }}">
                                    <i class="calendar outline tooltip icon"></i>
                                </span>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      @endif
    </div>
    <?php if(isset($deposits_temp) && count($deposits_temp) > 0 ){ ?>
    <div class="column">
      <h2>Pending Payments</h2>
      <table class="ui selectable tablet stackable {{ $inverted }} table">
        <thead>
        <tr>
          @component('components.tables.sortable-column', ['id' => 'user', 'sort' => $sort, 'order' => $order])
            {{ __('accounting::text.user') }}
          @endcomponent
          @component('components.tables.sortable-column', ['id' => 'payment_method', 'sort' => $sort, 'order' => $order])
            {{ __('accounting::text.payment_method') }}
          @endcomponent
          @component('components.tables.sortable-column', ['id' => 'payment_id', 'sort' => $sort, 'order' => $order])
            {{ __('accounting::text.payment_id') }}
          @endcomponent
          @component('components.tables.sortable-column', ['id' => 'status', 'sort' => $sort, 'order' => $order])
            {{ __('accounting::text.status') }}
          @endcomponent
          @component('components.tables.sortable-column', ['id' => 'amount', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
            {{ __('accounting::text.amount') }}
          @endcomponent
          @component('components.tables.sortable-column', ['id' => 'created', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
            {{ __('accounting::text.created') }}
          @endcomponent
          @component('components.tables.sortable-column', ['id' => 'updated', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
            Status
          @endcomponent
        </tr>
        </thead>
        <tbody>
        @foreach ($deposits_temp as $deposit)
          <tr>
            <td data-title="{{ __('accounting::text.user') }}">
              <a href="{{ route('backend.users.edit', [$deposit->user_id]) }}">
                {{ $deposit->user_name }}
              </a>
            </td>
            <td data-title=""><?php $methodName = \Illuminate\Support\Facades\DB::table('payment_methods')->where('id', $deposit->payment_method_id)->first();
              echo (isset($methodName->code)) ? $methodName->code : 'N/A';
              ?></td>
            <td data-title="{{ __('accounting::text.payment_id') }}">{{ $deposit->external_id }}</td>
            <td data-title="{{ __('accounting::text.status') }}"
                class="{{ $deposit->status == Packages\Accounting\Models\Deposit::STATUS_COMPLETED ? 'positive' : ($deposit->status == Packages\Accounting\Models\Deposit::STATUS_CANCELLED ? 'negative' : '') }}">{{ __('accounting::text.deposit_status_' . $deposit->status) }}</td>
            <td data-title="{{ __('accounting::text.amount') }}" class="right aligned">
              @if($deposit->account_currency_code != $deposit->payment_currency_code)
                <span
                    data-tooltip="{{ __('accounting::text.deposit_amount_tooltip', ['amount' => @$deposit->payment_amount, 'ccy' => $deposit->payment_currency_code, 'ccy1' => $deposit->account_currency_code, 'ccy2' => $deposit->payment_currency_code, 'x' => $deposit->payment_fx_rate]) }}"> <i
                      class="calculator tooltip icon"></i> </span>
              @endif
              {{ @$deposit->amount }} {{ $deposit->account_currency_code }}
            </td>
            <td data-title="{{ __('accounting::text.user') }}">
              <a href="{{ route('backend.users.edit', [$deposit->user_id]) }}">
                {{ $deposit->created_at }}
              </a>
            </td>

            <td data-title="{{ __('accounting::text.updated') }}" class="right aligned">
              {{--                                {{ $deposit->updated_at->diffForHumans() }}--}}
              <span data-tooltip="{{ $deposit->updated_at }}">
                                     <button style=" border: 1px solid #569211; padding: 7px 10px; border-radius: 3px; color: white; background-color: #8BC34A;" class="btn btn-xs btn-success custombtn"
                                             onclick="return savePayment(<?= $deposit->id ?>)">Clear Payment</button>
                                </span>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <?php } ?>
    <div class="right aligned column">
      {{ $deposits->appends(['sort' => $sort])->appends(['order' => $order])->links() }}
    </div>
    <?php } ?>
  </div>
  <div class="ui modaldeposit" style="display: none">
    <i class="close icon"></i>
    <div class="header">
      Add Comment
    </div>
    <div class="image content">

      <div class="description" style="width: 100%">
        <div class="ui header">
          <!-- simple form -->
          <form class="" role="form" method="post" action="">
            <input type="hidden" name="id" value="" id="depositId"/>
            {{ csrf_field() }}
            <p id="user_com_pre"></p>
            <textarea name="val" id="comment" cols="30" rows="10" style="margin: 0px;width: 806px;height: 118px;"></textarea>
            <p>
              <button class="ui positive right labeled icon button" type="button" onclick="return updateCommnt(this)" style="padding: 10px;"> Update <i class="checkmark icon"></i></button>
            </p>
          </form>

        </div>
      </div>
    </div>
    <div class="actions">

    </div>
  </div>

@endsection
@push('scripts')
  <script>
    function showComment(transactionId, com) {
      $('.ui.modaldeposit').modal('show');
      $('#depositId').val(transactionId);
      $('#comment').text(atob(com))
    }

    function updateCommnt(e) {
      let formData = $(this).closest('form');
      var dt = new Date();
      $.post('{{ url('admin/user/updateDepositComment') }}', {
        id: $('html').find('#depositId').val(),
        comment: $('html').find('#comment').val(),
        _token: '{{csrf_token()}}',
      }, function(res) {
        $('.ui.modal').modal('hide');
        window.location.reload();
        console.log(res);
      });
    }
  </script>
@endpush
