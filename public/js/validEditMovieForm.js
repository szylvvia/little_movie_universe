document.addEventListener("DOMContentLoaded", function () {
    function validateEditMovieForm() {
        var checkboxes = document.getElementsByName("imagesToDelete[]");
        var imagesInput = document.getElementById("images");
        var jsImagesErrorMessages = document.getElementById(
            "jsImagesErrorMessages",
        );

        var allChecked = true;
        for (var i = 0; i < checkboxes.length; i++) {
            if (!checkboxes[i].checked) {
                allChecked = false;
                break;
            }
        }

        var imagesValue = imagesInput.value.trim();

        if (allChecked && imagesValue === "") {
            jsImagesErrorMessages.textContent =
                "Film musi mieć przynajmniej jeden fotos";
            for (i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }
            return false;
        }

        jsImagesErrorMessages.textContent = "";
        return true;
    }

    var checkboxes = document.getElementsByName("imagesToDelete[]");
    var imagesInput = document.getElementById("images");

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", validateEditMovieForm);
    });

    imagesInput.addEventListener("change", validateEditMovieForm);
});
