const del = document.querySelectorAll('.delete');
const linkDel = document.querySelectorAll('.confirmDelete')

console.log('coucou')
del.forEach((el,i) => {
        el.addEventListener('click', function(){
                linkDel[i].classList.toggle('confirm')
                console.log(del)
                });
        })






