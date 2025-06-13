const mess=document.getElementById('message');
document.addEventListener('DOMContentLoaded',()=>{
    mess.textContent='Bienvenue ! Vous pourriez reserver votre ticket ici'

    setTimeout(() => {

        mess.style.transform = 'translateX(400px)';}, 500);
    setTimeout(() => {
        mess.style.opacity = '0';
        mess.style.transition = 'opacity 1s ease-in-out';
        setTimeout(() => {

            mess.remove();}, 5000);
            }, 5000);
})