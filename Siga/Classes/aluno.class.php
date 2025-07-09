<?php
require_once ("Usuario.class.php");
require_once ("Database.class.php");


class Aluno extends Usuario{
    private $nomeResponsavel;


    public function __construct($id,$nome,$email,$senha, $matricula, $contato, $nomeResponsavel){
        parent::__construct($id,$nome,$email,$senha, $matricula, $contato);
        $this->setNome($nomeResponsavel);
    }

    public function setLogin(Login $login){
        $this->login = $login;
    }

    public function setId($id){
        if ($id < 0)
            throw new Exception('Erro. O ID deve ser maior ou igual a 0');
        $this->id = $id;
    }

    public function setNome($nomeResponsavel){
        if ($nomeResponsavel == "")
            throw new Exception('Erro. Informe um nomeResponsavel.');
        $this->nomeResponsavel = $nomeResponsavel;
    }

    public function getId(){ return $this->id; }
    public function getNome(){ return $this->nomeResponsavel; }

    public function __toString(): string {
        return "Usuario: " . $this->getId() . " - " . $this->getNome();
    }

    public function inserir():Bool{
        // montar o sql/ query
        $sql = "INSERT INTO usuario 
                    (nome, email, senha, matricula, contato, tipo)
                    VALUES(:nome, :email, :senha, :matricula, :contato, :tipo )";
        
        $parametros = array(':nome'=>$this->getNome(),
                            ':email'=>$this->getEmail(),
                            ':senha'=>$this->getSenha(),
                            ':matricula'=>$this->getMatricula(),
                            ':tipo'=>"Aluno",
                            ':contato'=>$this->getContato());
                            
        
        return Database::executar($sql, $parametros) == true;
    
    }

    public function alterar(): bool {
        $sql = "UPDATE usuario SET nomeResponsavel = :nomeResponsavel WHERE id = :id";
        $parametros = array(
            ':id' => $this->getId(),
            ':nomeResponsavel' => $this->getNome()
        );
        return Database::executar($sql, $parametros) == true;
    }

    public function excluir(): bool {
        $sql = "DELETE FROM usuario WHERE id = :id";
        $parametros = array(':id' => $this->getId());
        return Database::executar($sql, $parametros) == true;
    }
}



?>