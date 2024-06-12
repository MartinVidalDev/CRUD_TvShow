function searchBar(tab) {
    const resultsBox = document.querySelector(".result__box");
    const inputBox = document.getElementById("input-box");

    inputBox.onkeyup = function() {
        let result = [];
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
    };

    function display(result) {
        const content = result.map((show) => {
            return "<li onclick='selectInput(this)'><a href='tvshow.php?showId=" + show.id + "'>" + show.name + "</a></li>";
        });

        resultsBox.innerHTML = "<ul>" + content.join('') + "</ul>";
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
