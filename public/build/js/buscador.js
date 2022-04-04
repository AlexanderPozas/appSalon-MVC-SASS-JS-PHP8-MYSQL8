function iniciarApp(){buscarPorFecha()}function buscarPorFecha(){document.querySelector("#fecha").addEventListener("input",e=>{fecha=e.target.value,window.location="?fecha="+fecha})}document.addEventListener("DOMContentLoaded",()=>{iniciarApp()});
//# sourceMappingURL=buscador.js.map
