document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('searchButton').addEventListener('click', function (event) {
        event.preventDefault();

        var searchString = document.getElementById('searchInput').value;
        console.log(searchString);
        window.location.href = "/search/" + searchString;
    });
});
