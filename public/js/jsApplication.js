// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();


$(document).ready(function(){
    

    /*HABILITA OS LINKS AO CARREGAR O JS*/
    ConfigController.abilitarLink();

    //----------------- CONTROLA OS LINKS COM A CLASSE link-option
    /*$('body').delegate('.link-option', 'click', function(ev){
     
        ev.preventDefault();
        let url = $(this).attr('href');

        ConfigController.navegar(url)
    })*/


      

})




/*------------------- CONTROLLER DO CANDIDATO CONTROLER JS -----------------------*/
class CandidatoController extends BaseController{
  constructor(){

  }

  static comporCurriculo(url){

  }

  static adicionar(form){

  }
}
