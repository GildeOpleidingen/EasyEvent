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

    let activeTag = "all"; // default filter

    function getItems() {
      return Array.from(document.querySelectorAll(".ev-item"));
    }

    function filterEventsHandler() {
      try {
        const q = input.value.trim().toLowerCase();
        const items = getItems();

        if (items.length === 0) {
          console.warn("[searchbar] no .ev-item elements found in DOM.");
        }

        items.forEach((item) => {
          const tag = (item.getAttribute("data-tag") || "geen").toLowerCase();

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

          const textMatch = q === "" || title.includes(q) || desc.includes(q);
          const tagMatch = activeTag === "all" || tag === activeTag;

          if (textMatch && tagMatch) {
            item.classList.remove("d-none");
          } else {
            item.classList.add("d-none");

            // collapse if open
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

    window.filterByTag = function (tag) {
      activeTag = tag.toLowerCase();
      console.log("[searchbar] filterByTag:", activeTag);
      filterEventsHandler();
    };

    input.addEventListener("input", filterEventsHandler);

    window.filterEvents = filterEventsHandler;

    console.log("[searchbar] ready — items:", getItems().length);
  });
})();
