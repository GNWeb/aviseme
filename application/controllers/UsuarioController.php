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
    
    /**
     * Finalizar o cadastro
     */
    public function finalizarCadastroAction() {
        //Recupera os par�metros
        $this->_helper->util()->populateSession('cadastro');
        $dataForm = $this->_helper->util()->getDataSession('cadastro');
        $codigo = $this->_request->getParam('codigo');
        $idUsuario = $dataForm['id_usuario'];
        
        //Valida o c�digo de ativa��o
        $usuarioBns = new Business_Usuario();
        $flgValidado = $usuarioBns->validarCodigoAtivacao($idUsuario, $codigo);
        Zend_Debug::dump($flgValidado);die;
    }
    
    /**
     * Verifica se o telefone j� foi cadastrado
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
     * Carrega a formul�rio de valida��o de telefone
     */
    public function validarTelefoneAction() {
        $this->_helper->util()->populateSession('cadastro');
        $dataSession = new Zend_Session_Namespace('cadastro');
        $dataForm = $dataSession->data;
        
        //Monta o array de usuario
        $usuario = array();
        $usuario['email'] = $dataForm['email'];
        $usuario['senha'] = $dataForm['senha'];
        $dataForm['tel'] = str_replace("_", "", $dataForm['tel']);
        if (isset($dataForm['id_usuario'])) {
            $usuario['id_usuario'] = $dataForm['id_usuario'];
        }
        $usuarioBsn = new Business_Usuario();
        $usuarioBsn->salvar($usuario, $dataForm['tel']);
        
        //Alimenta a sess�o com o id do usuario
        $dataSession->data['id_usuario'] = $usuario['id_usuario'];
    }
    
    /**
     * Limpa os dados de cadastro
     */
    public function limparSessaoAction() {
        $namespace = new \Zend_Session_Namespace('cadastro');
        $namespace->unsetAll();
        
        $this->_redirect("/");
    }
            
}

