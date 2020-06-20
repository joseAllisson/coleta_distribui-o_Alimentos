<?php

namespace App\Models;
use MF\Model\Model;
use PDO;

class Produto extends Model{

    private $id;
    private $nome;
    private $data_validade;
    private $img;
    private $local_coleta;

    public function __get($att){
        return $this->$att;
    }

    public function __set($att, $value){
        return $this->$att = $value;
    }
    
    public function registraProduto(){
        $stmt = $this->db->prepare("INSERT INTO alimentos(nome, local_coleta, data_validade, fk_empresa, img) values(:nome, :local_coleta, :data_validade, :id, :img)");
        $stmt->bindValue(":nome", $this->nome);
        $stmt->bindValue(":data_validade", $this->data_validade);
        $stmt->bindValue(":local_coleta", $this->local_coleta);
        $stmt->bindValue(":img", $this->img);
        $stmt->bindValue(":id", $this->id);
        $stmt->execute();

        return $this;
    }

    public function editaProduto(){
        $stmt = $this->db->prepare("UPDATE alimentos SET nome = :nome, data_validade = :data_validade, local_coleta = :local_coleta, img = :img  where id_alimento = :id");
        $stmt->bindValue(":nome", $this->nome);
        $stmt->bindValue(":data_validade", $this->data_validade);
        $stmt->bindValue(":local_coleta", $this->local_coleta);
        $stmt->bindValue(":img", $this->img);
        $stmt->bindValue(":id", $this->id);
        $stmt->execute();

        return $this;
    }


    public function pegaProdutosEmpresa(){
        $stmt = $this->db->prepare("SELECT * FROM alimentos where fk_empresa = :id");
        $stmt->bindValue(":id", $this->id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function pegaTodosProdutos(){
        $stmt = $this->db->prepare("SELECT * FROM alimentos");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function pegaProdutos(){
        $stmt = $this->db->prepare("SELECT * FROM alimentos where id_alimento = :id");
        $stmt->bindValue(":id", $this->id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function excluirProduto(){
        $stmt = $this->db->prepare("DELETE FROM alimentos WHERE id_alimento = :id");
        $stmt->bindValue(":id", $this->id);
        $stmt->execute();

        return $this;
    }

    public function entregar(){
        
    }

}
