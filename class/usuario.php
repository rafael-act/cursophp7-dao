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
            "idusuario" => $this->getIdusuario(),
            "deslogin" => $this->getdeslogin(),
            "dessenha" => $this->getdessenha(),
            "dtcadastro" => $this->getdtcadastro()
        ));
    }

    public function __construct($login="",$password="")
    {
        $this->setdeslogin($login);
        $this->setdessenha($password);
    }

    //seleciona o usuario pelo id
    public function loadById($id)
    {
        $sql = new Sql();

        $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
            ":ID" => $id
        ));

        if (count($result) > 0) {
            return $this->setData($result[0]);
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
        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin;", array(
            ':SEARCH' => '%' . $login . '%'
        ));
    }

    public function login($login, $password)
    {
        $sql = new Sql();

        $result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGI AND dessenha = :PASS", array(
            ":LOGI" => $login,
            ":PASS" => $password
        ));

        if (count($result) > 0) {
            return $this->setData($result[0]);
        } else {
            throw new Exception("Login e/ou senha inválido");
        }
    }

    public function setData($data)
    {
        $this->setIdusuario($data['idusuario']);
        $this->setdeslogin($data['deslogin']);
        $this->setdessenha($data['dessenha']);
        $this->setdtcadastro(new DateTime($data['dtcadastro']));
    }

    public function insert()
    {
        $sql = new Sql();

        $result=$sql->select("CALL sp_usuarios_insert(:LOGIN,:PASSWORD)", array(
            ':LOGIN' => $this->getdeslogin(),
            ':PASSWORD' => $this->getdessenha()
        ));

        if (count($result)>0) {
            $this->setData($result[0]);
        }
    }

     public function update($login,$password)
     {
         try {
             
         $this->setdeslogin($login);
         $this->setdessenha($password);
         $sql=new Sql();

         $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID",array(
            ':LOGIN'=>$this->getdeslogin(),
            ':PASSWORD'=>$this->getdessenha(),
            ':ID'=>$this->getIdusuario()
         ));
         
        } catch (Throwable $th) {
            throw $th;
        }
     }   

     public function delete()
     {
         $sql=new Sql();

         $sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID",array(
             ':ID'=>$this->getIdusuario()
         ));

         $this->setIdusuario(0);
         $this->setdeslogin("");
         $this->setdessenha("");
         $this->setdtcadastro(new DateTime());
     }

}
