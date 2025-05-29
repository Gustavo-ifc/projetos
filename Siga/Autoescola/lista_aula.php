<?php
    require_once("../Classes/Aula.class.php");
    $busca = isset($_GET['busca'])?$_GET['busca']:0;
    $tipo = isset($_GET['tipo'])?$_GET['tipo']:0;
   
    $lista = Aula::listar($tipo, $busca);
    $itens = '';
    foreach($lista as $aula){
        $item = file_get_contents('itens_listagem_aula.html');
        $item = str_replace('{id}',$aula->getId(),$item);
        $item = str_replace('{instrutor}',$aula->getInstrutor(),$item);
        $item = str_replace('{aluno}',$aula->getAluno(),$item);
        $item = str_replace('{data_aula}',$aula->getDtaula(),$item);
        $item = str_replace('{hora}',$aula->getHora(),$item);
        $item = str_replace('{veiculo}',$aula->getVeiculo(),$item);
        $item = str_replace('{anexo}',$aula->getAnexo(),$item);
        $itens .= $item;
    }
    $listagem = file_get_contents('listagem_aula.html');
    $listagem = str_replace('{itens}',$itens,$listagem);
    print($listagem);
     
?>