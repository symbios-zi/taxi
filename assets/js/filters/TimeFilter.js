import Vue from 'vue';
import pluralize from 'pluralize-ru';

Vue.filter('timeFormat', function (value) {
    if (typeof value !== "number") {
        return value;
    }
    let formatter = new Intl.NumberFormat('ru-RU', {
        style: 'decimal',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
    let formattedValue = formatter.format(value);

    return pluralize(formattedValue, 'нет минут', '%d минута', '%d минуты', '%d минут');
});