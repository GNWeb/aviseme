<?php

/**
 * Controladora
 */
class UsuarioController extends Zend_Controller_Action
{    
    /**
     * Preenche os dados pessoais
     */
    public function dadosPessoaisAction() {
        $this->_helper->util()->populateSession('cadastro');
        $dataForm = $this->_helper->util()->getDataSession('cadastro');
        if ($dataForm) {
            $this->view->dataForm = $dataForm;
        }
    }

    /**
     * Preenche os dados do voo
     */
    public function dadosVooAction() {
        $this->_helper->util()->populateSession('cadastro');
        $dataForm = $this->_helper->util()->getDataSession('cadastro');
        if ($dataForm) {
            $this->view->dataForm = $dataForm;
        }
    }
    
    public function finalizarCadastroAction() {
        $this->_helper->util()->populateSession('cadastro');
    }
    
    /**
     * Verifica se o telefone já foi cadastrado
     */
    public function consultarTelAction() {
        $tel = $_POST['tel'];
        $filter = new Zend_Filter_Alnum();
        $tel = $filter->filter($tel);
        $usuarioBns = new Business_Usuario();
        $rs['return'] = $usuarioBns->verificarTelefone($tel);
        echo Zend_Json_Encoder::encode($rs);
        die;
    }
    
    /**
     * Carrega a formulário de validação de telefone
     */
    public function validarTelefoneAction() {
        $this->_helper->util()->populateSession('cadastro');
        $dataSession = new Zend_Session_Namespace('cadastro');
        $dataForm = $dataSession->data;

        //Monta o array de usuario
        $usuario = array();
        $usuario['email'] = $dataForm['email'];
        $usuario['senha'] = $dataForm['senha'];
        if (isset($dataForm['id_usuario'])) {
            $usuario['id_usuario'] = $dataForm['id_usuario'];
        }
        $usuarioBsn = new Business_Usuario();
        $usuarioBsn->salvar($usuario, $dataForm['tel']);
        
        //Alimenta a sessão com o id do usuario
        $dataSession->data['id_usuario'] = $usuario['id_usuario'];
    }
}

