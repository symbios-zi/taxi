import Vue from 'vue';

Vue.filter('kilometerFormat', function (value) {
    if (typeof value !== "number") {
        return value;
    }
    let formatter = new Intl.NumberFormat('ru-RU', {
        style: 'decimal',
        minimumFractionDigits: 0,
        maximumFractionDigits: 1
    });
    return formatter.format(value);
});