document.addEventListener("DOMContentLoaded", function () {
    function handleFileInput(fileInput, errorMessagesSpan) {
        var maxSizeMB = 5;
        var maxSizeBytes = maxSizeMB * 1024 * 1024;
        var files = fileInput.files;

        if (files.length > 1) {
            errorMessagesSpan.textContent = "Please select only one file.";
            fileInput.value = "";
            return;
        }

        var file = files[0];

        var allowedExtensions = ['jpeg', 'png', 'jpg'];
        var extension = file.name.split('.').pop().toLowerCase();

        if (allowedExtensions.indexOf(extension) === -1) {
            console.log("ERROR EXT");
            errorMessagesSpan.textContent = "The file must be of type: " + allowedExtensions.join(', ');
            fileInput.value = "";
            return;
        }

        if (file.size > maxSizeBytes) {
            console.log("ERROR SIZE");
            errorMessagesSpan.textContent = "The file must not be larger than " + maxSizeMB + " MB.";
            fileInput.value = "";
            return;
        }

        errorMessagesSpan.innerText = "";
    }

    var imageInput = document.getElementById("image");
    var jsImageErrorMessagesSpan = document.getElementById("jsImageErrorMessages");
    var imageBackground = document.getElementById("background");
    var jsBackgroundErrorMessagesSpan = document.getElementById("jsBackgroundErrorMessages");

    imageInput.addEventListener("change", function () {
        handleFileInput(this, jsImageErrorMessagesSpan);
    });
    imageBackground.addEventListener("change", function () {
        handleFileInput(this, jsBackgroundErrorMessagesSpan);
    });

});
