const monthsFromNow = +window.location.search.split('monthsFromNow=')[1] || 0;

const goNext = () => {
    window.location.href = `/calendar?monthsFromNow=${monthsFromNow + 1}`;
}

const goPrev = () => {
    window.location.href = `/calendar?monthsFromNow=${monthsFromNow - 1}`;
}


document.addEventListener('click', (event) => {
    if (event.target.classList.contains('currentMonthDay')) {
        alert(event.target.firstElementChild.attributes.datetime.value)
    }
});