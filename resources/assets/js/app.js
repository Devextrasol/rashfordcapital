
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

import { config } from './utils'

Vue.component('assets-table',           require('./components/assets-table.vue'));
Vue.component('asset-chart',            require('./components/asset-chart.vue'));
Vue.component('competition-trade',      require('./components/competition-trade.vue'));
Vue.component('competition-form',       require('./components/competition-form.vue'));
Vue.component('data-feed',              require('./components/data-feed.vue'));
Vue.component('image-upload-input',     require('./components/image-upload-input.vue'));
Vue.component('locale-select',          require('./components/locale-select.vue'));
Vue.component('log-out-button',         require('./components/log-out-button.vue'));
Vue.component('message',                require('./components/message.vue'));
Vue.component('loading-form',           require('./components/loading-form.vue'));
Vue.component('chat',                   require('./components/chat.vue'));

Vue.prototype.$eventBus = new Vue();

// global and the only one Vue instance
const app = new Vue({
    el: '#app'
});
Vue.config.devtools = true;
// custom locale settings for numeral.js
numeral.register('locale', 'custom', {
    delimiters: {
        decimal: String.fromCharCode(config('settings.number_decimal_point')),
        thousands: String.fromCharCode(config('settings.number_thousands_separator'))
    },
    abbreviations: {
        thousand: 'k',
        million: 'm',
        billion: 'b',
        trillion: 't'
    },
    ordinal : function (number) {
        return '';
    },
    currency: {
        symbol: ''
    }
});
numeral.locale('custom');
if (!Number.prototype.integer) {
    Number.prototype.integer = function () {
        return numeral(this).format('0,0');
    };
}

if (!Number.prototype.decimal) {
    Number.prototype.decimal = function () {
        var num = numeral(this);
        var formatted = num.format('0,0.00');
        return formatted!=='NaN' ? formatted : parseFloat(this).toFixed(2);
    };
}

if (!Number.prototype.variableDecimal) {
    Number.prototype.variableDecimal = function () {
        var format;
        var num = numeral(this);
        var n = Math.abs(num.value());
        if (n >= 10) {
            format = '0,0.00';
        } else if (0.1 <= n && n < 10) {
            format = '0.0000';
        } else if (n < 0.1) {
            format = '0.00000000';
        }
        // for small numbers like  9.2e-7 numeral.format() will return NaN, so need a workaround
        var formatted = num.format(format);
        return formatted!=='NaN' ? formatted : parseFloat(this).toFixed(8);
    };
}

if (!Number.prototype.percentage) {
    Number.prototype.percentage = function () {
        return this.decimal()+'%';
    };
}

// Semantic UI controls initizalization
$('.ui.dropdown').not('.editable').dropdown();
$('.ui.editable.dropdown').dropdown({ allowAdditions: true });
$('.ui.checkbox').checkbox();
$('.ui.accordion').accordion();
$('.ui.popup-trigger').popup({ on: 'click' });

// Semantic search named API routes
$.fn.api.settings.api = {
    searchAssets: '/assets/search/{query}',
    searchCompetitionAssets: '/competitions/{competition}/assets/search/{query}',
    searchAllAssets:'/assets/all'
};

$(document).ready(function () {
    //code for search assets on trading page only
    if($('#asset-search').length) {
        $('#asset-search input').on('focus', function(){
            $('.assets-all').removeClass('transition visible').css('display', 'none');
        });
        $('#asset-search input').on('blur', function(){
            if($(this).val() == ''){
                $('.assets-all').addClass('transition visible').css('display', 'block');
            }
        });
    }
    //code for search assets on trading page only

    //code for edit user profile country dropdown
    if($('.frontend-users-edit').length) {
        var country = $('.country-dropdown select').attr('data-value');
        $('.ui.dropdown').dropdown('set selected',[country]);
    }
    if($('.backend-users-edit').length) {
        var country = $('.country-dropdown select').attr('data-value');
        $('.ui.dropdown').dropdown('set selected',[country]);
    }
    //code for edit user profile country dropdown



});