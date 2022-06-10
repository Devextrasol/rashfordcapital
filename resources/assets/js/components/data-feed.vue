<template></template>
<script type="text/babel">
    import UtilsMixin from './mixins/utils.vue'

    export default {
        mixins: [UtilsMixin],
        data() {
            return {
                intervalId: null,
                subscriptionAssetsIds: []
            }
        },
        methods: {
            changeAbs(price, changePct) {
                return price * (1 + changePct/100) - price;
            },
            pullMarketData() {
                axios.post('/assets/info', {
                        ids: this.subscriptionAssetsIds
                    }).then((response) => {
                        _.forEach(response.data, (asset) => {
                            this.$eventBus.$emit('quote', {
                                symbol:                     asset.symbol,
                                price:                      asset.price,
                                change_pct:                 asset.change_pct,
                                change_abs:                 asset.change_abs,
                                supply:                     asset.supply,
                                market_cap:                 asset.market_cap,
                                volume:                     asset.volume
                            });
                        });                        
                    }).catch((error) => {});
            }
        },
        mounted() {
            // REST API, pull quotes every X seconds
            this.$eventBus.$on('market-data-subscription', (ids) => {
                this.subscriptionAssetsIds = _.uniq(ids);
            });
            this.intervalId = setInterval(() => this.pullMarketData(), Math.max(1000, this.config('settings.assets_quotes_refresh_freq') * 1000));
        }
    }
</script>