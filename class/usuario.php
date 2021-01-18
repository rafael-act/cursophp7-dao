<?php

class Usuario
{
    private $idUsuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    //getters and setters
    public function getIdusuario()
    {
        return $this->idUsuario;
    }

    public function setIdusuario($value)
    {
        return $this->idUsuario = $value;
    }

    public function getdeslogin()
    {
        return $this->deslogin;
    }

    public function setdeslogin($value)
    {
        return $this->deslogin = $value;
    }

    public function getdessenha()
    {
        return $this->dessenha;
    }

    public function setdessenha($value)
    {
        return $this->dessenha = $value;
    }

    public function getdtcadastro()
    {
        return $this->dtcadastro;
    }

    public function setdtcadastro($value)
    {
        return $this->dtcadastro = $value;
    }
    //-!getters and setters

    public function __toString()
    {
        return json_encode(array(
            "idusuario"=>$this->getIdusuario(),
            "deslogin"=>$this->getdeslogin (),
            "dessenha"=>$this->getdessenha(),
            "dtcadastro"=>$this->getdtcadastro()
        ));
    }

    //seleciona o usuario pelo id
    public function loadById($id)
    {
        $sql = new Sql();

        $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
            ":ID" => $id
        ));

        if (count($result) > 0) {
            $row = $result[0];

            $this->setIdusuario($row['idusuario']);
            $this->setdeslogin($row['deslogin']);
            $this->setdessenha($row['dessenha']);
            $this->setdtcadastro(new DateTime($row['dtcadastro']));
        }
    }

    public static function getList()
    {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");
    }

    public static function search($login)
    {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin;",array(
            ':SEARCH'=>'%'.$login.'%'
        ));
    }

    public function login($login,$password)
    {
        $sql = new Sql();

        $result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGI AND dessenha = :PASS", array(
            ":LOGI"=>$login,
            ":PASS"=>$password
        ));

        if (count($result) > 0) {
            $row = $result[0];

            $this->setIdusuario($row['idusuario']);
            $this->setdeslogin($row['deslogin']);
            $this->setdessenha($row['dessenha']);
            $this->setdtcadastro(new DateTime($row['dtcadastro']));
            return $result;
        }else {
            throw new Exception("Login e/ou senha inválido");
        }
    }
}
