const multiSelectWithoutCtrl = (elemSelector) => {
    let options = document.querySelectorAll(`${elemSelector} option`);

    options.forEach(function (element) {
        element.addEventListener("mousedown", function (e) {
            e.preventDefault();
            this.selected = !this.selected;
            element.parentElement.focus();
            return false;
        }, false);
    });
}
document.addEventListener("DOMContentLoaded", function () {
    multiSelectWithoutCtrl('#mySelectInput');
});
