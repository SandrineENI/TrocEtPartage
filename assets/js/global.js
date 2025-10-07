// Récupération unique des éléments
const mob = document.getElementById('mobile');
const desk = document.getElementById('desktop');
const copyRight = document.getElementById('copyRight');
const titrePortraitMob = document.getElementById('titrePortraitMob');
const titrePaysageMob = document.getElementById('titrePaysageMob');

// Vérification initiale
checkOrientation();
// Écouter les changements d'orientation
window.addEventListener("resize", checkOrientation);

function checkOrientation() {
    if (window.innerHeight > window.innerWidth) {
        if (/Mobi|Android|iPhone/i.test(navigator.userAgent)) {
            console.log('Mobile Hauteur > Largeur');
            mob.style.display = "block";
            desk.style.display = "none";
            titrePortraitMob.style.display = "block";
            titrePaysageMob.style.display = "none";
            copyRight.classList.replace('text1Rem', 'text2Rem');
        } else {
            mob.style.display = "block";
            desk.style.display = "none";
        }
    } else {
        if (/Mobi|Android|iPhone/i.test(navigator.userAgent)) {
            console.log('Mobilum Hauteur < Largeur');
            mob.style.display = "none";
            desk.style.display = "block";
            titrePortraitMob.style.display = "none";
            titrePaysageMob.style.display = "block";
            // copyRight.classList.replace('text1Rem', 'text2Rem');
        } else {
            mob.style.display = "none";
            desk.style.display = "block";
        }
    }
}
