const nowDate = new Date().getFullYear() + '-' + (new Date().getMonth() + 1);
const yearMonth = window.location.search.split('yearMonth=')[1] || nowDate;
const goNext = () => {

    let oldDate = new Date(yearMonth);
    oldDate.setMonth(oldDate.getMonth() + 1); //прибавляем 1 месяц к текущей дате

    let month = oldDate.getMonth() + 1; //индексация месяца начинается с нуля
    if (month < 10) {
        month = '0' + month;
    }
    window.location.href = `/calendar?yearMonth=${oldDate.getFullYear() + '-' + month}`;
}

const goPrev = () => {

    let oldDate = new Date(yearMonth);
    oldDate.setMonth(oldDate.getMonth() - 1); //удаляем 1 месяц от текущей дате

    let month = oldDate.getMonth() + 1; //индексация месяца начинается с нуля
    if (month < 10) {
        month = '0' + month;
    }
    window.location.href = `/calendar?yearMonth=${oldDate.getFullYear() + '-' + month}`;
}

const generateGraph = () => {
    if (!window.location.search) {
        window.location.href ='/calendar?generateGraph=true';
    } else if(window.location.search.indexOf('yearMonth') !== -1) {
        window.location.href = `/calendar?generateGraph=true&yearMonth=${yearMonth}`;
    }
}

const deleteGraph = () => {
    if (!window.location.search) {
        window.location.href ='/calendar?generateGraph=false';
    } else if(window.location.search.indexOf('yearMonth') !== -1) {
        window.location.href = `/calendar?generateGraph=false&yearMonth=${yearMonth}`;
    }
}