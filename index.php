<?php
    require_once("config.php");

   /* $sql = new Sql();
    $usuarios = $sql->select("SELECT * FROM tb_usuarios");

    echo json_encode($usuarios);*/

    //carrega um usuario
    /*$root = new Usuario();
    $root->loadById(3);

    echo $root;*/

    //carrega uma lista de usuarios
    /*$lista = Usuario::getList();

    echo json_encode($lista);*/

    //carrega uma lisa de usuarios buscando pelo login
  /*  $search = Usuario::search("jo");

    echo json_encode($search);*/

    //carrega um login utilizando usuario e senha
    //$usuario =new Usuario();
    //echo json_encode($usuario->login("jose","1234"));
/*
criando um novo usuario insert
    $aluno = new Usuario("aluno1","@lun0");

    $aluno->insert();

    echo $aluno;
    ?>*/

    $usuario=new Usuario();
    $usuario->loadById(5);

    $usuario->update("professor","!@#$%&*()"); 
    echo $usuario;
