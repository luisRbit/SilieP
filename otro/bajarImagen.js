let active = false;

function bajarImagen() {
    active = !active;

    const img = document.getElementById('miImagen');

    if (active) {
        img.classList.add('image');
        img.classList.remove('mi');
    }
    else {
        img.classList.add('mi');
        img.classList.remove('image');
    }
}
