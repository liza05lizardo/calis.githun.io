document.getElementById('fileInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.innerHTML = '';
        const embed = document.createElement('embed');
        embed.setAttribute('type', 'application/postscript');
        embed.setAttribute('src', e.target.result);
        embed.setAttribute('width', '500');
        embed.setAttribute('height', '500');
        previewContainer.appendChild(embed);
        
    };
    reader.readAsDataURL(file);
});
