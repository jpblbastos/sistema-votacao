/**
  * Função para criar um objeto XMLHTTPRequest
  */
function CriaRequest(){
	try{
		request = new XMLHttpRequest();
	} catch (IEAtual) {
		try{
			request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (IEAntigo) {
			try{
				request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (falha){
				request = false;
			}
		}
	}

	if (!request)
		alert("Seu navegador nao suporta ajax !");
	else
		return request;
}


/**
 * votar
 * Faz votação
 */
function votar(idcandidato){
    var result = document.getElementById("box-geral");
    var ideleitor   = document.getElementById("ideleitor").value;
    var xmlreq = CriaRequest();

    // Iniciar uma requisicao
    //alert("eleitor.php?cpf=" + cpf+"&modo=verifica_eleitor");
  xmlreq.open("GET", "../function/votar.php?idcandidato=" + idcandidato + "&ideleitor=" + ideleitor, true);

  // Atribui uma funcao para ser execultada sempre que houver uma mudanca de ado
  xmlreq.onreadystatechange = function() {
    // Verifica se foi concluido com sucesso e a conexao fechada (readyState=4)
    if (xmlreq.readyState == 4 ) {
           // verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
               result.innerHTML = xmlreq.responseText;
            }else{
               result.innerHTML = xmlreq.statusText +  xmlreq.status;
            }
    }
  };
  xmlreq.send(null);
}

/**
 * lista_candidato
 */
function lista_candidato(){
   var tp_votacao  = document.getElementById("select_tipo_votacao").value;
   var ideleitor   = document.getElementById("ideleitor").value;

   if (tp_votacao == "") {
      alert("Selecione um tipo para votar !")
      return false;
   }
   var result = document.getElementById("box-geral");
   var xmlreq = CriaRequest();
   
  // Iniciar uma requisicao
  xmlreq.open("GET", "../function/candidato.php?modo=listar_candidato&tipo=" + tp_votacao + "&ideleitor=" + ideleitor, true);

  // Atribui uma funcao para ser execultada sempre que houver uma mudanca de ado
  xmlreq.onreadystatechange = function() {
    // Verifica se foi concluido com sucesso e a conexao fechada (readyState=4)
    if (xmlreq.readyState == 4 ) {
           // verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
               result.innerHTML = xmlreq.responseText;
            }else{
               result.innerHTML = xmlreq.statusText +  xmlreq.status;
            }
    }
  };
  xmlreq.send(null);
   
}

/**
 * busca_cidades
 */
function busca_cidades(){
  var idestado  = document.getElementById("select_estado").value;
  var result    = document.getElementById("select_cidade");
  var xmlreq    = CriaRequest();

  // Iniciar uma requisicao
  //alert("eleitor.php?cpf=" + cpf+"&modo=verifica_eleitor");
  xmlreq.open("GET", "../function/eleitor.php?modo=busca_cidades&idestado=" + idestado, true);

  // Atribui uma funcao para ser execultada sempre que houver uma mudanca de ado
  xmlreq.onreadystatechange = function() {
    // Verifica se foi concluido com sucesso e a conexao fechada (readyState=4)
    if (xmlreq.readyState == 4 ) {
           // verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
               result.innerHTML = xmlreq.responseText;
            }else{
               result.innerHTML = xmlreq.statusText +  xmlreq.status;
            }
    }
  };
  xmlreq.send(null);
}

/**
 * criar_eleitor
 * Cria um novo eleitor
 */
