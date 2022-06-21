@extends('layouts.frontend')

{{-- @section('title')
    {{ $competition->title }}
@endsection --}}
<style>
  .openpricechange {
    padding: 5px;
    border: 1px solid #cfd2d5;
    border-radius: 5px;
    max-width: 156px;
  }
</style>
@section('content')
  <?php
  $userDetails = false;
  $allowedRoles = ['FLOOR_MANAGER', 'ADMIN'];
  //{{-- $userDetails = \Illuminate\Support\Facades\DB::table('users')->latest()->first();

  if (session()->has('impersonate_by')) {
    $userDetails = \Illuminate\Support\Facades\DB::table('users')->where('id', session()->get('impersonate_by'))->first();
    if (is_object($userDetails) && in_array($userDetails->role, $allowedRoles)) {
      $userDetails = true;
    }
  } elseif (in_array(auth()->user()->role, $allowedRoles)) {
    $userDetails = true;
  }

  ?>
  <data-feed></data-feed>
  <competition-trade :user="{{ auth()->user() }}" :competition="{{ $competition }}" :asset="{{ $asset }}" inline-template>
    <div class="ui stackable grid container-fluid">
      <div class="tablet only computer only three wide column">
        @include('pages.frontend.competitions.sidebar')
      </div>
 <div class="ui thirteen wide column tablet stackable">
    @include('includes.frontend.header-trade')
    <div class="ui stackable grid container-fluid">
      <div class="ui thirteen wide column tablet stackable inner">
        <div class="ui one column grid trade-labels">
          {{-- @include('pages.frontend.competitions.header') --}}
          <div class="ui stackable grid container">
            <div class="column">
              <div class="ui labels">
                <template v-if="openTrades.length">
                  <span class="ui {{ $settings->color }} basic label">{{ __('app.balance') }}: @{{ _balance }} {{ $competition->currency->code }}</span>
                  <span class="ui {{ $settings->color }} basic label">{{ __('app.pnl') }}: @{{ _totalUnrealizedPnl }} {{ $competition->currency->code }}</span>
                  <span class="ui {{ $settings->color }} basic label" data-tooltip="{{ __('app.equity_tooltip') }}" {{ $inverted ? 'data-inverted="false"' : '' }}>
                                        {{ __('app.equity') }}: @{{ _equity }} {{ $competition->currency->code }}
                                    </span>
                  <span class="ui {{ $settings->color }} basic label">{{ __('app.margin') }}: @{{ _totalMargin }} {{ $competition->currency->code }}</span>
                  <span class="ui {{ $settings->color }} basic label" data-tooltip="{{ __('app.free_margin_tooltip') }}" {{ $inverted ? 'data-inverted="false"' : '' }}>
                                        {{ __('app.free_margin') }}: @{{ _freeMargin }} {{ $competition->currency->code }}
                                    </span>
                  <span class="ui {{ $settings->color }} basic label" data-tooltip="{{ __('app.margin_level_tooltip') }}" {{ $inverted ? 'data-inverted="false"' : '' }}>
                                        {{ __('app.margin_level') }}: @{{ _marginLevel }} {{ $competition->currency->code }}
                                    </span>
                  <span v-if="marginLevel < competition.min_margin_level" class="tooltip" data-tooltip="{{ __('app.margin_level_warning') }}" {{ $inverted ? 'data-inverted="false"' : '' }}>
                                        <i class="red exclamation triangle icon"></i>
                                    </span>
                </template>

              </div>
            </div>
          </div>
        </div>
        <div class="ui one column grid trade-wrapper">
          <div class="center aligned column">
            <div class="custom-row">
              <div class="graph-wrapper">
                <template v-if="selectedAsset.symbol">
                <asset-chart :asset="selectedAsset" color="{{ $settings->color }}" :currency="{{ json_encode(['code' => config('settings.currency'), 'rate' => $currency_rate]) }}"
                             :inverted="{{ $inverted ? 'false' : 'true' }}"></asset-chart>
              </template> 
              </div>
               <div class="input-wrapper">
                 <div class="center aligned column">
            <template v-if="selectedAsset.symbol">
              <div class="ui {{ $inverted }} statistic">
                <div class="value">
                  <img :src="selectedAsset.logo_url" class="ui circular inline image">
                  <h3>@{{ selectedAsset.price.variableDecimal() }}</h3>
                </div>
                <div class="label">
                  @{{ selectedAsset.name }} (@{{ selectedAsset.symbol }})
                </div>
              </div>
            </template>
            <template v-else>
              <div id="asset-info-loader" class="ui active centered inline loader"></div>
            </template>
            <div id="trade-form" class="ui {{ $inverted }} form">
              <div class="fields">
                <div v-cloak class="field">
                  <div v-if="!input.volume || isNaN(input.volume) || input.volume <= 0" class="ui pointing label">
                    {{ __('app.input_volume') }}
                  </div>
                  <div v-else :class="['ui basic pointing label', {green: margin <= freeMargin, red: margin > freeMargin}]">
                    {{  __('app.margin_required') }}: @{{ _margin }} {{ $competition->currency->code }}
                    <span v-if="margin > freeMargin"> ({{ __('app.free_margin') }}: @{{ _freeMargin }}) {{ $competition->currency->code }}</span>
                  </div>
                </div>
              </div>
              <div class="ui big buttons">
                <button class="ui positive trade button" :class="[{ disabled: margin < 0 || margin > freeMargin || assets[selectedAsset.symbol].price==0 }, this.loading.openTrade ? 'disabled loading' : '']"
                        @click="openTrade" data-direction="{{ \App\Models\Trade::DIRECTION_BUY }}">{{ __('app.buy') }}</button>
                <input v-model="input.volume" name="volume" placeholder="{{ $competition->volume_min }} &mdash; {{ $competition->volume_max }}" type="text" autocomplete="off">
                <button class="ui negative trade button" :class="[{ disabled: margin < 0 || margin > freeMargin || assets[selectedAsset.symbol].price==0 }, this.loading.openTrade ? 'disabled loading' : '']"
                        @click="openTrade" data-direction="{{ \App\Models\Trade::DIRECTION_SELL }}">{{ __('app.sell') }}</button>
              </div>
            </div>
            <template v-if="selectedAsset.symbol">
              <div v-if="error" class="ui red basic pointing label">
                {{ __('app.error') }}: @{{ error }}
              </div>
            </template>
          </div>
               </div>
            </div>
            
          </div>
          
          <div class="column">
            <template v-if="openTrades.length">
              <table id="open-trades-table" class="ui basic tablet stackable {{ $inverted }} table">
                <thead>
                <tr>
                  <th>{{ __('app.asset') }}</th>
                  <th class="right aligned">{{ __('app.quantity') }}</th>
                  <th class="right aligned">{{ __('app.open_price') }}, {{ $competition->currency->code }}</th>
                  <th class="right aligned">{{ __('app.current_price') }}, {{ $competition->currency->code }}</th>
                  <th class="right aligned">{{ __('app.margin') }}, {{ $competition->currency->code }}</th>
                  <th class="right aligned">{{ __('app.pnl') }}, {{ $competition->currency->code }}</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(trade,tradeIndex) in openTrades">
                  <td data-title="{{ __('app.asset') }}" class="nowrap">
                    <div class="trade-symbol">
                      <img :src="trade.asset.logo_url" class="ui avatar image">
                      <span class="tooltip" :data-tooltip="trade.asset.name" {{ $inverted ? 'data-inverted="false"' : '' }}>
                                                @{{ trade.asset.symbol }}
                                            </span>
                      <span v-if="trade.direction == {{ \App\Models\Trade::DIRECTION_BUY }}" class="ui tiny basic green label">
                                                <i class="arrow up icon"></i>
                                                {{ __('app.trade_direction_' . \App\Models\Trade::DIRECTION_BUY) }}
                                            </span>
                      <span v-else class="ui tiny basic red label">
                                                <i class="arrow down icon"></i>
                                                {{ __('app.trade_direction_' . \App\Models\Trade::DIRECTION_SELL) }}
                                            </span>
                    </div>
                    <div class="secondary-info">
                      <i class="calendar outline icon"></i>
                      @{{ trade.created_at }}
                    </div>
                  </td>
                  <td data-title="{{ __('app.quantity') }}" class="right aligned">@{{ trade.volume.decimal() }}</td>
                  <td data-title="{{ __('app.open_price') }}" class="right aligned">
                    @if ($userDetails !== false)
                    <input class="openpricechange" type="text" name="open_price" targetid="" originalVal="" value="" placeholder="Open price"
                        {{ ($userDetails !== false) ? '' : 'disabled'  }}
                    />
                    <span class="price" style="display:none;">@{{ trade.price_open.variableDecimal() }}</span>
                    <span class="id" style="display:none;">@{{ trade.id }}</span>
                    @else
                      @{{ trade.price_open.variableDecimal() }}
                    @endif

                  </td>
                  <td data-title="{{ __('app.current_price') }}" class="right aligned">@{{ assets[trade.asset.symbol].price.variableDecimal() }}</td>
                  <td data-title="{{ __('app.margin') }}" class="right aligned">
                                        <span class="tooltip" :data-tooltip="marginFormula(trade)" {{ $inverted ? 'data-inverted="false"' : '' }}>
                                            @{{ trade.margin.variableDecimal() }}
                                        </span>
                  </td>
                  <td data-title="{{ __('app.pnl') }}" :class="[{ positive: unrealizedPnl(trade)>0, negative: unrealizedPnl(trade)<0 }, 'right aligned']">@{{ unrealizedPnl(trade).decimal() }}</td>
                  <td class="right aligned tablet-and-below-center">
                    <button class="ui {{ $settings->color }} small button" :class="loading.closeTrades.indexOf(trade.id) > -1 ? 'disabled loading' : ''" @click="closeTrade" :data-id="trade.id"
                            :data-index="tradeIndex">{{ __('app.close') }}</button>
                  </td>
                </tr>
                </tbody>
              </table>
            </template>
            <template v-else>
              <div class="ui message">{{ __('app.no_open_trades') }}</div>
            </template>
          </div>
        </div>
      </div>
      <div class="ui three wide column tablet stackable mobile-col">
        <div class="ui one column grid right-sidebar"> 
          <div class="column">
            {{-- <div id="asset-search" class="ui tablet-and-below-center  {{ $inverted }} search">
              <div class="ui icon input">
                <input class="prompt" type="text" placeholder="{{ __('app.search') }}">
                <i class="search icon"></i>
              </div>
              <div class="search-results"></div>

            </div> --}}
            {{-- <div class="search-results"></div> --}}
            <div class="assets-all">
              <template v-if="assetsAll"> 
                <div class="ui divided assets items">
                  <div class="item" v-for="asset in assetsAll.results" v-on:click="sellectAssetForAll(asset)">
                    <img class="ui image" v-bind:src="asset.logo_url"/>
                    <div class="middle aligned content">
                      <div class="header symbol name title">
                        @{{ asset.symbol }}
                      </div>
                      <div class="meta">
                        @{{ asset.name }}
                        {{-- @{{ asset.price }} --}}
                      </div>
                    </div>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
      @includeFirst(['includes.frontend.footer-udf','includes.frontend.footer'])
    </div>
      {{--
                  <div class="column">
                  @if($assets->isEmpty())
                      <div class="ui segment">
                          <p>{{ __('app.assets_empty') }}</p>
                      </div>
                  @else
                      <assets-table :assets-list="{{ $assets->getCollection() }}" class="ui selectable {{ $inverted }} table">
                          <template slot="header">
                              @component('components.tables.sortable-column', ['id' => 'symbol', 'sort' => $sort, 'order' => $order])
                                  {{ __('app.symbol') }}
                              @endcomponent
                              @component('components.tables.sortable-column', ['id' => 'name', 'sort' => $sort, 'order' => $order])
                                  {{ __('app.name') }}
                              @endcomponent
                              @component('components.tables.sortable-column', ['id' => 'price', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
                                  {{ __('app.price') }}, {{ config('settings.currency') }}
                              @endcomponent
                              @component('components.tables.sortable-column', ['id' => 'change_abs', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
                                  {{ __('app.change_abs') }}, {{ config('settings.currency') }}
                              @endcomponent
                              @component('components.tables.sortable-column', ['id' => 'change_pct', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
                                  {{ __('app.change_pct') }}
                              @endcomponent
                              @component('components.tables.sortable-column', ['id' => 'market_cap', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
                                  {{ __('app.market_cap') }}, {{ config('settings.currency') }}
                              @endcomponent
                              @component('components.tables.sortable-column', ['id' => 'trades_count', 'sort' => $sort, 'order' => $order, 'class' => 'right aligned'])
                                  {{ __('app.trades') }}
                              @endcomponent
                          </template>
                      </assets-table>
                  @endif
              </div> --}}


    </div>

    @endsection

    @push('scripts')
      <script>

        <?php if($userDetails !== false){ ?>
        //function for updating status and salesperson using bulkupdate
        function updatepriceCOntroller(recId, data) {
          console.log(data);
          var data = {
            id: recId,
            price_open: data.replace(/[^\d.]/g, ''),
            _token: "{{ csrf_token() }}"
          }
          $.post("{{ url('competitions/update') }}", data, function() {
            $('html').find('[targetid="' + recId + '"]').css({border: '2px solid green'});
          });

        }

        $(function() {
          $('html').on('focusout', '.openpricechange', function() {
            let previousVal = $(this).attr('originalVal').trim();
            let recId = $(this).attr('targetid').trim();
            let currentVal = $(this).val().trim();
            if(previousVal != currentVal) {
              updatepriceCOntroller(recId, currentVal);
            }
          });
        });


        <?php } ?>
        $(document).ready(function() {
          setTimeout(function() {
            $('html').find('.openpricechange').each(function() {
              let open_price = $(this).closest('td').find('.price').text();
              let id = $(this).closest('td').find('.id').text();
              $(this).attr('targetid', id);
              $(this).attr('originalVal', open_price);
              $(this).val(open_price);
            });
          }, 3500);
        });


      </script>
  @endpush
