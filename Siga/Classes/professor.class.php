<?php
require_once ("Usuario.class.php");
require_once ("Database.class.php");

class Professor extends Usuario{
    private $salario;


    public function __construct($id,$nome,$email,$senha, $matricula, $contato, $salario){
        parent::__construct($id,$nome,$email,$senha, $matricula, $contato);
        $this->setSalario($salario);
    }

    public function setLogin(Login $login){
        $this->login = $login;
    }

    public function setId($id){
        if ($id < 0)
            throw new Exception('Erro. O ID deve ser maior ou igual a 0');
        $this->id = $id;
    }

    public function setSalario($salario){
        if ($salario === "")
            throw new Exception('Erro. Informe um salário.');
        $this->salario = $salario;
    }

    public function getId(){ return $this->id; }
    public function getSalario(){ return $this->salario; }

    public function __toString(): string {
        return "Usuario: " . $this->getId() . " - " . $this->getSalario();
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
                            ':tipo'=>"Professor",
                            ':contato'=>$this->getContato());
                            
        
        return Database::executar($sql, $parametros) == true;
    
    }

    public function alterar(): bool {
        $sql = "UPDATE usuario SET salario = :salario WHERE id = :id";
        $parametros = array(
            ':id' => $this->getId(),
            ':salario' => $this->getSalario()
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
