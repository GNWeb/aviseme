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
        //Recupera os parâmetros
        $this->_helper->util()->populateSession('cadastro');
        $dataForm = $this->_helper->util()->getDataSession('cadastro');
        $codigo = $this->_request->getParam('codigo');
        $idUsuario = $dataForm['id_usuario'];
        
        //Valida o código de ativação
        $usuarioBns = new Business_Usuario();
        $flgValidado = $usuarioBns->validarCodigoAtivacao($idUsuario, $codigo);
        if( $flgValidado ) {
            //Limpa os dados de cadastro da sessão
            //$namespace = new \Zend_Session_Namespace('cadastro');
            //$namespace->unsetAll();
        } else {
            $tpMsg = "error";
            $msg = "O código informado não é valido!<br />Sugerimos que verifique o código novamente e se necessário solicite o reenvio.";
            
            //Sobe a mensagem para a sessão
            Util_Notificacao::adicionarMensagem($msg, $tpMsg);
            $this->_redirect("/usuario/validar-telefone");
        }
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
        $dataForm['tel'] = str_replace("_", "", $dataForm['tel']);
        if (isset($dataForm['id_usuario'])) {
            $usuario['id_usuario'] = $dataForm['id_usuario'];
        }
        $usuarioBsn = new Business_Usuario();
        $usuarioBsn->salvar($usuario, $dataForm['tel']);
        
        //Alimenta a sessão com o id do usuario
        $dataSession->data['id_usuario'] = $usuario['id_usuario'];
        
        //Registra os dados do voo
        $bsnDestino = new Business_Destino();
        $voo = array();
        $voo['id_voo'] = ( isset($dataForm['id_voo']) ) ? $dataForm['id_voo'] : NULL;
        $voo['id_destino_origem']   = $dataForm['origem_data'];
        $voo['id_destino_destino']  = $dataForm['destino_data'];
        $voo['id_usuario']          = $usuario['id_usuario'];
        $voo['data_inicio']         = Util_Global::dataIso($dataForm['data_inicio']);
        $voo['data_fim']            = Util_Global::dataIso($dataForm['data_fim']);
        $bsnDestino->adicionarVoo($voo);
        $dataSession->data['id_voo'] = $voo['id_voo'];
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

