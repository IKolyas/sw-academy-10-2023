const nowDate = new Date().getFullYear() + '-' + (new Date().getMonth() + 1);
const monthsFromNow = window.location.search.split('monthsFromNow=')[1] || nowDate;
const goNext = () => {

    var oldDate = new Date(monthsFromNow);

    //прибавляем 1 месяц к текущей дате
    oldDate.setMonth(oldDate.getMonth() + 1);

    var month = oldDate.getMonth() + 1;//индексация месяца начинается с нуля
    if (month < 9) {
        month = '0' + month;
    }
    window.location.href = `/calendar?monthsFromNow=${oldDate.getFullYear() + '-' + month}`;
}

const goPrev = () => {
    var oldDate = new Date(monthsFromNow);

    //удаляем 1 месяц от текущей дате
    oldDate.setMonth(oldDate.getMonth() - 1);

    var month = oldDate.getMonth() + 1;//индексация месяца начинается с нуля
    if (month < 9) {
        month = '0' + month;
    }
    window.location.href = `/calendar?monthsFromNow=${oldDate.getFullYear() + '-' + month}`;
}