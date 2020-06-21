<?php

namespace App\Models;
use MF\Model\Model;
use PDO;

class Produto extends Model{

    private $id;
    private $fk;
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
        // as a
        //     left join area_entregador as st on (a.id_alimento = st.fk_alimento)
        // where
        $stmt = $this->db->prepare("SELECT * FROM alimentos AS a LEFT JOIN empresas AS e ON (a.fk_empresa = e.id_empresa)");
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
        $stmt = $this->db->prepare("INSERT INTO area_entregador(fk_entregador, fk_alimento) values(:id, :fk)");
        $stmt->bindValue(":id", $this->id);
        $stmt->bindValue(":fk", $this->fk);
        $stmt->execute();

        return $this;
        
    }

    public function area_entregador(){
        $stmt = $this->db->prepare("SELECT *
        from 
            alimentos as a
            left join area_entregador as st on (a.id_alimento = st.fk_alimento)
        where
            st.fk_entregador = :id");
        $stmt->bindValue(":id", $this->id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificarEntrega(){
        $stmt = $this->db->prepare("SELECT * FROM area_entregador WHERE fk_entregador = :id AND fk_alimento = :fk");
        $stmt->bindValue(":id", $this->id);
        $stmt->bindValue(":fk", $this->fk);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return false;
        }else {
            return true;
        }
       
    }

    public function concluido(){
        $stmt = $this->db->prepare("UPDATE alimentos set id_status = 1  WHERE id_alimento = :id");
        $stmt->bindValue(":id", $this->id);
        $stmt->execute();

        return $this;
    }

    public function removerEntrega(){
        $stmt = $this->db->prepare("DELETE FROM area_entregador WHERE fk_alimento = :fk AND fk_entregador = :id");
        $stmt->bindValue(":id", $this->id);
        $stmt->bindValue(":fk", $this->fk);
        $stmt->execute();

        return $this;
    }

}
