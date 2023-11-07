//let add_item_link = document.querySelector('#add_item_link');
let addVideo = document.querySelector('#addVideo');
document.getElementById('add_item_link').style.color = 'red';
let dernier = 4;
let nombreAleatoire = 1;
add_item_link.addEventListener('click', () => {
    do {
        nombreAleatoire = genererNombreEntier(addVideo.length);
    } while (nombreAleatoire == dernier)
});