@extends('layouts.frontend')

{{-- @section('title')
  {{ __('accounting::text.account') }}
@endsection --}}

@section('content')
<div class="ui stackable grid container-fluid">
        <div class="tablet only computer only three wide column">
            @include('pages.frontend.competitions.sidebar')
        </div>

    <div class="ui thirteen wide column tablet stackable">
      @include('includes.frontend.header')
{{-- <h1 class="ui blue header">{{ __('accounting::text.account') }}</h1> --}}
	@if($payment_methods)
      <div class="column">
      	<div class="menu-payment">
      		<div class="payment-methos">
	          @foreach($payment_methods as $payment_method)
	          <a href="{{ route('frontend.deposits.create', [Auth::user(), $payment_method]) }}" class="item">
	          <div class="payment-item">
	          	<div class="payment-logo">
	          		<img src="{{ asset('images/').'/'.strtolower(__('accounting::text.method_' . $payment_method->id)) }}.png">
	          	</div>
	            <p>{{ __('accounting::text.method_' . $payment_method->id) }}</p>
	            </div>
	        </a>
	          @endforeach
          </div>
        </div>
      </div> 
      @endif
    @includeFirst(['includes.frontend.footer-udf','includes.frontend.footer'])
  </div>
    </div>

@endsection
