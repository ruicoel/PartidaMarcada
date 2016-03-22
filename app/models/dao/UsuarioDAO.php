<?php
class UsuarioDAO {

    function insert($usuario) {
        try {
            DataBase::getFactory()->persist($usuario);      
            DataBase::getFactory()->flush();
        
            return ($usuario->getId() ? true: false);
        } catch (Exception $ex) {
            return false;
        }
        
    }

    function update($usuario) {
        DataBase::getFactory()->persist($usuario);
        
        return DataBase::getFactory()->flush();
    }

    static function getById($id) {
        $usuario = DataBase::getFactory()->getRepository('Usuario')->find(array('id' => $id));

        return (empty($usuario) ? false : $usuario);
    }

    function getAll() {
        $usuarios = DataBase::getFactory()->getRepository('Usuario')->findAll();

        return (empty($usuarios) ? false : $usuarios);
    }

    function delete($usuario) {
        DataBase::getFactory()->remove($usuario);
        
        return DataBase::getFactory()->flush();
    }
}