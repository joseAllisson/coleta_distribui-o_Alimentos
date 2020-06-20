<?php

namespace App\Models;
use MF\Model\Model;
use PDO;

class Usuario extends Model{

    private $id;
    private $nome;
    private $cpf;
    private $email;
    private $senha;
    private $telefone;

    public function __get($att){
        return $this->$att;
    }

    public function __set($att, $value){
        return $this->$att = $value;
    }
    public function validaRegistro(){
        if(strlen($this->nome) < 1 || strlen($this->email) < 1 || strlen($this->cpf) < 14 || strlen($this->telefone) < 10 || strlen($this->senha) < 3){
            return false;
        }
        return true;
    }

    public function validaRegistroEmpresa(){
        if(strlen($this->nome) < 1 || strlen($this->email) < 1|| strlen($this->telefone) < 8 || strlen($this->senha) < 3){
            return false;
        }
        return true;
    }

    public function validateUpdateRegister(){
        if(strlen($this->email) < 3 || strlen($this->email) < 14 || strlen($this->telefone) < 10 || strlen($this->senha) < 3){
            return false;
        }
        return true;
    }
    public function dadosEmailEntregador(){
        $stmt = $this->db->prepare("SELECT * FROM entregadores where email = :email");
        $stmt->bindValue(":email", $this->email);
        $stmt->execute();


        if($stmt->rowCount() > 0){
            return false;
        }
        return true;
    }

    public function registraEntregador(){
        $stmt = $this->db->prepare("INSERT INTO entregadores(nome, email, cpf, telefone, senha) values(:nome, :email, :cpf, :telefone, :senha)");
        $stmt->bindValue(":nome", $this->nome);
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":cpf", $this->cpf);
        $stmt->bindValue(":telefone", $this->telefone);
        $stmt->bindValue(":senha", $this->senha);
        $stmt->execute();

        return true;
    }

    public function registraEmpresa(){
        $stmt = $this->db->prepare("INSERT INTO empresas(empresa, email, telefone, senha) values(:empresa, :email, :telefone, :senha)");
        $stmt->bindValue(":empresa", $this->nome);
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":telefone", $this->telefone);
        $stmt->bindValue(":senha", $this->senha);
        $stmt->execute();

        return true;
    }
    public function pegaDadosCpf(){
        $stmt = $this->db->prepare("SELECT * FROM entregadores where cpf = :cpf");
        $stmt->bindValue(":cpf", $this->cpf);
        $stmt->execute();


        if($stmt->rowCount() > 0){
            return false;
        }
        return true;
    }
    public function autenticacao(){
        $stmt = $this->db->prepare("SELECT * FROM entregadores where email = :email AND senha = :senha");
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":senha", $this->senha);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!empty($usuario['id_entregador'])){
            $this->id = $usuario['id_entregador'];
            $this->nome = $usuario['nome'];
            $this->email = $usuario['email'];
            $this->cpf = $usuario['cpf'];
            $this->telefone = $usuario['telefone'];
            $this->senha = $usuario['senha'];
        }else {
            return false;
        }
    }

    public function autenticacaoEmpresa(){
        $stmt = $this->db->prepare("SELECT * FROM empresas where email = :email AND senha = :senha");
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":senha", $this->senha);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() > 0){
            $this->id = $usuario['id_empresa'];
            $this->nome = $usuario['nome'];
            $this->email = $usuario['email'];
            $this->telefone = $usuario['telefone'];
            $this->senha = $usuario['senha'];
            return true;
        }else {
            return false;
        }
    }
    
    public function verificadorEmpresa(){
        $stmt = $this->db->prepare("SELECT * FROM empresas where email = :email");
        $stmt->bindValue(":email", $this->email);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return false;
        }else {
            return true;
        }
    }
}
