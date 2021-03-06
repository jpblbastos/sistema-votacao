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
 * @name      eleitor.class.php
 * @version   1.0.0
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright 2014 Copyleft Porto Idéias 
 * @author    Joao Paulo Bastos L. <jpbl.bastos at gmail dot com>
 * @date      15-Ago-2014
 *
 */
     
class EL {
    /* Variaveis de definição do eleitor */
    /**
    * ideleitor
    * @var integer
    */
    private $ideleitor=null;

    /**
     * nome
     * @var string 
     */
    private $nome='';

    /**
     * sobrenome
     * @var string 
     */
    private $sobrenome='';

    /**
     * email
     * @var string
     */
    private $email='';

    /**
     * idade
     * @var char(3)
     */
    private $idade='';

    /**
     * idcidade_cidade
     * @var integer 
     */
    private $idcidade_cidade=null;

    /**
     * localidade
     * Define localidade do eleitor
     * @var array
     */
    public $localidade=array('cidade'=>'' , 'estado'=>'','uf'=>'');

    /* Propriedades da classe */

    /**
    * raizDir
    * Diretorio raiz da App
    * @var string
    */
    private $raizDir='';

    /**
     * erro_msg
     * Define menssagens de erros
     * @var string 
     */
    public $erro_msg='';

    /**
     * erro_cod
     * Define códigos de erros
     * @var int 
     */
    public $erro_cod='';

    /**
     * sql
     * Define sql
     * @var string 
     */
    private $sql='';

    /**
     * db
     * Define objeto db
     * @var objeto
     */
    private $db=null;

    // Construção dos Metodos 
    /**
    * __construct
    * Método construtor da classe
    * Este método utiliza o arquivo de configuração localizado no diretorio config
    * Este metodo pode estabelecer as configurações a partir do arquivo config.php ou 
    * através de um array passado na instanciação da classe.
    * 
    * @author  joao paulo bastos <jpbl.bastos at gmail dot com>
    * @return  boolean 
    * 
    */
    function __construct( ) {
        //obtem o path da aplicação
        $this->raizDir = dirname(dirname( __FILE__ )) . DIRECTORY_SEPARATOR;
        //testa a existencia da classe db.class.php
        if ( is_file($this->raizDir . 'lib' . DIRECTORY_SEPARATOR . 'db.class.php') ){
            //carrega a biblioteca
            include($this->raizDir . 'lib' . DIRECTORY_SEPARATOR . 'db.class.php');
            // instancia classe db
            $this->db = new DB();
        } else {
            // caso não localizado retorna erro & sai
            echo "OPS, erro não localizamos a biblioteca do banco de dados. Impossivel prosseguir ! :( ";
            exit();
        }
        return true;
    } //fim __construct

    /**
     * set_dado
     * Seta atributos da classe
     *
     * @author joao paulo bastos <jpbl.bastos at gmail dot com>
     * @param  string $atributo [qual atributo a ser setado ex:nome]
     * @param  string $dado     [string contendo o dado]
     */
    public function set_dado ($atributo='', $dado=''){
    	 /* inicializa variavel erro_msg */
    	 $this->erro_msg='';
    	 /* Testa se foi passado os parametros */
    	 if (empty($atributo)) {
    	 	 $this->erro_msg="OPS, erro não foi informado qual atributo que se deseja setar ! :(";
             return false;
    	 }elseif (empty($dado)) {
    	 	 $this->erro_msg="OPS, erro não foi informado qual é o dado a se inserir ! :(";
             return false;
    	 }
    	 /* Trata atributos */
         switch($atributo){
            case "ideleitor":
                 $this->ideleitor=$dado;
                 break;
             case "nome":
                 $this->nome=$dado;
                 break;
             case "sobrenome":
                 $this->sobrenome=$dado;
                 break;
             case "email":
                 //implementar função teste email
                 $this->email=$dado;
                 break;
             case "idade":
                 if ($dado < 16 ) {
                     $this->erro_msg="OPS, você ainda não pode votar, lamentamos ! :(";
                 }else{
                     $this->idade=$dado;
                 }
                 break;
             case "idcidade_cidade":
                 $this->idcidade_cidade=$dado;
                 $this->busca_localidade(); /* Busca localidade do eleitor */
                 break;
             default:
                 $this->erro_msg="OPS, erro atributo informado desconhecido ! :(";
                 break;
         }
         /* Retorno da função */
         if (empty($this->erro_msg)) {
         	 return true;
         }else{
         	 return false;
         }
    }

