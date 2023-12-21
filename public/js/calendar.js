const nowDate = new Date().getFullYear() + '-' + (new Date().getMonth() + 1);
const monthsFromNow = window.location.search.split('monthsFromNow=')[1] || nowDate;
const goNext = () => {

    var oldDate = new Date(monthsFromNow);
    oldDate.setMonth(oldDate.getMonth() + 1);//прибавляем 1 месяц к текущей дате

    var month = oldDate.getMonth() + 1;//индексация месяца начинается с нуля
    if (month < 10) {
        month = '0' + month;
    }
    window.location.href = `/calendar?monthsFromNow=${oldDate.getFullYear() + '-' + month}`;
}

const goPrev = () => {

    var oldDate = new Date(monthsFromNow);
    oldDate.setMonth(oldDate.getMonth() - 1);//удаляем 1 месяц от текущей дате

    var month = oldDate.getMonth() + 1;//индексация месяца начинается с нуля
    if (month < 10) {
        month = '0' + month;
    }
    window.location.href = `/calendar?monthsFromNow=${oldDate.getFullYear() + '-' + month}`;
}

const generateGraph = () => {
    if (!window.location.search) {
        window.location.href ='/calendar?generateGraph=true';
    } else if(window.location.search.indexOf('monthsFromNow') !== -1) {
        window.location.href = `/calendar?generateGraph=true&monthsFromNow=${monthsFromNow}`;
    }
}

const deleteGraph = () => {
    if (!window.location.search) {
        window.location.href ='/calendar?generateGraph=false';
    } else if(window.location.search.indexOf('monthsFromNow') !== -1) {
        window.location.href = `/calendar?generateGraph=false&monthsFromNow=${monthsFromNow}`;
    }
}