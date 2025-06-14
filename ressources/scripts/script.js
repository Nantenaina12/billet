const mess=document.getElementById('message');
document.addEventListener('DOMContentLoaded',()=>{
    mess.textContent='Bienvenue! Appuyez sur Détails pour pouvoir effectuer la réservation';
    setTimeout(() => {

        mess.style.transform = 'translateX(400px)';}, 500);
    setTimeout(() => {
        mess.style.opacity = '0';
        mess.style.transition = 'opacity 1s ease-in-out';
        setTimeout(() => {

            mess.remove();}, 5000);
            }, 5000);
})