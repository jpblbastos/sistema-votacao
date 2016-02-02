<?php

include ('../lib/db.class.php');


//instancia classe do db
$db = new DB ();

if (!$db->open()) {   
    echo $db->erroMsg.'\n';
}

$sql="SELECT COUNT(*), candidato.nome, candidato.sobrenome, partido.sigla, parametro.status
     FROM (((eleicao.votacao INNER JOIN  eleicao.candidato ON votacao.idcandidato_candidato = candidato.idcandidato)
     INNER JOIN eleicao.partido ON candidato.idpartido_partido =  partido.idpartido)
     INNER JOIN eleicao.parametro ON votacao.idparametro_parametro = parametro.idparametro)
     WHERE parametro.idtipo_tipo = 1
     GROUP BY candidato.nome;";
//$sql = "INSERT INTO eleicao.eleitor VALUES ('','06123422120','Celio','Rosa Orcino','celio.orcino@hotmail.com',977)";

if (!$db->query($sql)) {
    echo $db->erroMsg.'\n';
}

//echo "Numero linhas: ".$db->num_rows()." \n";

//$data = $db->fetch();
//$return = '';

//print_r($data);

//echo $data['0'];
//echo $data['1'];
//echo $data['2'];

while($data = $db->fetch()){
	print_r($data);
    //$return .= "<option value='".$data['idestado']."'>".utf8_encode($data['nome'])."</option>";
    //echo "Nome.: ".stripslashes($data['nome'])." \n";
    //echo "Email: ".stripslashes($data['email'])." \n";
    //echo "===============================\n\n";
    //$i++;
} 

//echo 'Total Rows: '.$db->num_rows()."\n";
$db->close(); 

//print_r($return);


?>
