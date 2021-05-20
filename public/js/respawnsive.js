// creer une boucle pour pouvoir appliquer la fonction a toutes mes div
//j'utilise javascript pour pouvoir ajouter une classe ou enlever une classe
const descriptifs = document.querySelectorAll('.descriptif');
const parCerbere = document.querySelectorAll('.descriptif .effet');
//je mets tout dans un tableau pour pouvoir faire une boucle
descriptifs.forEach((el, i) => {
    //j'utilise la methode querySelector qui va ecouter l'evenement du click sur la classe descriptif
    el.addEventListener('click', function(){
        //la fonction toggle me permet d'ajouter ou d'enlever classe active
        parCerbere[i].classList.toggle('active');

    });
})

const menuButton = document.querySelector('#menu-button');
const menu = document.querySelector('#menu');

menuButton.addEventListener('click',function(){
    menu.classList.toggle('show-menu');
    menuButton.classList.toggle('close');
});

