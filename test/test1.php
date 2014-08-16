<?php

include ('../lib/db.class.php');


//instancia classe do db
$db = new DB ();
if (!$db->open()) {   
    echo $db->erroMsg.'\n';
}

$sql="SELECT from eleitor where cpf='03364734194';";
//$sql = "INSERT INTO eleicao.eleitor VALUES ('','06123422120','Celio','Rosa Orcino','celio.orcino@hotmail.com',977)";

if (!$db->query($sql)) {
    echo $db->erroMsg.'\n';
}

while($data = $db->fetch()){
    //print_r($data);
    echo "===============================\n";
    echo "CPF..: ".stripslashes($data['cpf'])." \n";
    echo "Nome.: ".stripslashes($data['nome'])." \n";
    echo "Email: ".stripslashes($data['email'])." \n";
    echo "===============================\n\n";
} 

//echo 'Total Rows: '.$db->num_rows()."\n";
$db->close(); 


?>
