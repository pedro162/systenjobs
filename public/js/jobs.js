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

  //------------------ ENVIA OS DADOS PARA LOGAR ------------------
   $('body').delegate('form#login', 'submit', function(ev){

      let form = $(this);
      return LoginController.logar(form, ev)
     
  })

   /**
   *
   * Validaos dados do candidato
   */ 
   $('body').delegate('form#adicionarCandidato', 'submit', function(ev){

        try{

          let form =  $(this);

          let cand = new Candidato();

          cand.setNome(form.find('input[name=nome]').val())
          cand.setSobrenome(form.find('input[name=sobrenome]').val())
          cand.setCpf(form.find('input[name=cpf]').val())
          cand.setDtNascimento(form.find('input[name=nascimento]').val())
          cand.setSexo(form.find('select[name=sexo]').val())
          cand.setEmail(form.find('input[name=email]').val())
          cand.setSenha(form.find('input[name=senha]').val())
          cand.setTelefone(form.find('input[name=phone_1]').val())
          cand.setTelefone(form.find('input[name=phone_2]').val())

          let errors = cand.getErros();

          if(errors.length > 0){
            throw new Error(errors);
          }


        }catch(e){

          BaseController.responseMensage(['msg', 'warning', e.message])

          //cancela a submissao do formulario
          ev.preventDefault();
          ev.stopPropagation();
        }


    })




//-------------final jquery
})


/*------------------------------------BASE CONTROLLER --------------------------------------*/

class BaseController{

  static requestAjax(url, type='GET', dataType = 'HTML', data= null, objRender=null, clearMsg = true){
    if(type == 'POST'){

      $.ajax({
          url: url,
          type: type,
          data: data,
          processData: false,
          contentType: false,
          dataType: dataType,
          success: function(retorno){

            if(dataType == 'json'){

              this.responseMensage(retorno);

            }else if(dataType == 'HTML'){

              if(objRender){
                objRender.html(retorno);
              }
            }

            
            
          }
      })


    }else{

        $.ajax({
        url: url,
        type: type,
        dataType: dataType,
        success: function(retorno){

           if(dataType == 'json'){

              this.responseMensage(retorno);

            }else if(dataType == 'HTML'){

              if(objRender){
                objRender.html(retorno);
              }

            }
        }

      })
    }

  }

  static responseMensage(response){
    if(!response){
      throw new Error('Parâmetro inválido\n');
    }
    let style = response[1];
    let content = response[2];

    $('body').find('#section-response').show();

    let objRsponse = $('body').find('#msg-response');

    let btnClose = $('<button/>').addClass('close').attr('data-dismiss', 'alert').html('&times')

    if(objRsponse.hasClass('col')){
      objRsponse.html('')
      objRsponse.addClass('alert-'+style);
      objRsponse.append(btnClose).append('<h4>'+content+'</h4>');

    }else{

      
     let msg = $('<div/>').addClass('alert alert-'+style+' alert-dismissible fadeshow col');
      msg.append(btnClose).attr('id', 'msg-response')
      msg.attr('align', 'center').append('<h4>'+content+'</h4>');
      
      $('body').find('#section-response').html(msg);
    }
    
  }




}


/*----------------------- CONTROLLER DE CONFIGURAÇÃO DO SITE ---------------------*/
class ConfigController extends BaseController{
    constructor(){

    }

    static abilitarLink(){
      $('body').find('a.desable-link').removeClass('desable-link')
    }

    static navegar(url){
      if(!url){
        throw new Error('Parâmetro inválido\n')
      }

      if(url.trim().length == 0){
        throw new Error('Parâmetro inválido\n')
      }

      let obj = $('body').find('#corpo-principal');

      BaseController.requestAjax(url, 'POST', 'HTML', null, obj, true)

    }

}


/*------------------------------- CONTROLLER DE LOGIN -------------------------------*/

class LoginController extends BaseController{
  constructor(){

  }

  static index(url){
    if((!url) || (url.trim().length == 0)){
      throw new Error('Parâmetro inválido');
    }

    let obj = $('body').find('#container-principal');

    BaseController.requestAjax(url, 'GET', 'HTML',  null, obj, true);
  }

  static logar(form, ev){

    try{
      
      if((!form)){

        throw new Error('Parâmetro inválido');
      }

      let formUser = form.find('#usuario').val();
      let formSenha = form.find('#senha').val();


      let usuario = new User();
      usuario.setSenha(formSenha);
      usuario.setEmail(formUser);

      let errors = usuario.getError();

      if(errors.length > 0){

        let msg = '';

        for (let i = 0; !(i == errors.length); i++) {

          msg += errors[i]+'\n';

        }

        throw new Error(msg);
      }

      return true;

    }catch(e){
      ev.preventDefault();
      ev.stopPropagation();

      BaseController.responseMensage(['msg', 'warning', e.message]);

    }
  }

}


/*----------------------  BASE DAS  MODELS ------------------------------------*/

class BaseModel
{
  constructor(){
    this.errors = [];
  }

  getErros(){
    let warning = '';

    if(this.errors.length > 0){
      for(let i = 0; !(i == this.errors.length) ; i++){
        warning += ' '+this.errors[i]+';';
      }
    }
    warning = warning.substring(0, warning.length - 1)

    return warning;

  }
}



/*------------------- MODEL DE USUARIO -------------------------------*/


class User extends BaseModel
{

  constructor(){

    super();

    this.email;
    this.senha;
    this.error = [];
  }

  setSenha(senha){

    if(!senha){
      this.error.push('Informe sua senha')
    }
    let trimSenha = senha.trim();

    if(trimSenha.length <= 6){
      this.error.push('Senha muito curta');
    }

    this.senha = trimSenha;

  }

