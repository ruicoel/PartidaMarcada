<?php

require_once(DAO . '/UsuarioDAO.php');
require_once(BLL . '/CidadeBLL.php');
require_once(BLL . '/GeneroBLL.php');
require_once(BLL . '/VisibilidadeBLL.php');
require_once(BLL . '/EstatisticaAtletaBLL.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioBLL
 *
 * @author Guilherme Longaray
 */
class UsuarioBLL {

    public function logar($email, $senha) {
        $dao = new UsuarioDAO();

        $usuario = $dao->logar($email, $senha);

        if ($usuario) {
            $_SESSION['id'] = $usuario->getId();
            $_SESSION['nome'] = $usuario->getNome();
            $_SESSION['tipo'] = "usuario";

            Retorno::setStatus(1);
            Retorno::setMensagem("Login efetuado com sucesso!");

            return Retorno::toJson();
        } else {
            Retorno::setStatus(0);
            Retorno::setMensagem("Usuário e/ou senha inválido(s). Tente novamente!");

            return Retorno::toJson();
        }
    }

    public function deslogar() {
        session_destroy();

        return true;
    }

    public function atualizarSenha($dados) {

        if ($dados['nova_senha'] == $dados['nova_senha2']) {
            if (strlen($dados['nova_senha']) > 5) {


                $dao = new UsuarioDAO();

                $usuario = $dao->getById($_SESSION['id']);

                if ($usuario->getSenha() == md5($dados['senha'])) {
                    $usuario->setSenha(md5($dados['nova_senha']));

                    $dao->persist($usuario);

                    Retorno::setStatus(1);
                    Retorno::setMensagem("Senha alterada com sucesso!");
                } else {
                    Retorno::setStatus(0);
                    Retorno::setMensagem("A senha atual digitada não confere com a senha salva no sistema. Tente novamente!");
                }

                return Retorno::toJson();
            } else {
                Retorno::setStatus(0);
                Retorno::setMensagem("A senha deve ter entre 6 e 18 caracteres. Tente novamente.");

                return Retorno::toJson();
            }
        } else {
            Retorno::setStatus(0);
            Retorno::setMensagem("As novas senhas inseridas não conferem. Tente novamente.");

            return Retorno::toJson();
        }
    }

    public function atualizarEmail($dados) {

        if ($dados['novo_email'] == $dados['novo_email2']) {

            $dao = new UsuarioDAO();

            $usuario = $dao->getById($_SESSION['id']);

            if ($usuario->getEmail() == $dados['email']) {
                $usuario->setEmail($dados['novo_email']);

                $dao->persist($usuario);

                Retorno::setStatus(1);
                Retorno::setMensagem("E-mail alterado com sucesso!");
            } else {
                Retorno::setStatus(0);
                Retorno::setMensagem("O e-mail atual digitado não confere com o e-mail salvo no sistema. Tente novamente!");
            }

            return Retorno::toJson();
        } else {
            Retorno::setStatus(0);
            Retorno::setMensagem("Os novos e-mails digitados não conferem. Tente novamente.");

            return Retorno::toJson();
        }
    }

    public function insert($dados) {
        try {
            if (empty($dados)) {
                return "!vazio";
            } else {
                $CidadeBLL = new CidadeBLL();
                $cidade = $CidadeBLL->getById($dados['cidade']);

                $generoBLL = new GeneroBLL();
                $genero = $generoBLL->getById($dados['genero']);

                $data = Retorno::invertDate($dados['dt_nascimento']);                                 
                
                $usuario = new Usuario();

                $usuario->setNome($dados['nome']);
                
                if($dados['apelido'] == "") {
                    $usuario->setApelido($dados['nome']);
                } else {
                    $usuario->setApelido($dados['apelido']);
                }
                
                $usuario->setApelido($dados['apelido']);
                $usuario->setCep($dados['cep']);
                $usuario->setAtivo(1);
                $usuario->setCidade($cidade);
                $usuario->setDataNascimento(new \DateTime($data));
                $usuario->setDdd($dados['ddd']);
                $usuario->setEmail($dados['email']);
                $usuario->setEndereco($dados['endereco']);
                $usuario->setGenero($genero);
                $usuario->setNumero($dados['numero']);
                $usuario->setSenha(md5($dados['senha']));
                $usuario->setSobrenome($dados['sobrenome']);
                $usuario->setTelefone($dados['telefone']);

                $dao = new UsuarioDAO();

                if ($dao->persist($usuario)) {
                    Retorno::setStatus(1);
                    Retorno::setMensagem("Usuário cadastrado com sucesso, efetue o login no sistema!");
                                       
                    $estatisticaAtletaBLL = new EstatisticaAtletaBLL();
                    
                    $estatisticaAtletaBLL->insert($usuario);

                    return Retorno::toJson();
                } else {
                    Retorno::setStatus(0);
                    Retorno::setMensagem("Erro ao cadastrar usuário no sistema!");

                    return Retorno::toJson();
                }
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function update($dados) {
        try {
            $CidadeBLL = new CidadeBLL();
            $cidade = $CidadeBLL->getById($dados['cidade']);

            $generoBLL = new GeneroBLL();
            $genero = $generoBLL->getById($dados['genero']);

            $usuario = $this->getById($_SESSION['id']);
            
            $data = Retorno::invertDate($dados['dt_nascimento']);    

            $usuario->setNome($dados['nome']);
            
            if($dados['apelido'] == "") {
                $usuario->setApelido($dados['nome']);
            } else {
                $usuario->setApelido($dados['apelido']);
            }
            
            $usuario->setCep($dados['cep']);
            $usuario->setAtivo(1);
            $usuario->setCidade($cidade);
            $usuario->setDataNascimento(new \DateTime($data));
            $usuario->setDdd($dados['ddd']);
            $usuario->setEndereco($dados['endereco']);
            $usuario->setGenero($genero);
            $usuario->setNumero($dados['numero']);
            $usuario->setSobrenome($dados['sobrenome']);
            $usuario->setTelefone($dados['telefone']);

            $dao = new UsuarioDAO();

            if ($dao->persist($usuario)) {
                Retorno::setStatus(1);
                Retorno::setMensagem("Perfil atualizado com sucesso!");

                return Retorno::toJson();
            } else {
                Retorno::setStatus(0);
                Retorno::setMensagem("Erro ao atualizar perfil!");

                return Retorno::toJson();
            }
        } catch (Exception $ex) {
            Retorno::setStatus(0);
            
            Retorno::setMensagem($ex->getMessage());
            return Retorno::toJson();
        }
    }

    function getById($id) {
        $dao = new UsuarioDAO();

        $usuario = $dao->getById($id);

        return $usuario;
    }

    function pesquisar($dados) {
        try {
            $dao = new UsuarioDAO();

            $usuarios = $dao->pesquisar($dados);
            
            $json = [];
            if (empty($usuarios)) {
                return 0;
            } else {
                foreach ($usuarios as $usuario) {
                    $json[] = $usuario->toJson();
                }

                return json_encode($json);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
