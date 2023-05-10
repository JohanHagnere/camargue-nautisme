const params = new URLSearchParams(window.location.search);
const modal = document.createElement("div");
modal.classList.add("modal");

switch (params.get("success")) {
  case "true":
    modal.innerHTML =
      "<div id='resa-modal'><i id='close-btn-modal' class='fa-solid fa-xmark'></i><p>Félicitations, votre réservation a été effectuée avec succès !</p></div>";
    break;
  case "false":
    modal.innerHTML =
      "<div id='resa-modal'><i id='close-btn-modal' class='fa-solid fa-xmark'></i><p>Désolé, ce type d'équipement n'est pas disponible à cette date.</p></div>";
    break;

  default:
    break;
}
document.body.appendChild(modal);

const closeBtnModal = document.getElementById("close-btn-modal");

closeBtnModal.addEventListener("click", () => {
  const modal = document.querySelector(".modal");
  modal.style.display = "none";
});
