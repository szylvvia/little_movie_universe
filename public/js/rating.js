document.addEventListener("DOMContentLoaded", function () {
    let checkboxes = document.querySelectorAll('input[name="rate"]');
    let form = document.getElementById('rateForm');
    let rateError = document.getElementById("rateError");
    let reviewError = document.getElementById("reviewError");
    let review = document.getElementById("review");
    let clear = document.getElementById("toClearRate");

    checkboxes.forEach(function (checkbox) {
        let selectedValue = checkbox.value;

        if (checkbox.checked && selectedValue !== "0") {
            handleCheckboxChange(selectedValue);
        }
    });

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var selectedValue = this.value;
            handleCheckboxChange(selectedValue);
        });
    });

    clear.addEventListener('change', function ()
    {
        for (var i = 1; i <= 10; i++) {
            var checkbox = document.getElementById('rate' + i);
            checkbox.checked = false;
        }
        clear.checked = false;
    })



    form.addEventListener('submit', function (event) {
        if (!checkboxIsChecked()) {
            rateError.textContent = "Rate must be between 1 and 10";
            event.preventDefault();
        } else {
            rateError.textContent = "";
        }

        var text = review.value;
        if (text.length > 255) {
            reviewError.textContent = "Review must be less than 255 characters";
            event.preventDefault();
        } else {
            reviewError.textContent = "";
        }
    });

    function checkboxIsChecked() {
        let checkboxes = document.querySelectorAll('input[name="rate"]');
        let isChecked = false;

        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                isChecked = true;
            }
        });

        return isChecked;
    }

    function handleCheckboxChange(value) {
        for (var i = 1; i <= 10; i++) {
            var checkbox = document.getElementById('rate' + i);
            checkbox.checked = i <= value;
        }
    }

});
