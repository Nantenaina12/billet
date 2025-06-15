const mess=document.getElementById('message');
document.addEventListener('DOMContentLoaded',()=>{
    mess.textContent='Bienvenue! Appuyez sur Détails pour pouvoir effectuer la réservation😊';
    setTimeout(() => {

        mess.style.transform = 'translateX(400px)';}, 500);
    setTimeout(() => {
        mess.style.opacity = '0';
        mess.style.transition = 'opacity 1s ease-in-out';
        setTimeout(() => {

            mess.remove();}, 5000);
            }, 5000);
});
const image = document.querySelector(".ballon");
  const resultat = document.getElementById("resultat");

  image.addEventListener("click", function () {
    resultat.innerHTML = "<p style='color: green;'>Profitez bien l'occasion de cette CAN qui aura lieu ici au Maroc !</p>";

    // Effacer le message après 3 secondes
    setTimeout(() => {
      resultat.innerHTML = "";
    }, 3000); // 3000 millisecondes = 3 secondes
  });


