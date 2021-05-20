
// 1 selection element
// je creér la variable btn qui cible l id addtag de button
const btn = document.querySelector('#addTag');
// pareille pour la div avec l id tagContainer
const container = document.querySelector('#tagsContainer');
// la variable i va permettre d'incrémenter au variable voulue avec un compteur i. on le place a l exterieur dde l addEvent car si on le place dedans a chaque clique on va reinitialiser la variable i.
let i = 2
// un addEventListener est une boucle for manuel ( sans l incrémantation ) c'est pourquoi on ajoute le i pour permettre une incrémentation  a l ajout des input

//2 ajout d ecouteur d elem
btn.addEventListener('click',(e) => {
    e.preventDefault()
    // createElement permet de creer un element html, donc on créer un element input qui sera stocker dans une boite
    let input = document.createElement('input')
    // setAttribute va permettre d'ajouter des attribut a l'élément cibler, ici input represente notre variable créer au dessus avec le createElement, on ajoute donc un id qui s appelera tag
    input.setAttribute('id', 'tag' + i)
    input.setAttribute('name', 'tag' + i)
    input.setAttribute('type' , 'file')
    input.setAttribute('class', 'verif')
    let label = document.createElement('label')
    label.setAttribute('for' , 'tag' + i)
    label.innerText = 'Fichier' + i;
    label.classList.add('white');
    let br = document.createElement('br')
    container.appendChild(br)
    //appenchild permet d allez chercher l élémént creer avec createElement executer plus haut
    container.appendChild(label)
    container.appendChild(input)
    i++
})



//ecouter et verifier qu'il y est fichier dans le premier input
//stocker le fichier dans un tableau
//si c'est ce tableau est vide on ne clique pas sur le bouton ajout et si vide bloquer le bouton autre
//si c'est pas vide autoriser l appuie sur le bouton
