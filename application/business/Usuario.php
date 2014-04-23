<?php

/**
 * Classe de neg�cio da entidade Usu�rio
 */
class Business_Usuario
{
    /**
     * Verifica se o telefone j� foi cadastrado
     * @param string $tel
     */
    public function verificarTelefone($tel) {
        $model = new Model_Telefone();
        return $model->verificarTelefone($tel);
    }
    
    /**
     * Salva o usu�rio
     * @param array $usuario
     * @param string $tel
     * @return boolean
     */
    public function salvar(&$usuario, $tel = "") {
        $usuarioModel = new Model_Usuario();
        $filter = new Zend_Filter_Alnum();
        $arrTel['numero'] = $filter->filter($tel);
        $flgEnviarSms = isset($usuario['id_usuario']) ? true : false;
        
        //Persiste o usu�rio
        $usuarioModel->salvar($usuario, $tel);
        
        //Grava o telefone
        $telefoneModel = new Model_Telefone();
        $arrTel['id_usuario'] = $usuario['id_usuario'];
        $telefoneModel->salvar($arrTel);
        
        //Envia o c�digo de ativa��o para o n�mero
        if ($flgEnviarSms) {
            $smsHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('Sms');
            $msg = "AVISEME - Codigo de ativacao: " . $arrTel['codigo'];
            $smsHelper->enviar($msg, $arrTel['numero']);
        }
    }
}

