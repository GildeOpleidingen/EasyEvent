function filterEvents() {
    const searchInput = document.getElementById('zoek').value.toLowerCase();
    const eventItems = document.querySelectorAll('.event-item');

    eventItems.forEach(item => {
        const title = item.querySelector("h3").textContent.toLowerCase();
        const description = item.querySelector("p").textContent.toLowerCase();

        if (title.includes(searchInput) || description.includes(searchInput)) {
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    })
}