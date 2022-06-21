@extends('layouts.index_new')

@section('content')

<!--  --------INSTUMENT-------- -->
<div class="instument ui main container">
    <div class="ui stackable two column grid instument-column">
        <div class="sixteen wide tablet ten wide computer column">
          <div class="content-wrapper">
          <h2 class="instument-h">Price Chart EUR</h2>
        </div>
        </div>
        <div class="six wide column computer only">

        </div>
      </div>

  <div class="ui grid">
    <div class="sixteen wide tablet ten wide computer column krypto-table">

        {{-- some code for table  --}}
     {{--    @php
        var_dump($assets);
        @endphp
        {{ dd($assets)->getCollection() }} --}}

        @if($assets->isEmpty())
            <div class="ui segment">
                <p>{{ __('app.assets_empty') }}</p>
            </div>
        @else
            <assets-table :assets-list="{{ $assets->getCollection() }}" class="ui selectable {{ $inverted }} table table_new">
                <template slot="header">
                    @component('components.tables.sortable-column', ['id' => 'symbol', 'sort' => $sort, 'order' => $order])
                        {{-- {{ __('app.symbol') }} --}}
                    @endcomponent
                    @component('components.tables.sortable-column', ['id' => 'name', 'sort' => $sort, 'order' => $order])
                        {{-- {{ __('app.name') }} --}}
                    @endcomponent
                    @component('components.tables.sortable-column', ['id' => 'price', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
                        {{ __('app.price') }}{{-- , {{ config('settings.currency') }} --}}
                    @endcomponent
                    @component('components.tables.sortable-column', ['id' => 'change_abs', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
                        {{ __('app.change_abs') }}{{-- , {{ config('settings.currency') }} --}}
                    @endcomponent
                    @component('components.tables.sortable-column', ['id' => 'change_pct', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
                        {{ __('app.change_pct') }}
                    @endcomponent
                    @component('components.tables.sortable-column', ['id' => 'market_cap', 'sort' => '$sort', 'order' => $order, 'class' => 'right aligned'])
                        {{ __('app.market_cap') }}{{-- , {{ config('settings.currency') }} --}}
                    @endcomponent
             {{--        @component('components.tables.sortable-column', ['id' => 'trades_count', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
                        {{ __('app.trades') }}
                    @endcomponent --}}
                </template>
            </assets-table>
        @endif



        {{-- some code for table  --}}

      <table class="ui very basic table" style="display: none;">
        <thead>
          <tr>
            <th class="add-hover">Most Popular</th>
            <th class="add-hover">Trending Now</th>
            <th></th>
            <th ></th>
            <th ></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="black-text">Bitcoin</td>
            <td class="black-text"></td>
            <td><button class="sell-btn" onclick="window.location='{{ route('register') }}'">Sell</button></td>
            <td class="blue-text">1.3572 €</td>
            <td><button class="buy-btn" onclick="window.location='{{ route('register') }}'">Buy</button></td>
            <td class="red-text">-0.25%</td>
          </tr>
          <tr>
            <td class="black-text">Ethereum</td>
            <td class="red-text"></td>
            <td><button class="sell-btn" onclick="window.location='{{ route('register') }}'">Sell</button></td>
            <td class="red-text">13283.66 €</td>
            <td><button class="buy-btn" onclick="window.location='{{ route('register') }}'">Buy</button></td>
            <td class="black-text">-0.89%</td>
          </tr>
          <tr>
            <td class="black-text">XRP</td>
            <td class="black-text"></td>
            <td><button class="sell-btn" onclick="window.location='{{ route('register') }}'">Sell</button></td>
            <td class="black-text">1.10832 €</td>
            <td><button class="buy-btn" onclick="window.location='{{ route('register') }}'">Buy</button></td>
            <td class="black-text">-0.12%</td>
          </tr>
          <tr>
            <td class="black-text">Bitcoin Cash</td>
            <td class="black-text"></td>
            <td><button class="sell-btn" onclick="window.location='{{ route('register') }}'">Sell</button></td>
            <td class="black-text">27590 €</td>
            <td><button class="buy-btn" onclick="window.location='{{ route('register') }}'">Buy</button></td>
            <td class="black-text">0.53%</td>
          </tr>
          <tr>
            <td class="black-text">Tether</td>
            <td class="black-text"></td>
            <td><button class="sell-btn" onclick="window.location='{{ route('register') }}'">Sell</button></td>
            <td class="blue-text">1.3572 €</td>
            <td><button class="buy-btn" onclick="window.location='{{ route('register') }}'">Buy</button></td>
            <td class="red-text">-0.25%</td>
          </tr>
          <tr>
            <td class="black-text">Litecoin</td>
            <td class="red-text"></td>
            <td><button class="sell-btn" onclick="window.location='{{ route('register') }}'">Sell</button></td>
            <td class="red-text">13283.66 €</td>
            <td><button class="buy-btn" onclick="window.location='{{ route('register') }}'">Buy</button></td>
            <td class="black-text">-0.89%</td>
          </tr>
          <tr>
            <td class="black-text">EOS</td>
            <td class="black-text"></td>
            <td><button class="sell-btn" onclick="window.location='{{ route('register') }}'">Sell</button></td>
            <td class="black-text"> 1.10832 €</td>
            <td><button class="buy-btn" onclick="window.location='{{ route('register') }}'">Buy</button></td>
            <td class="black-text">-0.12%</td>
          </tr>
          <tr>
            <td class="black-text">Binance Coin</td>
            <td class="black-text"></td>
            <td><button class="sell-btn" onclick="window.location='{{ route('register') }}'">Sell</button></td>
            <td class="black-text">27590 €</td>
            <td><button class="buy-btn" onclick="window.location='{{ route('register') }}'">Buy</button></td>
            <td class="black-text">0.53%</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="sixteen wide tablet six wide computer column get-more">
      <h1 class="Headinh-h1">Get More</h1>
      <p>We offer the complete package:</p>
      <ul class="inner-ul">
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="" class="mobile-hidden" >  Tight spreads</li>
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="" class="mobile-hidden">  No commisions</li>
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="" class="mobile-hidden">  Leverage of up to 1:50</li>
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="" class="mobile-hidden">  Fast and reliable order</li>
      </ul>
      <a href="" class="learn-more">Learn More</a>
    </div>
  </div>
</div>
<!-- -------WHAT WE OFFER------- -->
<div class="what-we-offer ">
  <div class="ui main container">
    <div class="wide column MObile-column"><img class="ui fluid image" src="{{ asset('images/mockup.png') }}" alt=""></div>
    <div class="wide column MObile-column">
      <h1 class="Headinh-h1">What We Offer</h1>
      <ul class="inner-ul">
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="" class="mobile-hidden">More Then 1,100 Cryptocurrencies to Trade.</li>
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="" class="mobile-hidden">Live Crypto Quotes.</li>
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="" class="mobile-hidden">Instant Trade Execution.</li>
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="" class="mobile-hidden">Real-Time Position Valuation (Equity.Profit/Loss. Free Margin.)</li>
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="" class="mobile-hidden">In-Depth Trading Statistics</li>
      </ul>

      <button onclick="window.location='{{ route('register') }}'" class="i-want-to-try hello">I Want to Try</button>


    </div>
<div class="hide-column">
  <div class="ui stackable two column grid">
    <div class="eight wide column">
      <h1 class="Headinh-h1">What We Offer</h1>
      <ul class="inner-ul">
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="">More Then 1,100 Cryptocurrencies to Trade.</li>
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="">Live Crypto Quotes.</li>
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="">Instant Trade Execution.</li>
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="">Real-Time Position Valuation (Equity.Profit/Loss. Free Margin.)</li>
        <li><img src="{{ asset('images/plus_icon.png') }}" alt="">In-Depth Trading Statistics</li>
      </ul>
        <a href="{{ route('register') }}" class="i-want-to-try">I Want to Try</a>
    </div>
    <div class="eight wide column"><img class="ui fluid image img-style" src="{{ asset('images/mockup.png') }}" alt=""></div>
  </div>
</div>
</div>
</div>
<!--   ------EXPLORE MARKET------- -->
<div class="explore-market ">
  <div class="ui main container">
  <div class="ui stackable two column grid">
    <div class="sixteen wide tablet ten wide computer column">
      <img class="ui hide-tablet" src="{{ asset('images/mac.png') }}" alt="">
      <img class="ui fluid image display-tablet" src="{{ asset('images/mac.png') }}" alt="">
    </div>
    <div class="sixteen wide tablet six wide computer column page-content">
      <div>
      <h1 class="Headinh-h1">Explore Market</h1>
      <p>Trade the world’s most popular markets and explore endless trading opportunities. We offer +1000<br>Cryptocurrencies, FREE real time quotes and dedicated<br>round-the-clock customer support.</p>
      </div>
    </div>
  </div>
</div>
</div>
    <!--  ------TRADE WITH TRUST------ -->
<div class="trade-with-trus">
    <div class="ui stackable two column grid ui main container">
      <div class="sixteen wide tablet eight wide computer column">
      <h1 class="Headinh-h1">Trade With Trust </h1>
      <div class="inline-field"><img src="{{ asset('images/tick.png') }}" >
      <p class="p-style ">
        {{ env('_app_name_f') }} leading provider of Contracts for Difference (CFDs) delivering trading facilities on cryptocurrencies alongside innovative trading technology.</p></div>
      <div class="inline-field"><img src="{{ asset('images/tick.png') }}" >
        <p class="p-style ">{{ env('_app_name_f') }} holds client money in a segregated trust account
      in accordance with the EU legal requirements.</p></div>
      <div class="inline-field margin-btm"><img src="{{ asset('images/tick.png') }}" >
        <p class="p-style ">{{ env('_app_name_f') }} is one of the highest rated CFD platfrom as it is simple to use yet powerful in its many advanced features.It also includes CFDs on wide range of Cryptocurrencies</p></div>
      <a href="{{ url('page/about-us') }}" class="i-want-to-try">Read More About Us</a>

    </div>
    <div class="sixteen wide tablet eight wide computer column ">
      <div class="style-cloumn">
          <div class="ui stackable two column grid">
      <div class="sixteen wide tablet eight wide computer column">
        <img src="{{ asset('images/icon-1.png') }}" alt="" class="trust-img">
        <p><b>Leading Provider Of Contracts for Difference (CFDs)</b></p>

      </div>
      <div class="sixteen wide tablet eight wide computer column">
        <img src="{{ asset('images/icon-2.png') }}" alt="" class="trust-img">
        <p><b>Ranked #1 In Traders choice</b></p>
      </div>
    </div>
    <div class="ui stackable two column grid">
      <div class="sixteen wide tablet eight wide computer column">
        <img src="{{ asset('images/icon-3.png') }}" alt="" class="trust-img">
        <p><b>Your funds are kept in segregated
bank accounts</b></p>
      </div>
      <div class="sixteen wide tablet eight wide computer column">
        <img src="{{ asset('images/icon-4.png') }}" alt="" class="trust-img">
        <p><b>Secured By SSL</b></p>
      </div>
    </div>
  </div>
  </div>
</div>
</div>
@endsection
