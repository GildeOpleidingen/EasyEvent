const calendarDaysElement = document.getElementById("calendar-days");
const calendarMonthYearElement = document.getElementById("calendar-month-year");

let currentDate = new Date();

function loadCalendar(date) {
    if (!calendarDaysElement || !calendarMonthYearElement) {
        return;
    }

    const year = date.getFullYear();
    const month = date.getMonth();
    const today = new Date();

    calendarMonthYearElement.textContent = date.toLocaleDateString("default", { month: "long", year: "numeric" });

    calendarDaysElement.innerHTML = "";

    const firstDayOfMonth = new Date(year, month, 1);
    const lastDayOfMonth = new Date(year, month + 1, 0);
    const daysInMonth = lastDayOfMonth.getDate();

    const firstDayIndex = (firstDayOfMonth.getDay() + 6) % 7; 

    let dayHTML = "<tr>";

    for (let i = 0; i < firstDayIndex; i++) {
        dayHTML += "<td></td>";
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const isToday = today.toDateString() === date.toDateString();
        const dateKey = `${year}-${String(month + 1).padStart(2, "0")}`
            + `-${String(day).padStart(2, "0")}`;
        const hasEvents = document.querySelector(`.ev-item[data-event-date="${dateKey}"]`);
        const isSelected = window.selectedEventDate === dateKey;
        const classes = ["text-white", "calendar-day"];

        if (isToday) classes.push("today");
        if (hasEvents) classes.push("has-events");
        if (isSelected) classes.push("active");

        dayHTML += `<td><button type="button"
            class="${classes.join(" ")}" ${hasEvents ? "" : "disabled"}
            aria-pressed="${isSelected}" data-event-date="${dateKey}">${day}</button></td>`;

        if ((firstDayIndex + day) % 7 === 0) {
            dayHTML += "</tr><tr>";
        }
    }

    dayHTML += "</tr>";
    calendarDaysElement.innerHTML = dayHTML;
}

function prevMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    loadCalendar(currentDate);
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    loadCalendar(currentDate);
}

document.addEventListener("DOMContentLoaded", () => {
    if (!calendarDaysElement || !calendarMonthYearElement) {
        return;
    }

    window.selectedEventDate = null;

    calendarDaysElement.addEventListener("click", (event) => {
        const dayButton = event.target.closest(".calendar-day.has-events");
        if (!dayButton) {
            return;
        }

        window.selectedEventDate = window.selectedEventDate === dayButton.dataset.eventDate
            ? null
            : dayButton.dataset.eventDate;
        window.filterEvents?.();
        loadCalendar(currentDate);
    });

    loadCalendar(currentDate);
});