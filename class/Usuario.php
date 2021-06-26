<?php

class Usuario {

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getIdUsuario(){
        return $this->idusuario;
    }

    public function setIdUsuario($value){
        $this->idusuario = $value;
    }

    public function getDesLogin(){
        return $this->deslogin;
    }

    public function setDeslogin($value){
        $this->deslogin = $value;
    }

    public function getDesSenha(){
        return $this->dessenha;
    }

    public function setDesSenha($value){
        $this->dessenha = $value;
    }

    public function getDtCadastro(){
        return $this->dtcadastro;
    }

    public function setDtCadastro($value){
        $this->dtcadastro = $value;
    }

    public function loadById($id){

        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuario WHERE idusuario = :ID", Array(
            ":ID"=>$id
        ));

        if(count($result[0]) > 0){

            $this->setData($result[0]);

        }

    }

    public static function getList(){
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuario ORDER BY deslogin");
    }

    public static function search($login){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuario WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            "SEARCH"=>"%".$login."%"
        ));
    }

    public function login($login, $password){

        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuario WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", Array(
            ":LOGIN"=>$login,
            ":PASSWORD"=>$password
        ));

        if(count($result[0]) > 0){
            
            $this->setData($result[0]);
            
        } else {
            throw new Exception("Login e/ou senha inválidos");
        }

    }

    public function setData($d){

        $this->setIdUsuario($d["idusuario"]);
        $this->setDesLogin($d["deslogin"]);
        $this->setDesSenha($d["dessenha"]);
        $this->setDtCadastro(new DateTime($d["dtcadastro"]));

    }

    public function insert(){
        $sql = new Sql();

        $result = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
            ':LOGIN' => $this->getDesLogin(),
            ':PASSWORD' => $this->getDesSenha()
        ));

        if(count($result) > 0){
            $this->setData($result[0]);
        }
    }

    public function update($login, $senha){

        $sql = new Sql();

        $sql->query("UPDATE tb_usuario SET deslogin = :LO, dessenha = :SENHA WHERE idusuario = :ID", array("LO" => $login, ":SENHA" => $senha, ":ID" => $this->getIdUsuario()));

        /*
        $this->setId(0);
        $this->setNome("");
        $this->setSobrenome("");
        $this->setDtCadastro(new Datetime("d/m/Y H:i:s"));
        */

    }

    public function delete(){

        $sql = new Sql();

        $sql->query("DELETE FROM tb_usuario WHERE idusuario = :ID", array(":ID" => $this->getIdUsuario()));

        $this->setIdUsuario(0);
        $this->setDeslogin("");
        $this->setDesSenha("");
        //$this->setDtCadastro(new Datetime("d/m/Y H:i:s"));
    }

    public function __construct($login = "", $password = ""){

        $this->setDeslogin($login);
        $this->setDesSenha($password);
    }

    public function __toString(){

        return json_encode(array(
            "idusuario"=>$this->getIdUsuario(),
            "deslogin"=>$this->getDesLogin(),
            "dessenha"=>$this->getDesSenha(),
            "dtcadastro"=>$this->getDtCadastro()->format("d/m/Y H:i:s")
        ));

    }
}

?>