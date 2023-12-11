document.addEventListener("DOMContentLoaded", function () {
    function handleFileInput(fileInput, errorMessagesSpan) {
        var maxSizeMB = 5;
        var maxSizeBytes = maxSizeMB * 1024 * 1024;
        var files = fileInput.files;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];

            var allowedExtensions = ['jpeg', 'png', 'jpg'];
            var extension = file.name.split('.').pop().toLowerCase();

            if (allowedExtensions.indexOf(extension) === -1) {
                // Update the text inside errorMessages span
                console.log("ERROR EXT");
                errorMessagesSpan.textContent = "Each file must be of type: " + allowedExtensions.join(', ');
                fileInput.value = "";
                return;
            }

            if (file.size > maxSizeBytes) {
                console.log("ERROR SIZE");
                errorMessagesSpan.textContent = "Each file must not be larger than " + maxSizeMB + " MB.";
                fileInput.value = "";
                return;
            }
        }

        errorMessagesSpan.innerText = "";
    }

    var imagesInput = document.getElementById("images");
    var jsImagesErrorMessagesSpan = document.getElementById("jsImagesErrorMessages");

    imagesInput.addEventListener("change", function () {
        handleFileInput(this, jsImagesErrorMessagesSpan);
    });

    var posterInput = document.getElementById("poster");
    var jsPosterErrorMessagesSpan = document.getElementById("jsPosterErrorMessages");

    posterInput.addEventListener("change", function () {
        handleFileInput(this, jsPosterErrorMessagesSpan);
    });

    //artysta
    var imageInput = document.getElementById("image");
    var jsImageErrorMessagesSpan = document.getElementById("jsImageErrorMessages");

    imageInput.addEventListener("change", function () {
        handleFileInput(this, jsImageErrorMessagesSpan);
    });

});
