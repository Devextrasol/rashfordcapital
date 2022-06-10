<?php
if (auth()->user()->id != null) {

  $userRoles = (DB::select('select roles.* from roles , role_users where roles.id = role_users.role_id and role_users.user_id =' . auth()->user()->id));
  if (isset($userRoles[0]->id) && in_array($userRoles[0]->id, [1, 4, 3])) {
    define('allowToshowStatus', 'true');
  }
}
?>
    <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  @include('includes.backend.head')
  <style>
    .ui.active.modal {
      display: block !important;
      background-color: #5d5d5d;
      border-radius: 11px;
    }

    .modalcustom label {
      color: white !important;
    }
    .select2-container{
      width: 100% !important;
    }
    .select2-container--default .select2-selection--single{
      height: 39px !important;
      padding-top: 4px !important;
    }
  </style>
</head>
<body class="{{ str_replace('.','-',Route::currentRouteName()) }} background-{{ $settings->background }} color-{{ $settings->color }}">

<div id="app">

  @include('includes.backend.header')

  <div class="pusher">

    <div id="before-content">
      @yield('before-content')
    </div>

    <div id="content">
      <div class="ui stackable grid container">
        <div class="column">
          <h1 class="ui block {{ $inverted }} header">
            @yield('title')
          </h1>
          @section('messages')
            @component('components.session.messages')
            @endcomponent
          @show
        </div>
      </div>
      @yield('content')
    </div>

    <div id="after-content">
      @yield('after-content')
    </div>

    @include('includes.backend.footer')

  </div>

</div>

