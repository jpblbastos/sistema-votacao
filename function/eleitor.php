<?php
 /**
 * Este arquivo é parte do projeto sistema de votação - O verdadeiro sistema de pesquisa eleitoral
 *
 * Este programa é um software livre: você pode redistribuir e/ou modificá-lo
 * sob os termos da Licença Pública Geral GNU (GPL)como é publicada pela Fundação
 * para o Software Livre, na versão 3 da licença, ou qualquer versão posterior
 * e/ou 
 * sob os termos da Licença Pública Geral Menor GNU (LGPL) como é publicada pela Fundação
 * para o Software Livre, na versão 3 da licença, ou qualquer versão posterior.
 *  
 * Você deve ter recebido uma cópia da Licença Publica GNU e da 
 * Licença Pública Geral Menor GNU (LGPL) junto com este programa.
 * Caso contrário consulte <http://www.fsfla.org/svnwiki/trad/GPLv3> ou
 * <http://www.fsfla.org/svnwiki/trad/LGPLv3>. 
 *
 * @package   sv
 * @name      eleitor.php
 * @version   1.0.0
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright 2014 Copyleft Porto Idéias 
 * @author    Joao Paulo Bastos L. <jpbl.bastos at gmail dot com>
 * @date      15-Ago-2014
 *
 */

/* Define diretorio da aplicação */
$raizDir = dirname(dirname( __FILE__ )) . DIRECTORY_SEPARATOR;
 
// zera variaveis
$return = '';
$data   = '';

/* Carrega biblioteca eleitor */
include ($raizDir . 'lib' . DIRECTORY_SEPARATOR . 'eleitor.class.php');

/* Recebe consulta e faz tratamento */
if (isset($_GET["modo"])) {
   $modo = $_GET["modo"];

   //instancia classe eleitor
   $eleitor = new EL ();
    
    // trata o modo passado
    if ($modo === "verifica_eleitor") {
        if ($eleitor->verifica_eleitor($_GET["email"])){ // eleitor existe
           //$_SESSION['ideleitor'] = $eleitor->get_dado('ideleitor');
           $return .= "<form class='form-signin' role='form'>";
           $return .= "<input type='hidden' name='ideleitor' id='ideleitor' value='".$eleitor->get_dado('ideleitor')."'>";
           $return .= "<h3 class='text-muted'>Escolha tipo de votação ...</h3>";
      	   $return .= "<p><i class='fa fa-2x fa-pencil-square-o fa-fw'></i></p>";
           $return .= "     <select  id='select_tipo_votacao' name='selectbasic' class='form-control'>";
           $return .= "        <option selected></option>";
           $return .= "        <option value='p'>Presidente</option>";
           //$return .= "        <option value='g'>Governador</option>";
           $return .= "     </select>";
           $return .= "<br/>";
           $return .= "<button class='btn btn-lg btn-primary'  type='button' onclick='lista_candidato();'>Listar Candidatos<i class='fa fa-bars fa-fw'></i></button>";
           echo $return .= "</form>";
        }elseif ($eleitor->erro_cod === 100) { // eleitor não existe
        	   $return .= "<form class='form-signin' role='form'>";
             $return .= "<h3 class='text-muted'>Termine seu cadastro ...</h3>";
      	     $return .= "<p><i class='fa fa-2x fa-pencil-square-o fa-fw'></i></p>";
             $return .= "<div class='input-group margin-bottom-sm'>";
             $return .= "     <span class='input-group-addon'><i class='fa fa-user fa-fw'></i></span>";
             $return .= "     <input class='form-control' name='nome' id='nome' maxlength='60' size='60' type='text'  placeholder='Nome' required autofocus >";
             $return .= "</div>";
             $return .= "<div class='input-group margin-bottom-sm'>";
             $return .= "     <span class='input-group-addon'><i class='fa fa-user fa-fw'></i></span>";
             $return .= "     <input class='form-control' name='sobrenome' id='sobrenome' maxlength='60' size='60' type='text' placeholder='Sobrenome' required>";
             $return .= "</div>";
             $return .= "<div class='input-group margin-bottom-sm'>";
             $return .= "     <span class='input-group-addon'><i class='fa fa-envelope-o fa-fw'></i></span>";
             $return .= "     <input class='form-control' name='email' id='email' maxlength='250' size='60' type='email' value='".$_GET["email"]."'  placeholder='Email' required>";
             $return .= " </div>";
             $return .= " <div class='input-group'>";
             $return .= "     <span class='input-group-addon'><i class='fa  fa-heart-o fa-fw'></i></span>";
             $return .= "     <input class='form-control' name='idade' id='idade' min='16' max=;'121' type='number' placeholder='Idade' required>";
             $return .= " </div>";
             $return .= " <div class='input-group'>";
             $return .= "     <span class='input-group-addon'><i class='fa  fa-flag fa-fw'></i></span>";
             $return .= "     <select  id='select_estado' name='selectbasic' class='form-control'>";
             $return .= "        <option selected>Escolha seu Estado</option>";
             $return .= "        ".$eleitor->busca_estados()."";
             $return .= "     </select>";
             $return .= "     <select  id='select_cidade' name='select_cidade' class='form-control' onFocus='busca_cidades();' '>";
             $return .= "        <option selected>Escolha sua Cidade</option>";
             $return .= "     </select>";
             $return .= " </div>";
             $return .= "<br/>";
             $return .= "<button class='btn btn-lg btn-primary'  type='button' onclick='criar_eleitor();'>Cadastrar <i class='fa fa-check fa-fw'></i></button>";
             echo $return .= "</form>";
        }else{
            echo $return .= "<h3 class='text-muted'>".$eleitor->erro_msg."</h3>";
        }
    }elseif ($modo === "criar_eleitor") {
         if ( (isset($_GET["nome"])) && (isset($_GET["sobrenome"])) && (isset($_GET["email"])) && (isset($_GET["idade"])) && (isset($_GET["idcidade"]))  ) {
            if ($eleitor->cria_eleitor(utf8_decode($_GET["nome"]),utf8_decode($_GET["sobrenome"]),$_GET["email"],$_GET["idade"],$_GET["idcidade"]) ){
               //$_SESSION['ideleitor'] = $eleitor->get_dado('ideleitor');
               $eleitor->verifica_eleitor($_GET["email"]);
               $return .= "<form class='form-signin' role='form'>";
               $return .= "<input type='hidden' name='ideleitor' id='ideleitor' value='".$eleitor->get_dado('ideleitor')."'>";
               $return .= "<h3 class='text-muted'>Escolha tipo de votação ...</h3>";
               $return .= "<p><i class='fa fa-2x fa-pencil-square-o fa-fw'></i></p>";
               $return .= "     <select  id='select_tipo_votacao' name='selectbasic' class='form-control'>";
               $return .= "        <option selected></option>";
               $return .= "        <option value='p'>Presidente</option>";
              // $return .= "        <option value='g'>Governador</option>";
               $return .= "     </select>";
               $return .= "<br/>";
               $return .= "<button class='btn btn-lg btn-primary'  type='button' onclick='lista_candidato();'>Listar Candidatos<i class='fa fa-bars fa-fw'></i></button>";
               echo $return .= "</form>";
            }else{
               echo $return .= "<h3 class='text-muted'>".$eleitor->erro_msg."</h3>";
            }
          }
    }elseif ($modo === "busca_cidades") {
          echo $return .= $eleitor->busca_cidades($_GET["idestado"]);
    }
}else{
    echo $return .= "<h3 class='text-muted'>Erro receber variaveis</h3>";
}
?>