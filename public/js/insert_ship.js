let idShips = document.querySelectorAll('.id');
idShip = ' ';
let idForData = ' ';
let data = new XMLHttpRequest();



//recuperer les Id de chaque vaisseau
idShips.forEach((idShip)=>{
    idShip.addEventListener('click', async function(e) {
        idForData = idShip.textContent  ;

        let shipId = this.dataset.id;
        let res = await fetch('http://localhost/maraudeurs/public/insert/ship/user/' + shipId)
            .then(res => res.json())

    });
})









