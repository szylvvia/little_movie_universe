document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById("searchInput");
    var searchResults = document.getElementById("searchResultsList");

    if (searchInput && searchResults) {
        searchInput.addEventListener("input", function () {
            var text = searchInput.value.trim();
            if (text.length >= 1) {
                executeDatabaseQuery(text);
                searchResults.innerHTML = "";
                searchResults.style.display = "block";
            } else {
                searchResults.innerHTML = "";
                searchResults.style.display = "none";
            }
        });

        searchResults.addEventListener("click", function (event) {
            if (event.target.tagName === "LI") {
                searchInput.value = event.target.textContent;
                searchResults.style.display = "none";
            }
        });

        document.addEventListener("click", function (event) {
            if (
                !searchResults.contains(event.target) &&
                event.target !== searchInput
            ) {
                searchResults.style.display = "none";
            }
        });
    }
    function executeDatabaseQuery(searchText) {
        fetch(`/searchReturnJson/${encodeURIComponent(searchText)}`)
            .then((response) => response.json())
            .then((data) => {
                displaySearchResults(data);
                console.log(data);
            })
            .catch((error) => {
                console.error("Błąd przy zapytaniu do bazy danych:", error);
            });
    }

    function displaySearchResults(results) {
        searchResults.innerHTML = "";

        results.forEach((item) => {
            const listItem = document.createElement("li");
            const linkItem = document.createElement("a");

            if (item.hasOwnProperty("title")) {
                listItem.textContent = item.title;
                linkItem.href = `/movies/${item.id}`;
            } else if (
                item.hasOwnProperty("email") &&
                item.hasOwnProperty("name") &&
                item.hasOwnProperty("surname")
            ) {
                listItem.textContent = `${item.name} ${item.surname}`;
                linkItem.href = `/showUser/${item.id}`;
            } else if (
                item.hasOwnProperty("name") &&
                item.hasOwnProperty("surname")
            ) {
                listItem.textContent = `${item.name} ${item.surname}`;
                linkItem.href = `/artists/${item.id}`;
            }

            listItem.classList.add("list-group-item");
            linkItem.classList.add("text-decoration-none");
            linkItem.appendChild(listItem);
            searchResults.appendChild(linkItem);
        });
        searchResults.style.display = "block";
    }
});
