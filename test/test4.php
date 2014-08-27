<?php

include ('../lib/votar.class.php');


//instancia classe 
$votar = new VO ();

$ideleitor=1;

$idcandidato=1;

if ($votar->votar($ideleitor,$idcandidato)){
	echo $votar->html;
}else{
	echo $votar->html;
}
//print_r($data);

?>
