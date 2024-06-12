function searchBar(tab) {
    const resultsBox = document.querySelector(".result__box");
    const inputBox = document.getElementById("input-box");
    const searchIcon = document.querySelector('.search-field i');

    let result = [];

    inputBox.onkeyup = function(event) {
        let input = inputBox.value;
        if (input.length > 0) {
            result = tab.filter((keyword) => {
                return keyword.name.toLowerCase().startsWith(input.toLowerCase());
            });
            console.log(result);
        }
        display(result);

        if (!result.length) {
            resultsBox.innerHTML = '';
        }

        // Si l'utilisateur appuie sur la touche "Entrée", redirige vers le premier résultat
        if (event.key === 'Enter' && result.length > 0) {
            window.location.href = 'tvshow.php?showId=' + result[0].id;
        }
    };

    // Si l'utilisateur clique sur l'icône de recherche, redirige vers le premier résultat
    searchIcon.onclick = function() {
        if (result.length > 0) {
            window.location.href = 'tvshow.php?showId=' + result[0].id;
        }
    };

    function display(result) {
        const content = result.map((show) => {
            return "<li class='result__item' onclick='selectInput(this)'><a class='result__link' href='tvshow.php?showId=" + show.id + "'>" + show.name + "</a></li>";
        });

        resultsBox.innerHTML = "<ul class='result__list'>" + content.join('') + "</ul>";
    }

    window.selectInput = function(selectedItem) {
        inputBox.value = selectedItem.textContent;
        resultsBox.innerHTML = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // availableKeywords should be defined in the HTML script tag
    const availableKeywords = JSON.parse(document.getElementById('artist-data').textContent);
    searchBar(availableKeywords);
});
