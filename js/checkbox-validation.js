let checkboxes = Array.from(document.getElementsByClassName('form-check-input'));
let required = document.getElementById('checkbox_required');

checkboxes.forEach(cb => {
    cb.addEventListener('change', () => {
        let anyChecked = checkboxes.some(x => x.checked);
        
        if (anyChecked) {
            required.value = "ok";
        } else {
            required.value = "";
        }
    })
}

) 