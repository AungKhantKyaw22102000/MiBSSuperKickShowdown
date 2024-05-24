document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("player-search-form");
    const searchInput = document.getElementById("search-input");
    const searchResults = document.getElementById("search-results");

    searchForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const query = searchInput.value;

        fetch("../admin/search.php?query=" + query)
            .then(response => response.json())
            .then(data => {
                searchResults.innerHTML = "";

                if (data.length > 0) {
                    data.forEach(player => {
                        const resultItem = document.createElement("div");
                        resultItem.classList.add("row");
                        resultItem.innerHTML = `
                                
                            <div class="col s12"><br>
                                <div class="content-text">
                                    <a href="player-detail.php?viewplayer=${player.player_id}"><h6>${player.player_name}</h6></a>
                                    <p></p>
                                    <a href="team-detail.php?viewteam=${player.club_id}">
                                        <img src="../photo/${player.club_photo}" style="width: 18px; height: 18px;"> ${player.club_name}
                                    </a>
                                    <p></p>
                                    <a href="update_player.php?update=${player.player_id}">Update</a> ||
                                    <a href="delete_player.php?delete=${player.player_id}">Delete</a>
                                </div>
                            </div>
                        `;

                        searchResults.appendChild(resultItem);
                    });
                } else {
                    searchResults.innerHTML = "<p>No results found.</p>";
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });
});