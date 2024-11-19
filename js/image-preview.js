function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('imagePreview');
        preview.src = reader.result;
        preview.style.display = "block"; 
    }

    reader.readAsDataURL(event.target.files[0]);
}