<template>
    <table v-if="assets.length" class="ui selectable tablet stackable table">
        <thead>
            <tr>
                <slot name="header"></slot>
            </tr>
        </thead>
        <tbody>
            <tr v-for="asset in assets">
                <td :data-title="_symbol">
                    <img :src="asset.logo_url" class="ui avatar image">
                    {{ asset.symbol }}
                </td>
                <td :data-title="_name">{{ asset.name }}</td>
                <td :data-title="_price" class="right aligned">
                    <i :class="[{ 'up green': asset.change_abs > 0 || asset.change_pct > 0, 'down red': asset.change_abs < 0 || asset.change_pct < 0}, 'arrow icon']"></i>
                    {{ assetsQuotes[asset.symbol].price.variableDecimal() }}
                </td>
                <td :data-title="_abschange" :class="[{ positive: asset.change_abs > 0, negative: asset.change_abs < 0}, 'right aligned']">{{ assetsQuotes[asset.symbol].change_abs.variableDecimal() }}</td>
                <td :data-title="_pctchange" :class="[{ positive: asset.change_pct > 0, negative: asset.change_pct < 0}, 'right aligned']">{{ assetsQuotes[asset.symbol].change_pct.decimal() }}</td>
                <td :data-title="_mktcap" class="right aligned">{{ assetsQuotes[asset.symbol].market_cap.integer() }}</td>
                <td :data-title="_trades" class="right aligned">{{ asset.trades_count }}</td>
            </tr>
        </tbody>
    </table>
</template>
<script type="text/babel">
    import UtilsMixin from './mixins/utils.vue'
    
    export default {
        mixins: [UtilsMixin],
        props: ['assetsList'],
        data() {
            return {
                assetsQuotes: {},
                assets: {}
            }
        },
        computed: {
            _symbol() {
                return this.__('app.symbol');
            },
            _name() {
                return this.__('app.name');
            },
            _price() {
                return this.__('app.price');
            },
            _abschange() {
                return this.__('app.change_abs');
            },
            _pctchange() {
                return this.__('app.change_pct');
            },
            _mktcap() {
                return this.__('app.market_cap');
            },
            _trades() {
                return this.__('app.trades');
            }
        },
        methods: {
            changeAbs(price, changePct) {
                return price * (1 + changePct/100) - price;
            }
        },
        mounted() {
            this.assets = this.assetsList;
            this.assetsQuotes = _.fromPairs(_.map(this.assetsList, (asset) => { return [asset.symbol, asset] }));

            this.$eventBus.$emit('market-data-subscription', _.map(this.assetsList, 'id'));

            // subscribe to new quotes
            this.$eventBus.$on('quote', (quote) => {
                if (typeof this.assetsQuotes[quote.symbol] != 'undefined') {
                    this.assetsQuotes[quote.symbol].price = quote.price;
                    this.assetsQuotes[quote.symbol].change_pct = quote.change_pct;
                    this.assetsQuotes[quote.symbol].change_abs = quote.change_abs;
                    this.assetsQuotes[quote.symbol].market_cap = quote.market_cap;
                }
            });
        }
    }
</script>