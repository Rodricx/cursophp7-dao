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
            $row = $result[0];

            $this->setIdUsuario($row["idusuario"]);
            $this->setDesLogin($row["deslogin"]);
            $this->setDesSenha($row["dessenha"]);
            $this->setDtCadastro(new DateTime($row["dtcadastro"]));
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
            $row = $result[0];

            $this->setIdUsuario($row["idusuario"]);
            $this->setDesLogin($row["deslogin"]);
            $this->setDesSenha($row["dessenha"]);
            $this->setDtCadastro(new DateTime($row["dtcadastro"]));
        } else {
            throw new Exception("Login e/ou senha inválidos");
        }

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