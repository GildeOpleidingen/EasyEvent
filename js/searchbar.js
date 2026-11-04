(function () {
  console.log("[searchbar] loaded");

  document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("search-input-top");
    if (!input) {
      console.error(
        "[searchbar] #search-input-top not found — check ID or script path."
      );
      return;
    }

    const url = new URL(window.location.href);
    input.value = url.searchParams.get("search") || "";

    function getItems() {
      return Array.from(document.querySelectorAll(".ev-item"));
    }

    const buttons = document.querySelectorAll("[data-sector-filter]");
    let selectedSector = url.searchParams.get("sector") || "all";
    if (![...buttons].some((button) => button.dataset.sectorFilter.trim() === selectedSector)) {
      selectedSector = "all";
    }

    buttons.forEach((button) => {
      const selected = button.dataset.sectorFilter.trim() === selectedSector;
      button.classList.toggle("active", selected);
      button.setAttribute("aria-pressed", selected);
    });

    function filterEventsHandler() {
      try {
        const q = input.value.trim().toLowerCase();
        if (selectedSector === "all") {
          url.searchParams.delete("sector");
        } else {
          url.searchParams.set("sector", selectedSector);
        }
        if (q) {
          url.searchParams.set("search", q);
        } else {
          url.searchParams.delete("search");
        }
        window.history.replaceState(window.history.state, "", url);

        const items = getItems();
        if (items.length === 0) {
          console.warn("[searchbar] no .ev-item elements found in DOM.");
        }

        items.forEach((item) => {
          const titleEl =
            item.querySelector(".accordion-button") ||
            item.querySelector(".accordion-header") ||
            item.querySelector("h3") ||
            item.querySelector("h2") ||
            item.querySelector(".card-title");

          const descEl =
            item.querySelector(".accordion-body p") ||
            item.querySelector(".accordion-body") ||
            item.querySelector("p");

          const title = titleEl
            ? (titleEl.textContent || "").toLowerCase()
            : "";
          const desc = descEl ? (descEl.textContent || "").toLowerCase() : "";

          const sectors = (item.dataset.sectorIds || "")
            .split(",")
            .map((sector) => sector.trim());
          const matchesSector = selectedSector === "all" || sectors.includes(selectedSector);
          const match = matchesSector && (q === "" || title.includes(q) || desc.includes(q));

          if (match) {
            item.classList.remove("d-none");
          } else {
            item.classList.add("d-none");

            const openCollapse = item.querySelector(
              ".accordion-collapse.collapse.show"
            );
            if (
              openCollapse &&
              window.bootstrap &&
              typeof bootstrap.Collapse === "function"
            ) {
              const inst =
                bootstrap.Collapse.getInstance(openCollapse) ||
                new bootstrap.Collapse(openCollapse, { toggle: false });
              inst.hide();
            }
          }
        });
      } catch (err) {
        console.error("[searchbar] error in filterEventsHandler:", err);
      }
    }

    input.addEventListener("input", filterEventsHandler);
    window.filterEvents = filterEventsHandler;
    filterEventsHandler();

    buttons.forEach((button) => {
      button.addEventListener("click", () => {
        selectedSector = button.dataset.sectorFilter.trim();
        buttons.forEach((filterButton) => {
        filterButton.classList.toggle("active", filterButton === button);
        filterButton.setAttribute("aria-pressed", filterButton === button);
        });
        filterEventsHandler();
      });
    });

    console.log("[searchbar] ready — items:", getItems().length);
  });
})();