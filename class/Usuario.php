<?php
class Usuario {

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getIdusuario(){ 
        return $this->idusuario;
    }
    public function setIdusuario(
        $idusuario) {$this->idusuario = $idusuario;
    }
    public function getDeslogin(){
        return $this->deslogin;
    }
    public function setDeslogin($deslogin){
        $this->deslogin = $deslogin;
    }
    public function getDessenha(){
        return $this->dessenha;
    }
    public function setDessenha($dessenha){
        $this->dessenha = $dessenha;
    }
	public function getDtcadastro(){
		return $this->dtcadastro;
	}
	public function setDtcadastro($dtcadastro){
		$this->dtcadastro = $dtcadastro;
    }
    
    public function loadById($id){
        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
            ":ID"=>$id
        ));

        if(count($result) > 0) {
            $row = $result[0];

            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDtcadastro(new DateTime($row['dtcadastro']));
        }
    }

    public static function getAll(){
        $sql = new Sql();
        return  json_encode(
            $sql->select("SELECT * FROM tb_usuarios ORDER BY idusuario;")
        );
    }

    public static function search($login){
        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuarios 
            WHERE deslogin LIKE :SEARCH ORDER BY deslogin;", array(":SEARCH"=>"%$login%"));
        return json_encode($result);
    }

    public function login($login, $password){
        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGINN 
            AND dessenha = :SENHA;", array( ":LOGINN"=>$login, ":SENHA"=>$password ));
        if(count($result) > 0) {
            $row = $result[0];

            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDtcadastro(new DateTime($row['dtcadastro']));
        } else {
            throw new Exception("Login e/ou senha inválidos!");
        }
    }

    public function __toString(){
        return json_encode(array(
            "idusuario"=>$this->getIdusuario(),
            "deslogin"=>$this->getDeslogin(),
            "dessenha"=>$this->getDessenha(),
            "dtcadastro"=>$this->getDtcadastro()->format("d-m-Y, H:m")
        ));
    }
}