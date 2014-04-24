<?php

/**
 * Classe de negócio da entidade Usuário
 */
class Business_Usuario
{
    /**
     * Verifica se o telefone já foi cadastrado
     * @param string $tel
     */
    public function verificarTelefone($tel) {
        $model = new Model_Telefone();
        return $model->verificarTelefone($tel);
    }
    
    /**
     * Salva o usuário
     * @param array $usuario
     * @param string $tel
     * @return boolean
     */
    public function salvar(&$usuario, $tel = "") {
        $usuarioModel = new Model_Usuario();
        $flgEnviarSms = isset($usuario['id_usuario']) ? false : true;

        //Persiste o usuário
        $usuarioModel->salvar($usuario, $tel);
        
        //Registra o telefone
        $telefoneModel = new Model_Telefone();
        $filter = new Zend_Filter_Alnum();
        $arrTel['numero'] = $filter->filter($tel);
        $arrTel['id_usuario'] = $usuario['id_usuario'];

        $telefoneModel->salvar($arrTel, $flgEnviarSms);
        
        //Envia o código de ativação para o número
        if ($flgEnviarSms) {
            $smsHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('Sms');
            $msg = "AVISEME - Codigo de ativacao: " . $arrTel['codigo'];
            $smsHelper->enviar($msg, $arrTel['numero']);
        }
    }
    
    /**
     * Valida o código de ativação
     * @param integer $idUsuario
     * @param integer $codigo
     * @return boolean
     */
    public function validarCodigoAtivacao($idUsuario, $codigo) {
        $telefoneModel = new Model_Telefone();
        return $telefoneModel->validarCodigoAtivacao($idUsuario, $codigo);
    }
}

