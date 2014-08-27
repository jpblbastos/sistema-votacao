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
 * @name      candidato.class.php
 * @version   1.0.0
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright 2014 Copyleft Porto Idéias 
 * @author    Joao Paulo Bastos L. <jpbl.bastos at gmail dot com>
 * @date      15-Ago-2014
 *
 */
     
class CA {
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
     * listar_candidato
     * Lista candidatos
     *
     * @author joao paulo bastos <jpbl.bastos at gmail dot com>
     * @param  string $tipo     [p = presidentes / g = governadores]
     * @param  string $uf       [se informado tipo = g, deve se informar a uf para buscar os governadores]
     * @return string           [html preparado]
     */
    public function listar_candidato ($tipo='', $uf=''){
   	    /* inicializa variavel erro_msg */
    	 $this->erro_msg='';

    	/* inicializa */
        $data= '';
        $this->html= '';

        /* inicializa sql */
        $this->sql='';

        /* prepara sql */
        if ($tipo === "p") {
        	$tipo = 1;
        }elseif ($tipo === "g") {
        	$tipo = 2;
        }else{
        	$this->erro_msg = "OPS, erro em setar o tipo de consulta !";
        	return false;
        }
        if (! empty($uf)) {
           $this->sql="SELECT candidato.idcandidato, candidato.nome, candidato.sobrenome, candidato.face, candidato.idade, candidato.url_foto, cidade.nome, estado.uf, partido.sigla
                            FROM (((eleicao.candidato INNER JOIN eleicao.cidade ON eleicao.candidato.idcidade_cidade = eleicao.cidade.idcidade)
                            INNER JOIN eleicao.estado ON eleicao.cidade.idestado_estado = eleicao.estado.idestado)
                            INNER JOIN eleicao.partido ON eleicao.candidato.idpartido_partido =  eleicao.partido.idpartido)
                            WHERE candidato.idtipo_tipo = ".$tipo." AND eleicao.estado.uf = '".uf."'' ;";
        }else{
           $this->sql="SELECT candidato.idcandidato, candidato.nome, candidato.sobrenome, candidato.face, candidato.idade, candidato.url_foto, cidade.nome, estado.uf, partido.sigla
                            FROM (((eleicao.candidato INNER JOIN eleicao.cidade ON eleicao.candidato.idcidade_cidade = eleicao.cidade.idcidade)
                            INNER JOIN eleicao.estado ON eleicao.cidade.idestado_estado = eleicao.estado.idestado)
                            INNER JOIN eleicao.partido ON eleicao.candidato.idpartido_partido =  eleicao.partido.idpartido)
                            WHERE candidato.idtipo_tipo = ".$tipo." ;";       	
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
        /* percorre consulta realizada e gera html */
        $this->html .= "<div class='lista-candidato'>";
        $this->html .= "<div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 lista'>";
        $this->html .= "   <h3 class='text-muted'>Candidatos a Presidência <i class='fa fa-star fa-fw'></i></h3>";
        $this->html .= "   <div class='row placeholders'>";
        while($data = $this->db->fetch()){
             $this->html .="<div class='col-xs-6 col-sm-3 placeholder'>";
             $this->html .="   <img src='".$data['url_foto']."' class='img-responsive' alt='".utf8_encode($data['nome'])." ".utf8_encode($data['sobrenome'])."'>";
             $this->html .="   <h4>".utf8_encode($data[1])." ".utf8_encode($data[2])."</h4>";
             $this->html .= "  <h4>".$data['sigla']."</h4>";
			 $this->html .="   <div class='caption'>";
             $this->html .="      <br />";
             $this->html .="      <p><a href='#' class='btn btn-primary' role='button' onclick='votar(".$data['idcandidato'].");'>Votar <i class='fa fa-paper-plane fa-fw'></i></a> <a href='".$data['face']."' target='_blank' class='btn btn-default' role='button'>Mais <i class='fa fa-tags fa-fw'></i></a></p>";
             $this->html .="  </div>";
             $this->html .="</div>";
        } 
        $this->html .= "   </div>";
        $this->html .= "</div>";
        $this->html .= "</div>";
        $this->db->close();
        /* Finalizando com o banco */        
        return $this->html;
    }

}

?>