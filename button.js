const button = document.getElementById("lackTimeBottun");
const form = document.getElementById("lackTimeInputForm");

document.addEventListener("click",(e) => {  
  if (e.target.id === "lackTimeBottun") {  
    form.classList.remove('non-show');
    form.classList.add('show');
    console.log('ok');
  }
})