    /**
     * get_dado
     * Get atributos da classe
     *
     * @author joao paulo bastos <jpbl.bastos at gmail dot com>
     * @param string $atributo [qual atributo a ser pegado ex:ideleitor]
     * 
     */
    public function get_dado ($atributo=''){
    	 /* inicializa variaveis */
    	 $this->erro_msg='';
    	 /* Testa se foi passado os parametros */
    	 if (empty($atributo)) {
    	 	 $this->erro_msg="OPS, erro não foi informado qual atributo que se deseja buscar ! :(";
             return false;
    	 }
    	 /* Trata atributos */
         switch($atributo){
            case "ideleitor":
                 return $this->ideleitor;
                 break;
             case "nome":
                 return $this->nome;
                 break;
             case "sobrenome":
                 return $this->sobrenome;
                 break;
             case "email":
                 return $this->email;
                 break;
             case "idade":
                 return $this->idade;
                 break;
             case "idcidade_cidade":
                 //implementar função busca cidade
                 return $this->idcidade_cidade;
                 break;
             case "localidade":
                 return $this->localidade;
                 break;
             default:
                 $this->erro_msg="OPS, erro atributo informado desconhecido ! :(";
                 break;
         }
         /* Retorno da função */
         if (empty($this->erro_msg)) {
         	 return true;
         }else{
         	 return false;
         }
    }

