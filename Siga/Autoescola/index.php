<?php
require_once("../Classes/Aula.class.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = isset($_POST['id'])?$_POST['id']:0;
    $instrutor = isset($_POST['instrutor'])?$_POST['instrutor']:"";
    $aluno = isset($_POST['aluno'])?$_POST['aluno']:0;
    $data = isset($_POST['data'])?$_POST['data']:"";
    $hora = isset($_POST['hora'])?$_POST['hora']:0;
    $veiculo = isset($_POST['veiculo'])?$_POST['veiculo']:"";
    $anexo = isset($_POST['anexo'])?$_POST['anexo']:"";
    $acao = isset($_POST['acao'])?$_POST['acao']:"";

    $destino_anexo = 'uploads/'.$_FILES['anexo']['name'];
    move_uploaded_file($_FILES['anexo']['tmp_name'],PATH_UPLOAD.$destino_anexo);
    $aula = new Aula($id,$instrutor,$aluno,$data,$hora,$veiculo,$destino_anexo);
    if ($acao == 'salvar')
        if ($id > 0)
            $resultado = $aula->alterar();
        else
            $resultado = $aula->inserir();
    elseif ($acao == 'excluir')
        $resultado = $aula->excluir();

    if ($resultado)
        header("Location: ./index.php");
    else
        echo "Erro ao salvar dados: ". $aula;
}elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $formulario = file_get_contents('form_cad_aula.html');

    $id = isset($_GET['id'])?$_GET['id']:0;
    $resultado = Aula::listar(1,$id);
    if ($resultado){
        $aula = $resultado[0];
        $formulario = str_replace('{id}',$aula->getId(),$formulario);
        $formulario = str_replace('{instrutor}',$aula->getInstrutor(),$formulario);
        $formulario = str_replace('{aluno}',$aula->getAluno(),$formulario);
        $formulario = str_replace('{data_aula}',$aula->getDtaula(),$formulario);
        $formulario = str_replace('{hora}',$aula->getHora(),$formulario);
        $formulario = str_replace('{veiculo}',$aula->getVeiculo(),$formulario);
        $formulario = str_replace('{anexo}',$aula->getAnexo(),$formulario);
    }else{
        $formulario = str_replace('{id}',0,$formulario);
        $formulario = str_replace('{instrutor}','',$formulario);
        $formulario = str_replace('{aluno}','',$formulario);
        $formulario = str_replace('{data_aula}','',$formulario);
        $formulario = str_replace('{hora}',0,$formulario);
        $formulario = str_replace('{veiculo}','',$formulario);
        $formulario = str_replace('{anexo}','',$formulario);
    }
    print($formulario); 
    include_once('lista_aula.php');
 
}
?>