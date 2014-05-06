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
        
        //Envia o email de boas vindas
        $this->enviarEmailBoasVindas();
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
    
    /**
     * Envia o email de boas vindas
     */
    public function enviarEmailBoasVindas() {
        $mensagem = "<b>Seja bem vindo ao AviseMe.</b><br />";
        $mensagem .= "Iremos ajudá-lo a encontrar as passagens mais baratas disponíveis nas companhias 
            e te poupar tempo com buscas intermináveis por promoções.<br />";
        $mensagem .= "Para concluir o cadastro é necessário validar seu celular através de um código 
            via SMS. Caso você não tenha finalizado o cadastro por um atraso no recebimento do código é 
            possível dar continuidade clicando aqui.";
    }
}