    /**
     * verifica_eleitor 
     * Faz a verificação se existe um eleitor, se existe já preenche seus atributos
     *
     * @author joao paulo bastos <jpbl.bastos at gmail dot com>
     * @param  string $email [email a ser consultado]
     * @return boolean       [true se existe / false se não exite ou e caso de falhas]
     */
    public function verifica_eleitor($email=''){
    	/* inicializa sql */
    	$this->sql='';
    	$flag=null;
        /* Verifica se foi passado o parametro */
        if (empty($email)) {
        	$this->erro_msg = "OPS, erro o parametro e-mail não foi informado. Impossivel fazer a consulta ! :(";
        	return false;
        }
        /* prepara sql */
        $this->sql="SELECT ideleitor FROM eleicao.eleitor WHERE eleitor.email = '".$email."';";
        /* Trabalhando com a base de dados */
        if (!$this->db->open()) {   
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        if (! $this->db->query($this->sql)) {
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        $flag = $this->db->num_rows();
        if ($flag === 1) {
            $flag=null;
            $flag=$this->db->fetch();
            $this->set_dado('ideleitor', $flag['ideleitor']);
            $this->db->close();
            /* Busca os dados */
            if ($this->consulta_eleitor())
        	   return true;
            else
               return false; 
        }else{
            $this->erro_msg = "OPS, o e-mail ".$email.", não exite na base de dados ! :(";
            $this->erro_cod = 100 ; // eleitor não existe
            $this->db->close();
        	return false;
        }
        /* Finalizando com o banco */
    }

    /**
     * busca_localidade 
     * Busca a localidade do eleitor , cidade / estado / uf
     * @return [type] [description]
     */
    private function busca_localidade(){
        /* inicializa sql */
        $this->sql='';
        $data='';  /* Armezena resultado consulta */

        $this->sql="SELECT cidade.nome, estado.nome, estado.uf 
                     FROM cidade INNER JOIN estado ON cidade.idestado_estado = estado.idestado
                     WHERE cidade.idcidade = ".$this->get_dado('idcidade_cidade').";";
        /* Trabalhando com a base de dados */
        if (! $this->db->query($this->sql)) {
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        /* Pega consulta e faz o armazenamento */
        $data = $this->db->fetch();
        $this->localidade['cidade']=$data[0];
        $this->localidade['estado']=$data[1];
        $this->localidade['uf']=$data[2];
        /* Finalizando com o banco */   
            
    }

    /**
     * busca_estados
     * Busca todos estados estado e monta html
     * @return  array contendo o sql
     */
    public function busca_estados(){
        /* inicializa */
        $data    = '';
        $return  = '';

        /* inicializa sql */
        $this->sql='';

        /* prepara sql */
        $this->sql="SELECT estado.idestado, estado.nome FROM eleicao.estado;";
        /* Trabalhando com a base de dados */
        if (!$this->db->open()) {   
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        if (! $this->db->query($this->sql)) {
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        while ($data = $this->db->fetch()){
              $return .= "<option value='".$data['idestado']."'>".utf8_encode($data['nome'])."</option>";
        } 
        $this->db->close();
        /* Finalizando com o banco */        
        return $return;
    }

    /**
     * busca_cidade
     * Busca todos cidades estado e monta html
     *
     * @param   int idestado - filtrar por estado
     * @return  array contendo o sql
     */
    public function busca_cidades($idestado=null){
        /* inicializa */
        $data    = '';
        $return  = '';

        /* inicializa sql */
        $this->sql='';

        if (empty($idestado)) {
           $this->sql = "SELECT cidade.idcidade, cidade.nome FROM eleicao.cidade;";
        }else{
           $this->sql="SELECT cidade.idcidade, cidade.nome FROM eleicao.cidade WHERE cidade.idestado_estado = ".$idestado.";";
        }

        /* Trabalhando com a base de dados */
        if (!$this->db->open()) {   
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        if (! $this->db->query($this->sql)) {
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        while ($data = $this->db->fetch()){
              $return .= "<option value='".$data['idcidade']."'>".utf8_encode($data['nome'])."</option>";
        } 
        $this->db->close();
        /* Finalizando com o banco */        
        return $return;
    }

    /**
     * cria_eleitor 
     * Cria um novo eleitor
     *
     * @author João Paulo Bastos <jpbl.bastos at gmail dot com>
     * @param  string   $nome   
     * @param  string   $sobrenome
     * @param  string   $email  
     * @param  string   $idade  
     * @param  string   $idcidade 
     * @return boolean  true / false       
     */
    public function cria_eleitor($nome='', $sobrenome='', $email='', $idade='', $idcidade=''){
        /* Verifica passagem de parametros */
        if ( (empty($nome)) || (empty($sobrenome)) || (empty($email)) || (empty($idade)) || (empty($idcidade)) ) {
           $this->erro_msg = "OPS, erro falta de parametros para se criar um novo eleitor ! :0";
           return false;
        }
        /* inicializa sql */
        $this->sql='';
        /* prepara sql */
        $this->sql="INSERT INTO eleicao.eleitor VALUES ('','".$email."','".$nome."','".$sobrenome."', '".$idade."',".$idcidade.");";
        /* Trabalhando com a base de dados */
        if (!$this->db->open()) {   
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        if ($this->db->query($this->sql)) {
           $this->db->close();
           return true;
        }else{
           $this->erro_msg = $this->db->erroMsg;
           $this->db->close();
           return false;
        }
    }

    /**
     * update_eleitor 
     * Atualiza o eleitor de acordo com o atributo desejado
     * 
     * @param  string $atributo [atributo que se deseja atualizar]
     * @param  string $dado     [Dado que se deseja atualizar]
     * @return boolean          [true / false]
     */
    public function update_eleitor ($atributo='', $dado=''){
        /* Verifica passagem de parametros */
        if ( (empty($atributo)) || (empty($dado)) ) {
           $this->erro_msg = "OPS, erro falta de parametros para se atualizar o eleitor ! :0";
           return false;
        }
        /* inicializa sql */
        $this->sql='';
        /* prepara sql */
        if ($atributo == 'idcidade_cidade') // trata criação do sql
           $this->sql="UPDATE eleicao.eleitor SET ".$atributo." = ".$dado." WHERE eleitor.ideleitor = '".$this->get_dado('ideleitor')."' ;";
        else
          $this->sql="UPDATE eleicao.eleitor SET ".$atributo." = '".$dado."' WHERE eleitor.ideleitor = '".$this->get_dado('ideleitor')."' ;";
        /* Trabalhando com a base de dados */
        if (!$this->db->open()) {   
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        if ($this->db->query($this->sql)) {
           $this->db->close();
           return true;
        }else{
           $this->erro_msg = $this->db->erroMsg;
           $this->db->close();
           return false;
        }    
    }

    /**
     * consulta_eleitor
     * Consulta todos dados eleitor 
     *
     * @author João Paulo Bastos <jpbl.bastos at gmail dot com>
     * @return boolean     [status da consulta]
     */
    private function consulta_eleitor(){
        /* inicializa sql */
        $this->sql='';
        $colun=''; /* Contém o nome da coluna */
        $data='';  /* Armazena a linha consultada */

        /* prepara sql */
        $this->sql="SELECT nome, sobrenome, email, idade, idcidade_cidade FROM eleicao.eleitor WHERE eleitor.ideleitor = '".$this->get_dado('ideleitor')."';";
        /* Trabalhando com a base de dados */
        if (!$this->db->open()) {   
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        if (! $this->db->query($this->sql)) {
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        /* Recebe matriz de dados e percorre preenchendo os atributos da classe */
        $data = $this->db->fetch();
        $i=0;
        while ($i < $this->db->num_fields()){
              $colun=$this->db->fetch_field($i);
              $this->set_dado($colun->name,$data[$colun->name] );
              $i++;
        }
        $this->db->close();
        /* Finalizando com o banco */
        return true;
    }

} // fim da classe
?>