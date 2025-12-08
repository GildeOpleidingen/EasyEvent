let activityCount = 1; // Start met 1 activiteit

document.getElementById('addActivity').addEventListener('click', () => {
    activityCount++;
    const activitiesContainer = document.getElementById('activitiesContainer');

    // Nieuwe activiteit-invoervelden
    const newActivity = document.createElement('div');
    newActivity.classList.add('activity-item', 'mb-3');
    newActivity.innerHTML = `
        <div class="row">
            <div class="col-md-4">
                <label for="activityName${activityCount}" class="form-label">Naam <span class="verplicht">*</span></label>
                <input type="text" class="form-control" id="activityName${activityCount}" name="activity-name[]" placeholder="Activiteit Naam" required>
                <div class="invalid-feedback">Voer een activiteit naam in.</div>
            </div>
            <div class="col-md-4">
                <label for="activityBeginTime${activityCount}" class="form-label">Begintijd <span class="verplicht">*</span></label>
                <input type="time" class="form-control" id="activityBeginTime${activityCount}" name="activity-begintime[]" required>
                <div class="invalid-feedback">Voer een activiteit begin tijd in.</div>
            </div>
            <div class="col-md-4">
                <label for="activityEndTime${activityCount}" class="form-label">Eindtijd <span class="verplicht">*</span></label>
                <input type="time" class="form-control" id="activityEndTime${activityCount}" name="activity-endtime[]" required>
                <div class="invalid-feedback">Voer een activiteit eind tijd in.</div>
            </div>
            <div class="col-md-4">
                <label for="activityPeople${activityCount}" class="form-label">Aantal personen <span class="verplicht">*</span></label>
                <input type="number" class="form-control" id="activityPeople${activityCount}" name="activity-people[]" placeholder="Aantal personen" required>
                <div class="invalid-feedback">Voer het aantal personen in voor de activiteit</div>
            </div>
        </div>
    `;

    // Voeg nieuwe activiteit toe
    activitiesContainer.appendChild(newActivity);
});

document.getElementById('btnToForm2').addEventListener('click', () => {
    document.getElementById('formEventDetails').style.display = 'none';
    document.getElementById('formActivities').style.display = 'block';
});

document.getElementById('btnToForm1').addEventListener('click', () => {
    document.getElementById('formActivities').style.display = 'none';
    document.getElementById('formEventDetails').style.display = 'block';
});
