@extends('layouts.backend')

@section('title')
  ATS  {{ __('users.leads') }} : <?= auth()->user()->role ?>
@endsection

<style>
  #leads-table_paginate {
    display: none;
  }

  .set_status {
    min-height: 26px;
    border: 1px solid #37014f69;
    border-radius: 4px;
    width: 100%;
  }

  body > .pusher {
    overflow: scroll !important;
  }

  #leads-table thead > tr:first-child > th:nth-child(1) {
  }

  .ui.basic.olive.button {
    padding: 5px 10px !important;
    margin-left: 5px !important;
    text-align: center !important;
  }

  .basic.button i {
    margin: 0px !important;
  }

  .emailer {
    display: block;
    text-wrap: anywhere
  }
</style>
@section('content')
  <div class="ui one column stackable grid container">
    <div class="column">
      <?php if(auth()->user()->role != 'SALES'){ ?>
      <div class="ui column grid top-filter">
        <div class="ten wide column">
          <div id="set-salesman" class="ui selection dropdown">
            <input type="hidden" name="sales_id">
            <i class="dropdown icon"></i>
            <div class="default text">Set Salesman</div>
            <div class="menu">
              <?php $roleUsers = \App\Models\User::where('role', App\Models\User::ROLE_SALES)->get(); ?>
              @if(count($roleUsers))
                @foreach ($roleUsers   as $user)
                  <div class="item fesi" data-value="{{ $user->id }}">{{ $user->name }}</div>
                @endforeach
              @endif
            </div>
          </div>

          <div id="set-status" class="ui selection dropdown">
            <input type="hidden" name="crm_status" value="">
            <i class="dropdown icon"></i>
            <div class="default text">Set Status</div>
            <div class="menu">
              <div class="item" data-value="new">New</div>
              <div class="item" data-value="no-answer">No Answer</div>
              <div class="item" data-value="call-back">Call Back</div>
              <div class="item" data-value="wrong-number">Wrongnumber</div>
              <div class="item" data-value="no-language">No Language</div>
              <div class="item" data-value="do-not-call">Do Not Call</div>
              <div class="item" data-value="not-interested">Not Interested</div>
              <div class="item" data-value="make_lead">Deposit</div>
            </div>
          </div>
          <button id="btn-update-bulk" class="ui button">Update Selected</button>
        </div>
        <div class="six wide column">
          <div class="ui toggle checkbox">
            <input type="checkbox" name="autrefresh" id="autrefresh" {{ (session()->get('autoreffresh') == 1) ? 'checked' : ''  }}>
            <label>Auto refresh page every 30 seconds</label>
          </div>
        </div>
      </div>
      <?php } ?>

      <table id="leads-table" class="ui selectable tablet stackable {{ $inverted }} celled table">
        <thead>
        <tr>
          @component('components.tables.column', ['id' => 'id'])
            {{ __('users.id') }}
          @endcomponent
          @component('components.tables.column', ['id' => 'name'])
            {{ __('users.name') }}
          @endcomponent
          @component('components.tables.column', ['id' => 'email'])
            {{ __('users.email') }}
          @endcomponent
          @component('components.tables.column', ['id' => 'phone'])
            {{ __('users.phone') }} / {{ __('users.country') }}
          @endcomponent

          @component('components.tables.column', ['id' => 'assigned'])
            {{ __('users.assigned') }}
          @endcomponent
          @component('components.tables.column', ['id' => 'status'])
            {{ __('users.status') }}
          @endcomponent
          @component('components.tables.column', ['id' => 'created_at'])
            {{ __('users.date') }}
          @endcomponent
          @component('components.tables.column', ['id' => 'login'])
            Funnel
          @endcomponent

          {{-- <th></th> --}}
        </tr>
        </thead>
        <tbody>
        {{--     @dd(App\Models\User::find(1)->name);
            @dd($users[0]->id); --}}
        @foreach ($users as $user)
          @if($user->role == App\Models\User::ROLE_USER)
            <tr>
              <td data-title="{{ __('users.id') }}" class="user_id">
                <div class="ui checkbox">
                  <input type="checkbox" data-uid="{{ $user->id }}">
                  <label>{{ $user->id }}</label>
                </div>
                {{--    <input type="checkbox" id="{{ $user->id }}" name="{{ $user->id }}">
                   {{ $user->id }} --}}
              </td>
              <td data-title="{{ __('users.name') }}">
                <div style="max-width: 200px">
                  <a href="{{ route('backend.users.edit', $user) }}">
                    <img class="ui avatar image" src="{{ $user->avatar_url }}">
                    {{ $user->name }} {{ $user->last_name }}
                  </a>

                  @if($user->profiles)
                    @foreach($user->profiles as $profile)
                      <span class="tooltip" data-tooltip="{{ __('app.profile_id') }}: {{ $profile->provider_user_id }}">
                                            <i class="grey {{ $profile->provider_name }} icon"></i>
                                        </span>
                    @endforeach
                  @endif
                </div>
              </td>
              <td data-title="{{ __('users.email') }}">
                <div style="max-width: 150px">
                  <a href="mailto:{{ $user->email }}" class="emailer">{{ $user->email }}</a>
                </div>
              </td>
              <td data-title="{{ __('users.phone') }}">
                {{ $user->phone }} / {{ $user->country }}
              </td>

              <td data-title="{{ __('users.assigned') }}">
                @if( $user->sales_id == 0 )
                  Not Assigned
                @elseif( isset(App\Models\User::find($user->sales_id)->name) )
                  {{ App\Models\User::find($user->sales_id)->name }}
                @else
                  Not exists
                @endif
              </td>
              <td data-title="{{ __('users.status') }}" class="status">

                <form class="form" action="{{url('backend/users/update_status')}}" method="post" style="max-width: 200px">
                  <input type="hidden" name="id" value="{{$user->id}}"/>
                  @csrf
                  <select name="status" class="set_status form-control" required>
                    <option value="">Please select option</option>
                    <option {{ ($user->u_status == 'new') ?  'selected' : ''  }} value="new">New</option>
                    <option {{ ($user->u_status == 'no-answer') ?  'selected' : ''  }} value="no-answer">No Answer</option>
                    <option {{ ($user->u_status == 'call-back') ?  'selected' : ''  }} value="call-back">Call Back</option>
                    <option {{ ($user->u_status == 'wrong-number') ?  'selected' : ''  }} value="wrong-number">Wrong Number</option>
                    <option {{ ($user->u_status == 'no-language') ?  'selected' : ''  }} value="no-language">No Language</option>
                    <option {{ ($user->u_status == 'do-not-call') ?  'selected' : ''  }} value="do-not-call">Do Not Call</option>
                    <option {{ ($user->u_status == 'not-interested') ?  'selected' : ''  }} value="not-interested">Not Interested</option>
                    <option {{ ($user->u_status == 'make_lead') ?  'selected' : ''  }} value="make_lead">Deposit</option>
                  </select>
                </form>

              </td>
              <td data-title="{{ __('users.date') }}">
               <span> {{ (strpos($user->created_at , ' ') !== false ) ? @reset(@explode(' ', $user->created_at)) : $user->created_at  }}
               </span>
                <button class="ui olive basic button" type="button" onclick="return showComment('{{ $user->id }}' , '{{ base64_encode($user->leads_com) }}' , '{{$user->name}}')"><i class="comment icon"></i></button>
              </td>
              <td data-title="searchresult">
                <span style="display: none"> {{$user->u_status}}</span>
                <?php
                $source = 'N/A';
                $leadData = json_decode($user->ats_data, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($leadData['Funnel'])) {
                  $source = $leadData['Funnel'];
                }
                ?>
                <span style="width: 115px;display: block;overflow-wrap: anywhere;">{{ $source }}</span>
              </td>
            </tr>
          @endif
        @endforeach
        </tbody>

      </table>
      {{$users->render()}}

      {{--nmodal code for comments--}}
      <div class="ui modal">
        <i class="close icon"></i>
        <div class="header">
          Add Comment <span id="user_name"></span>
        </div>
        <div class="image content">

          <div class="description" style="width: 100%">
            <div class="ui header">
              <!-- simple form -->
              <form class="" role="form" method="post" action="">
                <input type="hidden" name="id" value="" id="user_id"/>
                <input type="hidden" name="col" value="leads_com" id="col"/>
                {{ csrf_field() }}
                <p id="user_com_pre"></p>
                <textarea name="val" id="user_com" cols="30" rows="10" id="user_com" style="margin: 0px;width: 806px;height: 118px;"></textarea>
                <p>
                  <br>
                  <button class="ui positive right labeled icon button" type="button" onclick="return updateCommnt(this)"> Update <i class="checkmark icon"></i></button>
                </p>
              </form>

            </div>
          </div>
        </div>
        <div class="actions">

        </div>
      </div>

    </div>

  </div>
