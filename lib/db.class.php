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
 * @name      db.class.php
 * @version   1.0.0
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright 2014 Copyleft Porto Idéias 
 * @author    Joao Paulo Bastos L. <jpbl.bastos at gmail dot com>
 * @date      15-Ago-2014
 *
 */
     
class DB {
    // propriedades da classe
    
    /**
    * raizDir
    * Diretorio raiz da App
    * @var string
    */
    public $raizDir='';

    /**
    * con
    * Conexao com o db
    * @var object
    */
    public $con;

    /**
    * nomeUser
    * usuario do bando de dados
    * @var string
    */
    private $nomeUser='';

    /**
    * passWd
    * Senha do Usuario do db
    * @var string
    */
    private $passWd='';

    /**
    * nomeDb
    * nome da base e ser selecionada
    * @var string
    */
    private $nomeDb='';

    /**
    * hostCon
    * host da conexão
    * @var string
    */
    private $hostCon='';

    /**
    * erroMsg
    * messagens
    * @var string
    */
    public $erroMsg='';

    /**
    * resultQuery
    * resultado da pesquisa
    * @var array
    */
    public $resultQuery='';

    /**
    * result
    * @var string
    */
    public $result='';

    // Construção dos Metodos 
    /**
    * __construct
    * Método construtor da classe
    * Este método utiliza o arquivo de configuração localizado no diretorio config
    * Este metodo pode estabelecer as configurações a partir do arquivo config.php ou 
    * através de um array passado na instanciação da classe.
    * 
    * @package sv
    * @version 1.0.0
    * @author  joao paulo bastos <jpbl.bastos at gmail dot com>
    * @name    __construct
    * @return  boolean 
    * 
    */
    function __construct( ) {
        //obtem o path da biblioteca
        $this->raizDir = dirname(dirname( __FILE__ )) . DIRECTORY_SEPARATOR;
        //testa a existencia do arquivo de configuração
        if ( is_file($this->raizDir . 'config' . DIRECTORY_SEPARATOR . 'config.php') ){
            //carrega o arquivo de configuração
            include($this->raizDir . 'config' . DIRECTORY_SEPARATOR . 'config.php');
            // carrega propriedades da classe com os dados de configuração
            $this->nomeUser = $nomeUser;
            $this->passWd   = $passWd;
            $this->nomeDb   = $nomeDb;
            $this->hostCon  = $hostCon;
        } else {
            // caso não exista arquivo de configuração retorna erro
            $this->erroMsg = "Não foi localizado o arquivo de configuração :( ";
            return false;
        }
        return true;
    } //fim __construct
  
    /**
    * open
    * Conectar ao banco de dados
    *
    * @package   sv
    * @version   1.0.0
    * @author    joao paulo bastos <jpbl.bastos at gmail dot com>
    * @name      open
    * @return    boolean true sucesso false Erro
    * 
    */
    public function open() {
         /* conecta com o bd com as variáveis prédefinidas */
         $this->con = mysql_connect($this->hostCon, $this->nomeUser, $this->passWd);
         if (!$this->con) {
             $this->erroMsg="OPS, erro em se conectar com o Db :(";
	         return false;
         }
         /* seleciona base de dados */
         if (!mysql_select_db($this->nomeDb)) {
             $this->erroMsg="OPS, erro em selecionar a base de dados :(";
             return false;
         }
	     return true;
    }
     
    /**
    * close
    * Fecha conexao com banco de dados
    *
    * @package   sv
    * @version   1.0.0
    * @author    joao paulo bastos <jpbl.bastos at gmail dot com>
    * @name      close
    * 
    */
    public function close(){
         mysql_close($this->con);
    }
     
    /**
    * query
    * Execulta o sql
    *
    * @package   sv
    * @version   1.0.0
    * @author    joao paulo bastos <jpbl.bastos at gmail dot com>
    * @name      query
    * @param     string  $sql   - Comado a ser execultado no db
    * @return    resultQuery    - Resultado da Pesquisa
    * 
    */ 
    public function query($sql){
        if (!$this->resultQuery = mysql_query($sql)){
           $this->erroMsg="OPS, erro na execulcao do sql: ".$sql.". Verifique a sintaxe :(";
        }
        else{
           return $this->resultQuery;
        } 
    }

    /**
    * fetch
    * Pega proximo dado do array da consulta armazenada em resultQuery
    *
    * @package   sv
    * @version   1.0.0
    * @author    joao paulo bastos <jpbl.bastos at gmail dot com>
    * @name      fetch
    * @return    rows   - Linha da consulta
    * 
    */ 
    public function fetch(){
        $this->result = mysql_fetch_array($this->resultQuery);
        return $this->result;
    } 

    /**
    * num_rows
    * Pega numero de linhas da consulta
    *
    * @package   sv
    * @version   1.0.0
    * @author    joao paulo bastos <jpbl.bastos at gmail dot com>
    * @name      num_rows
    * @return    num_rows  - Quantidade de linhas
    * 
    */ 
    public function num_rows(){
        return mysql_num_rows($this->resultQuery);
    }      

}//fim da classe

?>