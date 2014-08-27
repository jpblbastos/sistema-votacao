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
 * @name      votar.class.php
 * @version   1.0.0
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright 2014 Copyleft Porto Idéias 
 * @author    Joao Paulo Bastos L. <jpbl.bastos at gmail dot com>
 * @date      15-Ago-2014
 *
 */
     
class VO {
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

    /**
     * html
     * Define retorno de html
     * @var  string
     */
    public $html='';

    /**
     * idparametro
     * Define o id do parametro a ser usado 
     * OBS.: parametro é uma tabela on se cria varia eleições, possibilitando cada votação ser única por eleição
     * @var  int
     */
    private $idparametro=2;

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
     * votar
     * Faz a votação
     *
     * @author  joao paulo bastos <jpbl.bastos at gmail dot com>
     * @param  int $ideleitor   - defin o eleitor 
     * @param  int $idcandidato - define o candidato escolhido
     * @return boolean
     */
    public function votar($ideleitor=null, $idcandidato=null){
         /* inicializa variavel */
         $this->erro_msg='';
         $this->html='';
           
         /* inicializa sql */
         $this->sql='';
       
        /* Trabalhando com a base de dados */
        if (!$this->db->open()) {   
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        
        if (!$this->verifica_se_pode($ideleitor)){
            $this->sql = "INSERT INTO eleicao.votacao(ideleitor_eleitor, idparametro_parametro,idcandidato_candidato) 
                               VALUES (".$ideleitor.",".$this->idparametro.",".$idcandidato.");";
            if ($this->db->query($this->sql)) {
               $this->html .= "<div class='jumbotron' id='box'>";
               $this->html .= "<form class='form-signin' role='form' >";
               $this->html .= "   <h3 class='text-muted'> Obrigado seu voto foi registrado :)</h3>";
               $this->html .= "<br/>";
               $this->html .= "<a class='btn btn-lg btn-primary' href='../pesquisa/' role='button'>Veja á Corrida <i class='fa fa-rocket fa-fw'></i></a>";
               $this->html .= "</form>";
               $this->html .= "</div> <!-- /jumbotron -->";
               return true;
            }else{
               $this->erro_msg = $this->db->erroMsg;
               return false; 
            }                   
        }else{
            $this->html .= "<div class='jumbotron' id='box'>";
            $this->html .= "<form class='form-signin' role='form' >";
            $this->html .= "   <h3 class='text-muted'> Desculpe mas você ja deixou seu voto nessa pesquisa :(</h3>";
            $this->html .= "   <h3 class='text-muted'> Entre na próxima !</h3>";    
            $this->html .= "<br/>";
            $this->html .= "<a class='btn btn-lg btn-primary' href='../pesquisa/' role='button'>Veja á Corrida <i class='fa fa-rocket fa-fw'></i></a>";
            $this->html .= "</form>";
            $this->html .= "</div> <!-- /jumbotron -->";
            return false;
        }        

        $this->db->close();
        /* Finalizando com o banco */        
    }

    /**
     * verifica_se_pode 
     * Verifica se eleitor ja votou na eleição corrente 
     *
     * @author  joao paulo bastos <jpbl.bastos at gmail dot com>
     * @param  int $ideleitor 
     * @return boolean
     */
    private function verifica_se_pode($ideleitor){
        /* inicializa sql */
        $this->sql='';

        $this->sql = "SELECT votacao.ideleitor_eleitor FROM eleicao.votacao WHERE votacao.ideleitor_eleitor = ".$ideleitor." AND votacao.idparametro_parametro = ".$this->idparametro." ; ";

        if (! $this->db->query($this->sql)) {
           $this->erro_msg = $this->db->erroMsg;
           return false;
        }
        if ($this->db->num_rows() > 0) { // ja vottou
            return true;
        }else { // não votou
            return false; 
        }
  
    }
}
?>