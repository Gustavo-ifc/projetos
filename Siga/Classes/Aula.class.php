<?php
require_once("Database.class.php");
class Aula
{
    private $id;
    private $instrutor;
    private $aluno;
    private $dtaula;
    private $hora;
    private $veiculo;
    private $anexo;

    // construtor da classe
    public function __construct($id, $instrutor, $aluno, $dtaula, $hora, $veiculo, $anexo)
    {
        $this->id = $id;
        $this->instrutor = $instrutor;
        $this->aluno = $aluno;
        $this->dtaula = $dtaula;
        $this->hora = $hora;
        $this->veiculo = $veiculo;
        $this->anexo = $anexo;
    }

    // função / interface para aterar e ler
    public function setInstrutor($instrutor)
    {
        if ($instrutor == "")
            throw new Exception("Erro, o instrutor deve ser informado!");
        else
            $this->instrutor = $instrutor;
    }

    public function setAluno($aluno)
    {
        if ($aluno = "")
            throw new Exception("Erro, o aluno deve ser informada!");
        else
            $this->aluno = $aluno;
    }

    // cada atributo tem um método set para alterar seu valor
    public function setId($id)
    {
        if ($id < 0)
            throw new Exception("Erro, a ID deve ser maior que 0!");
        else
            $this->id = $id;
    }

    public function setDtaula($dtaula)
    {
        if ($dtaula == "")
            throw new Exception("Erro, a data deve ser informada!");
        else
            $this->dtaula = $dtaula;
    }

    public function setHora($hora)
    {
        if ($hora < 0)
            throw new Exception("Erro, a quantidade deve ser informada!");
        else
            $this->hora = $hora;
    }

    public function setVeiculo($veiculo)
    {
        if ($veiculo == " ")
            throw new Exception("Erro, a data deve ser informada!");
        else
            $this->veiculo = $veiculo;
    }

    // Anexo pode ser em branco por isso o parâmetro é opcional
    public function setAnexo($anexo = '')
    {
        $this->anexo = $anexo;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInstrutor(): String
    {
        return $this->instrutor ?? '';
    }

    public function getAluno(): String
    {
        return $this->aluno ?? '';
    }

    public function getDtaula(): string
    {
        return $this->dtaula ?? '';
    }

    public function getVeiculo(): string
    {
        return $this->veiculo ?? '';
    }

    public function getHora(): String
    {

        return $this->hora ?? 0;
    }

    public function getAnexo(): String
    {
        return $this->anexo;
    }

    // método mágico para imprimir uma atividade
    public function __toString(): String
    {
        $str = "aula: {$this->id} 
                -instrutor: {$this->instrutor}
                 - aluno: {$this->aluno}
                 - data_aula: {$this->dtaula}
                 - hora: {$this->hora}
                 - veiculo: {$this->veiculo}
                 - arquivo: {$this->anexo}
                 ";
        return $str;
    }

    // insere uma atividade no banco 
    public function inserir(): Bool
    {
        // montar o sql/ query
        $sql = "INSERT INTO aula
                    (instrutor, aluno, data_aula, hora, veiculo, arquivo)
                    VALUES(:instrutor, :aluno, :data_aula, :hora, :veiculo, :arquivo)";

        $parametros = array(
            ':instrutor' => $this->getInstrutor(),
            ':aluno' => $this->getAluno(),
            ':data_aula' => $this->getDtaula(),
            ':hora' => $this->getHora(),
            ':veiculo' => $this->getVeiculo(),
            ':arquivo' => $this->getAnexo()
        );

        return Database::executar($sql, $parametros) == true;
    }

    public static function listar($tipo = 0, $info = ''): array
    {
        $sql = "SELECT * FROM aula";
        switch ($tipo) {
            case 0:
                break;
            case 1:
                $sql .= " WHERE id = :info ORDER BY id";
                break; // filtro por ID
            case 2:
                $sql .= " WHERE instrutor Like :info ORDER BY instrutor;";
                $info = '%' . $info . '%';
                break;
            case 3:
                $sql .= " WHERE aluno Like :info ORDER BY aluno;";
                $info = '%' . $info . '%';
                break;
            case 4:
                $sql .= " WHERE data_aula Like :info ORDER BY data_aula;";
                $info = '%' . $info . '%';
                break;
            case 5:
                $sql .= " WHERE hora Like :info ORDER BY hora;";
                $info = '%' . $info . '%';
                break;
            case 6:
                $sql .= " WHERE veiculo Like :info ORDER BY veiculo;";
                $info = '%' . $info . '%';
                break;
        }
        $parametros = array();
        if ($tipo > 0)
            $parametros = [':info' => $info];

        $comando = Database::executar($sql, $parametros);
        //$resultado = $comando->fetchAll();
        $aulas = [];
        while ($registro = $comando->fetch()) {
            $aula = new Aula($registro['id'], $registro['instrutor'], $registro['aluno'], $registro['data_aula'], $registro['hora'], $registro['veiculo'], $registro['arquivo']);
            array_push($aulas, $aula);
        }
        return $aulas;
    }

    public function alterar(): Bool
    {
        $sql = "UPDATE aula
                  SET instrutor = :instrutor,
                        aluno = :aluno, 
                        data_aula = :data_aula,
                        hora = :hora,
                        veiculo = :veiculo,
                        arquivo = :anexo
                WHERE id = :id";
        $parametros = array(
            ':id' => $this->getid(),
            ':instrutor' => $this->getInstrutor(),
            ':aluno' => $this->getAluno(),
            ':data_aula' => $this->getDtaula(),
            ':hora' => $this->getHora(),
            ':veiculo' => $this->getVeiculo(),
            ':anexo' => $this->getAnexo()
        );
        return Database::executar($sql, $parametros) == true;
    }

    public function excluir(): Bool
    {
        $sql = "DELETE FROM aula
                      WHERE id = :id";
        $parametros = array(':id' => $this->getid());
        return Database::executar($sql, $parametros) == true;
    }
}