@include('includes.backend.scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.1.5/css/iziToast.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.1.5/js/iziToast.min.js"></script>
{{--select 2 libraries--}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>

  //update main current market prices
  var statusoff = {{ (strpos(request()->fullUrl() , 'laravel') != false) ? 'true' : 'false'  }};


  function updateSalesNew(ele) {
    var form = $(ele).closest('form');
    $(form).find('button').prop('disabled', true);
    var clientId = $(form).find('select').attr('data-recid');
    var salesId = $(form).find('select').find(':selected').val();
    var _token = $(form).find("[name='_token']").val();
    $.post('/../updateSales', {
      'clientId': clientId,
      'salesId': salesId,
      '_token': _token
    }, function(data) {
      if(typeof data.status !== 'undefined' && data.status == 'success') {
        iziToast.info({
          title: 'Congratulations',
          message: 'lead has been assigned successfully',
        });
        $(form).find('button').prop('disabled', false);
      }
    })

  }

  function updateTable() {
    $('html').find('td:nth-child(5) > .formAppender').each(function() {
      $(this).closest('table').find('thead tr th:nth-child(8)').html('Assign To');
      $(this).closest('tr').find('td:nth-child(8)').html('');
      $(this).appendTo($(this).closest('tr').find('td:nth-child(8)'));
    });
  }


  // setInterval( updateTable, 2000);

  $(function() {
    <?php if(defined('allowToshowStatus')){ ?>
    setInterval(function() {
      if(statusoff) {
        return false;
      }
      // iziToast.destroy();
      var currentDate = moment().format('YYYYMMDD');
      var storedDate = localStorage.getItem('currentDate');

      if(storedDate === null) localStorage.setItem('currentDate', currentDate);
      /*rest the array*/
      if(currentDate > storedDate) {
        localStorage.setItem('newLogins', JSON.stringify([]));
        localStorage.setItem('newUser', JSON.stringify([]));
        localStorage.setItem('hotleads', JSON.stringify([]));
        localStorage.setItem('withdraw', JSON.stringify([]));
        localStorage.setItem('deposit', JSON.stringify([]));
        localStorage.setItem('currentDate', currentDate);
      }


      var newLoginsGetter = localStorage.getItem('newLogins');
      if(newLoginsGetter !== null && newLoginsGetter.length === 0) {
        localStorage.setItem('newLogins', JSON.stringify([]));
      }
      var newUsersGetter = localStorage.getItem('newUsers');
      if(newUsersGetter !== null && newUsersGetter.length === 0) {
        localStorage.setItem('newUser', JSON.stringify([]));
      }

      var hotleadsGetter = localStorage.getItem('hotleads');
      if(hotleadsGetter !== null && hotleadsGetter.length === 0) {
        localStorage.setItem('hotleads', JSON.stringify([]));
      }

      var withdrawGetter = localStorage.getItem('withdraw');
      if(withdrawGetter !== null && withdrawGetter.length === 0) {
        localStorage.setItem('withdraw', JSON.stringify([]));
      }
      var depositGetter = localStorage.getItem('deposit');
      if(depositGetter !== null && depositGetter.length === 0) {
        localStorage.setItem('deposit', JSON.stringify([]));
      }

      var currentDate = moment().format("YYYY-MM-DD");

      $.post('{{ action('Backend\UserController@getpaymentStatus') }}', {
        'date': currentDate,
        '_token': '{{csrf_token()}}',
      }, function(res) {


        /*
        *  deposits
        */
        if(typeof res.deposit !== 'undefined' && res.deposit != '') {
          var storage = new Array();
          var jsonData = JSON.parse(localStorage.getItem('deposit'));

          var flag = false;
          if(jsonData !== null && jsonData.length > 0) {
            $.each(jsonData, function(k, v) {
              if(res.deposit == v) {
                flag = true;
              }
            });
          }

          if(flag === false) {
            iziToast.info({
              title: 'Deposit',
              message: res.deposit,
              timeout: 10000,
              buttons: [['<button>Deposit</button>', function(instance, toast) {
                window.location.href = " action('DepositController@index') ";
              }, true], // true to focus
              ],
            });
            storage.push(res.deposit);
          }
          /*when message finishes we store it in localstorage*/
          if(jsonData !== null && jsonData.length > 0) {
            $.each(jsonData, function(k, v) {
              storage.push(v);
            });
          }
          console.log(storage);
          localStorage.setItem('deposit', JSON.stringify(storage));
        }
        /*
        * withdraw requests
        */
        if(typeof res.withdraw !== 'undefined' && res.withdraw != '') {
          var storage = new Array();
          var jsonData = JSON.parse(localStorage.getItem('withdraw'));

          var flag = false;
          if(jsonData !== null && jsonData.length > 0) {
            $.each(jsonData, function(k, v) {
              if(res.withdraw == v) {
                flag = true;
              }
            });
          }

          if(flag === false) {
            iziToast.info({
              title: 'withdrawals',
              message: res.withdraw,
              timeout: 10000,
              buttons: [['<button>Withdrawal</button>', function(instance, toast) {
                window.location.href = "action('WithdrawalController@index')";
              }, true], // true to focus
              ]
            });
          }

          /*when message finishes we store it in localstorage*/
          if(jsonData !== null && jsonData.length > 0) {
            $.each(jsonData, function(k, v) {
              storage.push(v);
            });
          }
          storage.push(res.withdraw);
          localStorage.setItem('withdraw', JSON.stringify(storage));
        }
        /*
        * if New user edit
        */

        if(typeof res.newUser !== 'undefined' && res.newUser != '') {
          var storage = new Array();
          var jsonData = JSON.parse(localStorage.getItem('newUser'));

          var flag = false;

          if(jsonData !== null && jsonData.length > 0) {
            $.each(jsonData, function(k, v) {
              if(res.newUser == v) {
                flag = true;
              }
            });
          }

          if(flag === false) {
            iziToast.info({
              title: 'Congratulations',
              message: res.newUser,
              timeout: 10000,
              buttons: [['<button>Users</button>', function(instance, toast) {
                window.location.href = "action('UserController@index')";
              }, true], // true to focus
              ]
            });
            storage.push(res.newUser);
          }

          /*when message finishes we store it in localstorage*/
          if(jsonData !== null && jsonData.length > 0) {
            $.each(jsonData, function(k, v) {
              storage.push(res.newUser);
            });
          }

          localStorage.setItem('newUser', JSON.stringify(storage));
        }

        if(typeof res.hotleads !== 'undefined' && res.hotleads != '') {
          var storage = new Array();
          var jsonData = JSON.parse(localStorage.getItem('hotleads'));

          var flag = false;

          if(jsonData !== null && jsonData.length > 0) {
            $.each(jsonData, function(k, v) {
              if(res.hotleads == v) {
                flag = true;
              }
            });
          }

          if(flag === false) {
            iziToast.info({
              title: 'Congratulations',
              message: res.hotleads,
              timeout: 10000,
              buttons: [['<button>Users</button>', function(instance, toast) {
                window.location.href = "action('UserController@index')";
              }, true], // true to focus
              ]
            });
            storage.push(res.hotleads);
          }

          /*when message finishes we store it in localstorage*/
          if(jsonData !== null && jsonData.length > 0) {
            $.each(jsonData, function(k, v) {
              storage.push(res.hotleads);
            });
          }

          localStorage.setItem('hotleads', JSON.stringify(storage));
        }

        if(typeof res.newLogins !== 'undefined' && (res.newLogins).length > 0) {

          var storage = new Array();
          var jsonDataString = (localStorage.getItem('newLogins'));
          var jsonData = JSON.parse(localStorage.getItem('newLogins'));
          var newLogins = res.newLogins;

          if(newLogins !== null && newLogins.length > 0) {

            $.each(newLogins, function(k, v) {

              if(jsonDataString !== null && jsonDataString.indexOf(v) === -1) {
                iziToast.info({
                  title: 'ALert ! ',
                  message: v,
                  timeout: 10000,

                });
                storage.push(v);
              }
            });

          }
          if(jsonData !== null && jsonData.length > 0) {
            $.each(jsonData, function(k, v) {
              storage.push(v);
            });
          }
          localStorage.setItem('newLogins', JSON.stringify(storage));
        }


      });
    }, 3000);
    <?php } ?>
    <?php if(isset($userRoles[0]->id) && $userRoles[0]->id == 3){ ?>
    setInterval(function() {
      if(statusoff) {
        return false;
      }
      $.post('{{ url('admin/pendingLeads') }}', {
        '_token': '{{csrf_token()}}',
      }, function(res) {
        if(typeof res.msg !== 'undefined' && res.msg != '') {
          iziToast.info({
            title: 'Alert ',
            message: res.msg,
          });
        }
      })
    }, 3000);
    <?php } ?>


  });
  document.addEventListener('DOMContentLoaded', function() {
    $('.open-model').on('click', function() {
      console.log('here');
      $('.ui.basic.modal').modal('show');
    })
$('.select2').select2();
  }, false);
</script>
</body>
</html>
