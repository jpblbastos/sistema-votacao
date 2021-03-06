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
 * @name      votar.php
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
//$data   = '';

/* Carrega biblioteca eleitor */
include ($raizDir . 'lib' . DIRECTORY_SEPARATOR . 'votar.class.php');

/* Recebe consulta e faz tratamento */
if (isset($_GET["idcandidato"])) {
   $idcandidato = $_GET["idcandidato"];
   $ideleitor   = $_GET['ideleitor'];

   //instancia classe 
   $votar = new VO ();
   
   $votar->votar($ideleitor,$idcandidato);
   $return .= $votar->html;
   echo $return;
}else{ 
    echo $return .= "<h3 class='text-muted'>Erro receber variaveis</h3>";
}

?>