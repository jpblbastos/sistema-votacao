<?php
/*testando as funcoes de gravação do txt */
function number_pad($number,$n) {
    return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
}

function string_pad($str ,$n, $char, $position) {
    return str_pad($str,$n,"$char", $position);
}

function cnpj_pad($str ,$n) {
    return str_pad($str,$n,"0",STR_PAD_LEFT);
}
/* teste com os dados do cabecalho
$chave    = '52110902532281000230550010000832591560238959';
$cNF      = 56023895;
$nNF      = 832591;
$dEmi     = '20111003';
$cnpj_cpf = '03364734194';

$chave1    = '52110902532281000230550010000832591560238958';
$cNF1      = 56023898;
$nNF1      = 832598;
$dEmi1     = '20111003';
$cnpj_cpf1 = '02532281000230';

$chave2    = '52110902532281000230550010000832591560238957';
$cNF2      = 56023897;
$nNF2      = 832597;
$dEmi2    = '20111003';
$cnpj_cpf2 = '02532281000310';

echo $chave ."\n";
echo $cNF   ."\n";
echo $nNF   ."\n";
echo $dEmi  ."\n";
echo $cnpj_cpf ."\n\n";

echo "Juntando fica : \n";
$string = number_pad($nNF,9).string_pad($cnpj_cpf,14,0,STR_PAD_LEFT)."$dEmi".number_pad($cNF,8)."$chave\r\n";
$string .= number_pad($nNF1,9).string_pad($cnpj_cpf1,14,0,STR_PAD_LEFT)."$dEmi1".number_pad($cNF1,8)."$chave1\r\n";
$string .= number_pad($nNF2,9).string_pad($cnpj_cpf2,14,0,STR_PAD_LEFT)."$dEmi2".number_pad($cNF2,8)."$chave2\r\n";

echo $string ."\n";
*/

/*
05 TIPO-REG   VALUE SPACES               PIC X.
 96           05 COD-PROD   VALUE SPACES               PIC X(20).
 97           05 QUANTIDADED.
 98              10 QUANTD     VALUE ZEROS             PIC 9(10).
 99           05 PRECO-UNIT VALUE ZEROS                PIC 9(10).
100           05 VALOR-IPI  VALUE ZEROS                PIC 9(10).
*/
$qCom = 2150.0000000000;
$qCom = 100 * number_format($qCom, 2, '.', '');

echo $qCom ."\n";

?>