function criar_eleitor(){
    var cpf       = document.getElementById("cpf").value;
    var nome      = document.getElementById("nome").value; 
    var sobrenome = document.getElementById("sobrenome").value;
    var email     = document.getElementById("email").value;
    var idade     = document.getElementById("idade").value;
    var idcidade  = document.getElementById("select_cidade").value;
    
    // faz validações
    // valida cpf
	if (! valida_cpf(cpf)){
		alert("Cpf informado invalido !");
		return false;
	}
    //valida nome e sobre nome
    if (! valida_nome(nome)) {
       alert("Nome não informado ou invalido !");
	   return false;  
    }
    if (! valida_nome(sobrenome)) {
       alert("Sobre nome não informado ou invalido !");
	   return false;  
    }
    //valida email
    if (! valida_email(email)) {
       alert("Email não informado ou invalido !");
	   return false;  
    }

    //valida idade
    if (! valida_idade(idade)) {
       alert("Idade não informado ou invalida !");
	   return false;  	
    }

    var result    = document.getElementById("box");
    var xmlreq    = CriaRequest();

    // Iniciar uma requisicao
    //alert("../function/eleitor.php?modo=criar_eleitor&cpf=" + cpf + "&nome=" + nome + "&sobrenome=" + sobrenome + "&email=" + email + "&idade=" + idade + "&idcidade=" + idcidade);
	xmlreq.open("GET", "../function/eleitor.php?modo=criar_eleitor&cpf=" + cpf + "&nome=" + nome + "&sobrenome=" + sobrenome + "&email=" + email + "&idade=" + idade + "&idcidade=" + idcidade, true);

	// Atribui uma funcao para ser execultada sempre que houver uma mudanca de ado
	xmlreq.onreadystatechange = function() {
		// Verifica se foi concluido com sucesso e a conexao fechada (readyState=4)
		if (xmlreq.readyState == 4 ) {
           // verifica se o arquivo foi encontrado com sucesso
           if (xmlreq.status == 200) {
              result.innerHTML = xmlreq.responseText;
           }else{
              result.innerHTML = xmlreq.statusText +  xmlreq.status;
           }
		}
	};
	xmlreq.send(null);    
}

/**
 * verifica_eleitor 
 * Verifica se existe eleitor e retorna os dados
 */
function verifica_eleitor(){
	// Declaração das variaveis
	var cpf    = document.getElementById("cpf").value;

    // valida cpf
	if (! valida_cpf(cpf)){
		alert("Cpf informado invalido !");
		return false;
	}
    var result = document.getElementById("box");
    var xmlreq = CriaRequest();

    // Iniciar uma requisicao
    //alert("eleitor.php?cpf=" + cpf+"&modo=verifica_eleitor");
	xmlreq.open("GET", "../function/eleitor.php?modo=verifica_eleitor&cpf=" + cpf, true);

	// Atribui uma funcao para ser execultada sempre que houver uma mudanca de ado
	xmlreq.onreadystatechange = function() {
		// Verifica se foi concluido com sucesso e a conexao fechada (readyState=4)
		if (xmlreq.readyState == 4 ) {
           // verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
               result.innerHTML = xmlreq.responseText;
            }else{
               result.innerHTML = xmlreq.statusText +  xmlreq.status;
            }
		}
	};
	xmlreq.send(null);
}

/**
 * Validar cpf
 */
function valida_cpf(cpf){
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;
    if (cpf.length < 11)
        return false;
    for (i = 0; i < cpf.length - 1; i++)
          if (cpf.charAt(i) != cpf.charAt(i + 1))
                {
                digitos_iguais = 0;
                break;
                }
    if (!digitos_iguais)
          {
          numeros = cpf.substring(0,9);
          digitos = cpf.substring(9);
          soma = 0;
          for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(0))
              return false;
          numeros = cpf.substring(0,10);
          soma = 0;
          for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(1))
                return false;
          return true;
          }
    else
        return false;
  }

/**
 * Validar nome  e  sobrenome
 */
function valida_nome(nome){
   if (nome == "") {
      return false;
   }else{
   	  return true;
   }
}

/**
 * Validar email
 */
function valida_email(email){
   var filtro_mail = /^.+@.+\..{2,3}$/
   if (!filtro_mail.test(email) || email=="") {
      return false;
   }else{
      return true;
   }
}

/**
 * verifica se e numero
 */
function IsNum(v){
   var ValidChars = "0123456789";
   var IsNumber=true;
   var Char;

   for (i = 0; i < v.length && IsNumber == true; i++) 
      { 
      Char = v.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
}

function valida_idade(idade){
	if (idade == "" || ! IsNum(idade) || idade < 16) 
       return false;
    else
       return true;
}