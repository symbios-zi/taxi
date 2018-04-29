import Vue from 'vue';

Vue.filter('roubleCurrency', function (value) {
    if (typeof value !== "number") {
        return value;
    }
    let formatter = new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'RUB',
        minimumFractionDigits: 0
    });
    return formatter.format(value);
});