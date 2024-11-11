const calendarDaysElement = document.getElementById("calendar-days");
const calendarMonthYearElement = document.getElementById("calendar-month-year");

let currentDate = new Date();

function loadCalendar(date) {
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

        dayHTML += `<td><div class="calendar-day${isToday ? ' today' : ''}">${day}</div></td>`;

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
    loadCalendar(currentDate);
});