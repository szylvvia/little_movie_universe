document.addEventListener("DOMContentLoaded", function () {
    var editButton = document.getElementById("edit-button");
    var formContainer = document.getElementById("formContainer");
    formContainer.style.display = "none";
    var contentToHide = document.getElementById("contentToHide");

    editButton.addEventListener("click", function () {
        contentToHide.style.display = "none";
        formContainer.style.display = "flex";
    });
});
