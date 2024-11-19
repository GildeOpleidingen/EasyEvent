function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('imagePreview');
        preview.src = reader.result;
        preview.style.display = "block"; 
    }

    reader.readAsDataURL(event.target.files[0]);
}

const imagePreview = document.getElementById("imagePreview");
const resetBtn = document.getElementById('resetBtn');
resetBtn.addEventListener('click', function() {
    imagePreview.style.display = "none";
    imagePreview.src = "#";
});