@endsection

@push('scripts')
  <script>

    //function for updating status and salesperson using bulkupdate
    function updateUser(type, users, setSalesman, setStatus) {
      var data = {
        type: type,
        users: users,
        sales_id: setSalesman,
        crm_status: setStatus,
        _token: "{{ csrf_token() }}"
      }

      //console.log(data);

      $.ajax({
        url: "{{ url('/admin/users/ats_fast_update/') }}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        data: data,
        success: function(data) {
          //console.log(data);

          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Status Changed Succesfully',
            footer: '<a href="mailto:info@krytoconnection.com">Please contact support</a>'
          }).then(function() {
            window.location.reload(true);
          });


          //location.reload();
        },
        error: function(request, error) {
          //console.log("Request: " + JSON.stringify(request));
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            footer: '<a href="mailto:info@krytoconnection.com">Please contact support</a>'
          });
        }
      });


    }


    $(document).ready(function() {

      // Start Code for datatable
      $.fn.dataTableExt.ofnSearch['html-input'] = function(value) {
        // console.log(value);

        var newVal = $('.selected', value).text().trim();
        // console.log(newVal);
        return newVal;
      };


      $('#leads-table thead tr').clone(true).appendTo('#leads-table thead');
      $('#leads-table thead tr:eq(1) th').each(function(i) {

        var title = $(this).text().trim();
        if(title == 'Status') {
          var select = $('<select class="dropdown customdropdownsearch"><option value="">All</option></select>');
          $('#leads-table tr:nth-child(3) td.status select option').each(function() {
            var text = $(this).text().trim();
            var val = $(this).val().trim();
            select.append('<option value="' + val + '">' + text + '</option>');
          });

          $(this).html(select);
          select.dropdown();
        } else if(title == 'ID') {
          $(this).html('<div class="ui checkbox"><input type="checkbox"  id="check-all"><label></label></div>');
        } else if(title == 'Login') {
          $(this).html('');
        } else {
          $(this).html('<div class="field "><div class="fluid ui input"><input type="text"></div></div>');
        }

        $('input[type="text"]', this).on('keyup change', function() {
          if(table.column(i).search() !== this.value) {
            table
              .column(i)
              .search(this.value)
              .draw();
          }
        });
        $('html ').on('change', ' #leads-table th select', function() {
          table.column(7).search(this.value, false, true).draw();
        });
      });

      var table = $('#leads-table').DataTable({
        columnDefs: [
          {"type": "html-input", "targets": [6]}
        ],
        "pageLength": 100,
        orderCellsTop: true,
        fixedHeader: true,
        "order": [[0, "desc"]]

      });
      // end Code for datatable

      $('#leads-table input[name="crm_status"]').change(function() {
        //console.log("trigger");
        var obj = $(this);
        var name = obj.attr('name');
        var users = obj.closest('tr').find('.user_id').text().trim();
        var setStatus = obj.val();

        updateUser('crm_status', users, '', setStatus);

      });

      //Check all checkboxes
      $('#check-all').on('change', function() {
        if(this.checked) {
          $('#leads-table tbody tr input[type="checkbox"]').each(function() {
            $(this).prop('checked', true);
          });
        } else {
          $('#leads-table tbody tr input[type="checkbox"]').each(function() {
            $(this).prop('checked', false);
          });
        }
      });


      //Trigger update bulk
      $('#btn-update-bulk').on('click', function() {
        var setSalesman = $('#set-salesman').dropdown('get value');
        var setStatus = $('#set-status').dropdown('get value');

        var users = [];
        $("#leads-table [type='checkbox']:checked").each(function() {
          users[users.length] = $(this).attr('data-uid');
        });

        if((users.length > 0) && (setSalesman || setStatus)) {
          updateUser('bulk', users, setSalesman, setStatus);
        } else {

          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please make sure to select atleast one row and action(s) to perform!',
            footer: '<a href="mailto:info@krytoconnection.com">Have questions? Contact Support</a>'
          });
        }

        //destroy changes at the end
        $('#set-salesman, #set-status').dropdown('clear');
        $('#leads-table .checkbox.checked').checkbox('set unchecked');
      });
      $('#autrefresh').on('change', function() {
        $.post('{{ action('Backend\UserController@updateSessionAutorefresh') }}', {
          _token: '{{csrf_token()}}',
          isValue: (($("#autrefresh").prop('checked')) ? 1 : 0)
        }, function(res) {
          console.log(res);
        });
      });
      /*refesh every 30 seconds*/
      setInterval(function() {
        let con = $("#autrefresh").prop('checked');
        if(con == true) {
          window.location.reload();
        }
      }, 30 * 1000);
    });

    function showComment(userId, com, name) {
      $('.ui.modal').modal('show');
      $('#user_id').val(userId)
      $('#user_com_pre').html(atob(com))
      $('#user_name').text(name)
    }

    function updateCommnt(e) {
      let formData = $(this).closest('form');
      var dt = new Date();
      $.post('{{ url('admin/user/updateComment') }}', {
        id: $('html').find('#user_id').val(),
        col: $('html').find('#col').val(),
        val: ((($('#user_com_pre').text().trim() != '') ? $('#user_com_pre').text() + '</br>' : '') + $('html').find('#user_com').val() + ' @ User : {{ auth()->user()->email }} at <small>' + dt.toLocaleString() + '</samll>'),
        _token: '{{csrf_token()}}',
      }, function(res) {
        $('.ui.modal').modal('hide');
        window.location.reload();
        console.log(res);
      });
    }

    /*if there is a user then we need to update that*/
    $('html').on('change', '.set_status', function() {
      let postable = $(this).closest('form').serialize();
      $.ajax({
        url: "{{ url('/admin/users/update_status/') }}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        data: postable,
        success: function(data) {
          console.log(data);
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Status Changed Succesfully',
            footer: '<a href="mailto:admin@fxtrade-now.com">Please contact support</a>'
          }).then(function() {
            window.location.reload(true);
          });


          //location.reload();
        },
        error: function(request, error) {
          //console.log("Request: " + JSON.stringify(request));
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            footer: '<a href="mailto:info@krytoconnection.com">Please contact support</a>'
          });
        }
      });
    });
  </script>
@endpush