  setEmail(email){

    if(!email){
      this.error.push('Informe sua email')
    }
    let trimEmail = email.trim();

    if(trimEmail.length < 0){
      this.error.push('Usuario inválido');
    }

    this.email = trimEmail;

  }


  getSenha(){
    if(!this.senha){
      this.error.push('Senha não definida')
    }else{
      return this.senha;
    }
     
  }

  getEmail(){

    if(!this.email){
      this.error.push('Usuario não definido')
    }else{
      return this.email;
    }


  }

  getError(){
    return this.error;
  }

}







/*---------------------- MODEL DE CANDIDATO ------------------*/

class Candidato extends BaseModel
{
  constructor(){

    super();

    this.nome;
    this.sobrenome;
    this.cpf;
    this.nascimento;
    this.sexo;
    this.email;
    this.senha;
    this.telefone = [];
  }


  setNome(nome){
    if((!nome) || (nome.trim().length < 3) ){
      this.errors.push('Nome inválido ou muito curto\n')
      return false;
    }

    this.nome = nome;
    return true;

  }

  setSobrenome(sobrenome){
    if((!sobrenome) || (sobrenome.trim().length < 3) ){
      this.errors.push('Sobrenome inválido ou muito curto\n')
      return false;
    }

    this.sobrenome = sobrenome;
    return true;

  }

  setCpf(cpf){
    if((!cpf) || (cpf.trim().length < 11) ){
      this.errors.push('Cpf inválido ou muito curto\n')
      return false;
    }

    let result = Utilitarios.validaCpf(cpf);

    if(result == false){
      this.errors.push('Cpf inválido\n')
    }

    this.cpf = cpf;
    return true;

  }


  setDtNascimento(nascimento){
    if((!nascimento) || (nascimento.trim().length == 0) ){
      this.errors.push('Data de nascimento inválida\n')
      return false;
    }

    this.nascimento = nascimento;
    return true;

  }

  setSexo(sexo){
    if((!sexo) || (sexo.trim().length == 0) ){
      this.errors.push('Sexo informado é inválido\n')
      console.log(sexo)
      return false;
    }

    if((sexo != 'm') && (sexo != 'f')){
      this.errors.push('Sexo informado é inválido\n')

      return false;
    }

    this.sexo = sexo;
    return true;

  }

  setEmail(email){
    if((!email) || (email.trim().length == 0) ){
      this.errors.push('E-mail informado é inválido\n')
      return false;
    }

    this.email = email;
    return true;

  }

  setSenha(senha){
    if((!senha) || (senha.trim().length < 6) || (senha.trim().length > 9)){
      this.errors.push('Senha deve ter entre 6 e 9 caracteres\n')
      return false;
    }

    this.senha = senha;
    return true;

  }

  setTelefone(telefone){
    if((!telefone) || (telefone.trim().length != 11)){
      this.errors.push('Telefone deve ter 11 caracteres\n')
      return false;
    }

    if(this.telefone.length == 2){
      this.errors.push('Informe apenas dois números para contato\n')
      return false;
    }

    this.telefone.push(telefone);
    return true;

  }


}

/*--------------------- CLASSE DE METODO UTILITARIOS -------------------------*/

class Utilitarios{

  static validaCpf(cpf){
    cpf = cpf.replace(/[^\d]+/g, '');

        if(cpf.length != 11){

          return false;
        }
        
        let splitCpf = cpf.split('');

        let digitoUm = 0;
        let digitoDois = 0;

        

        for (let i=0, x=1; !(i == 9 ); i++, x ++) { 
             digitoUm += splitCpf[i] * x;
        }

        

        for (let i=0,  y=0; !(i == 10 ); i++, y ++) { 

            let invaliCpf = '';

            for (let j = 0; !(j == 11); j++) {
              invaliCpf += i;
            }

            if(invaliCpf == cpf){
                return false;
            }


            digitoDois += splitCpf[i] * y;
        }

        let calculoUm = ((digitoUm % 11) == 10) ? 0 : (digitoUm % 11);
        let calculoDois = ((digitoDois % 11) == 10) ? 0 : (digitoDois % 11);

        if((calculoUm != splitCpf[9]) || (calculoDois != splitCpf[10])){

            return false;
        }

        return cpf;
  }

  /**
    Formata valores para calculo
  */
  static foramtCalcCod(number){
  

    number = String(number);
    

    if(number.length == 0){
      return false;
    }

    let arrNumber = number.split('.');

    let newNumber = '';
    for (let i =0; !(i == arrNumber.length); i++) {
      newNumber+=arrNumber[i]
    }


    newNumber = newNumber.replace(/,/g, '.');

    newNumber = parseFloat(newNumber).toFixed(2);

    return newNumber;


  }


  static getModal(titulo='Aguarde', body='', footer=''){

    $('.modal-header h4').html(titulo)
    $('.modal-body').html(body);
    $('.modal-footer').html(footer);

  }

  static message(obj, retorno){

    if((retorno.length == 3) &&  (retorno[0] == 'msg')){
      let msg = $('<div/>').addClass('alert alert-'+retorno[1]+' alert-dismissible fadeshow col-md-12');
      msg.append($('<button/>').addClass('close').attr('data-dismiss', 'alert').html('&times'))
      msg.attr('align', 'center').append('<h3>'+retorno[2]+'</h3>');
      msg.css('box-shadow', '2px 2px 3px #000');

      obj.html(msg);
      return true;
    }
    throw new Error('Parâmetro inválido')
  }


}
