<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Status
 *
 * @author Guilherme Longaray
 */

/**
 * Status
 *
 * @Entity
 * @Table(name="status")
 */
class Status {
    
     /**
     * @Id
     * @Column(type="integer", name="id_status")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @Column(type="string", name="nome")
     */
    private $nome;
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }
        
    public function toJson() {
        return array(
            'id' => $this->getId(),
            'nome' => $this->getNome(),
        );
    }
}