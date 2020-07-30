<?php
class Usuario {

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function __construct($deslogin = "", $dessenha = ""){
        $this->deslogin = $deslogin;
        $this->dessenha = $dessenha;
    }

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
            
            $this->setData($row);
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

    public function setData($data){
        $this->setIdusuario($data['idusuario']);
        $this->setDeslogin($data['deslogin']);
        $this->setDessenha($data['dessenha']);
        $this->setDtcadastro(new DateTime($data['dtcadastro']));
    }

    public function login($login, $password){
        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGINN 
            AND dessenha = :SENHA;", array( ":LOGINN"=>$login, ":SENHA"=>$password ));
        if(count($result) > 0) {
            $row = $result[0];
            $this->setData($row);

        } else {
            throw new Exception("Login e/ou senha inválidos!");
        }
    }

    public function insert(){
        $sql = new Sql();

        $result = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PW);;", array(
            ":LOGIN"=>$this->getDeslogin(), ":PW"=>$this->getDessenha()));
        echo count($result);
        if(count($result) > 0){
            $this->setData($result[0]);
        }
    }

    public function update($login, $pw){
        $this->setDeslogin($login);
        $this->setDessenha($pw);

        $sql = new Sql();
        $sql->query("UPDATE tb_usuarios SET deslogin = :LOGINN, dessenha = :PW
            WHERE idusuario = :ID;", array(
                ":LOGINN"=>$this->getDeslogin(), 
                ":PW"=>$this->getDessenha(),
                ":ID"=>$this->getIdusuario()));
    }

    public function delete(){
        $sql = new Sql();
        $sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID;", array(
            ":ID"=>$this->getIdusuario()
        ));
        $this->setIdusuario(NULL);
        $this->setDeslogin(NULL);
        $this->setDessenha(NULL);
        $this->setDtcadastro(NULL);
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