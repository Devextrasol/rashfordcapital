<script type="text/babel">
    export default {
        props: ['user', 'competition', 'asset'],
        data() {
            return {
                selectedAsset: {}, // currently selected asset symbol
                assetsAll: {},
                assets: {}, // assets in open trades
                error: null,
                input: {
                    volume: null
                },
                loading: {
                    openTrade: false,
                    closeTrades: []
                },
                openTrades: [],
                participants: [],
                participantsRefreshIntervalId: null
            }
        },
        computed: {
            // assets in open trades + currently selected asset
            subscriptionAssetsIds() {
                return _.union(_.map(this.openTrades, 'asset.id'), [this.selectedAsset.id]);
            },
            margin() {
                var volume = parseFloat(this.input.volume);
                return !isNaN(volume) && volume > 0
                        ? this.competition.lot_size * volume * this.assets[this.selectedAsset.symbol].price / this.competition.leverage
                        : -1;
            },
            _margin() {
                return this.margin.decimal();
            },
            balance() {
                if (this.participants.length) {
                    var participant = _.find(this.participants, (participant) => participant.id == this.user.id);
                    return participant.data.current_balance;
                }
                return 0;
            },
            _balance() {
                return this.balance.decimal();
            },
            totalMargin() {
                return this.openTrades.length ? _.sumBy(this.openTrades, 'margin') : 0;
            },
            _totalMargin() {
                return this.totalMargin.decimal();
            },
            freeMargin() {
                return this.equity - this.totalMargin;
            },
            _freeMargin() {
                return this.freeMargin.decimal();
            },
            marginLevel() {
                return this.equity / this.totalMargin * 100;
            },
            _marginLevel() {
                return this.marginLevel.percentage();
            },
            totalUnrealizedPnl() {
                return this.openTrades.length ? _.sumBy(this.openTrades, (trade) => this.unrealizedPnl(trade)) : 0;
            },
            _totalUnrealizedPnl() {
                return this.totalUnrealizedPnl.decimal();
            },
            equity() {
                return this.balance + this.totalUnrealizedPnl;
            },
            _equity() {
                return this.equity.decimal();
            }
        },
        methods: {
            getAssetsAll() {
                axios.get('/assets/all')
                        .then((response) => {
                    if (response.status == 200) {
                        this.assetsAll = response.data;
                    }
                });
            },
            sellectAssetForAll(asset) {
                this.selectedAsset = asset;
                this.assets[this.selectedAsset.symbol] = asset;
                // remember current symbol in session
                axios.post('/assets/' + asset.id + '/remember');
            },
            getOpenTrades() {
                axios.get('/competitions/' + this.competition.id + '/trades')
                        .then((response) => {
                    if (response.status == 200) {
                    this.assets = _.assign(this.assets, _.fromPairs(_.map(response.data, (trade) => { return [trade.asset.symbol, trade.asset] })));
                    this.openTrades = response.data;
                }
            });
            },
            getParticipants() {
                axios.get('/competitions/' + this.competition.id + '/participants')
                        .then((response) => {
                    if (response.status == 200) {
                    this.participants = response.data;
                    // refresh data in 30 seconds
                    this.participantsRefreshIntervalId = setTimeout(() => this.getParticipants(), 30000);
                }
            });
            },
            unrealizedPnl(trade) {
                return trade.direction_sign * (this.assets[trade.asset.symbol].price - trade.price_open) * trade.lot_size * trade.volume;
            },
            openTrade(event) {
                this.loading.openTrade = true;
                var tradeDirection = parseInt(event.target.dataset.direction, 10);

                axios.post('/competitions/' + this.competition.id + '/assets/' + this.assets[this.selectedAsset.symbol].id + '/trade', {
                            direction:  tradeDirection,
                            volume:     this.input.volume
                        })
                        .then((response) => {
                    this.error = null;
                this.loading.openTrade = false;
                this.input.volume = null;
                this.assets[response.data.asset.symbol] = response.data.asset;
                // display new trade in the Open trades list
                this.openTrades.unshift(response.data);
            })
                .catch((error) => {
                    this.error = typeof error.response.data.errors.volume != 'undefined' ? error.response.data.errors.volume.join(' | ') : error.response.data.message;
                this.loading.openTrade = false;
            });
            },
            closeTrade(event) {
                var tradeId = parseInt(event.target.dataset.id, 10);
                var tradeIndex = parseInt(event.target.dataset.index, 10);
                this.loading.closeTrades.push(tradeId);

                axios.post('/competitions/' + this.competition.id + '/trades/' + tradeId + '/close')
                        .then((response) => {
                    this.assets[response.data.asset.symbol] = response.data.asset;
                // on success remove the trade from the list of open trades
                this.openTrades.splice(tradeIndex, 1);
                this.loading.closeTrades.splice(this.loading.closeTrades.indexOf(tradeId), 1);
                clearTimeout(this.participantsRefreshIntervalId);
                this.getParticipants();
            })
                .catch(function (error) {
                    this.loading.closeTrades.splice(this.loading.closeTrades.indexOf(tradeId), 1);
                });
            },
            marginFormula(trade) {
                return trade.margin.decimal() + ' = ' +
                        trade.lot_size.integer() + ' x ' +
                        trade.volume.decimal() + ' x ' +
                        trade.price_open.decimal() + ' / ' +
                        this.competition.leverage.integer();
            }
        },
        watch: {
            subscriptionAssetsIds(ids) {
                this.$eventBus.$emit('market-data-subscription', ids);
            }
        },
        created() {
            this.getOpenTrades();
            this.getParticipants();
        },
        mounted() {
            // save default (currenctly selected) asset
            this.selectedAsset = this.asset;
            this.assets[this.selectedAsset.symbol] = this.asset;

            // subscribe to new quotes
            this.$eventBus.$on('quote', (quote) => {
                if (typeof this.assets[quote.symbol] != 'undefined') {
                    this.assets[quote.symbol].price = quote.price;
                    if (this.selectedAsset.symbol == quote.symbol)
                        this.selectedAsset.price = quote.price;
                }
            });

            this.getAssetsAll();

            $('#asset-search')
                // Semantic UI:
                // By specifying a search as type: 'customType', and a custom template under $.fn.search.settings.templates.customType you can create custom search results.
                // Keep in mind that .title will be used for matching results onSelect

                .search({
                    type: 'assets',
                    minCharacters: 2,
                    searchOnFocus: true,
                    maxResults: 20,
                    transition: 'fade',
                    apiSettings: {
                        action: 'searchCompetitionAssets',
                        urlData: {
                            competition: this.competition.id
                        }
                    },
                    showNoResults: false, // hide no results message if nothing found
                    templates: {
                        assets(response) {
                            var html = '<div class="ui divided assets items">';
                            if (typeof response.results != 'undefined' && response.results.length) {
                                for (var i = 0; i < response.results.length; i++) {
                                    var asset = response.results[i];
                                    html +=
                                            '<div class="item">' +
                                            '   <img class="ui image" src="'+asset.logo_url+'">' +
                                            '   <div class="middle aligned content">' +
                                                // it's important to use .title class, so Semantic UI can take the value from there when specific asset is selected
                                            '       <div class="header symbol name title">' + asset.symbol + '</div>' +
                                            '       <div class="meta">' + asset.name + '</div>' +
                                            '   </div>' +
                                            '</div>';
                                }
                            }
                            html += '</div>';
                            return html;
                        }
                    },
                    onSelect: (asset, response) => {
                        this.selectedAsset = asset;
                        this.assets[this.selectedAsset.symbol] = asset;
                        // remember current symbol in session
                        axios.post('/assets/' + asset.id + '/remember');
                    },
                    selector: {
                        result: '.item',
                        results: '.search-results',
                    }
                });

        }
    }
</script>