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
        $flgEnviarSms = isset($usuario['id_usuario']) ? false : true;

        //Persiste o usu�rio
        $usuarioModel->salvar($usuario, $tel);
        
        //Registra o telefone
        $telefoneModel = new Model_Telefone();
        $filter = new Zend_Filter_Alnum();
        $arrTel['numero'] = $filter->filter($tel);
        $arrTel['id_usuario'] = $usuario['id_usuario'];

        $telefoneModel->salvar($arrTel, $flgEnviarSms);
        
        //Envia o c�digo de ativa��o para o n�mero
        if ($flgEnviarSms) {
            $smsHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('Sms');
            $msg = "AVISEME - Codigo de ativacao: " . $arrTel['codigo'];
            $smsHelper->enviar($msg, $arrTel['numero']);
        }
        
        //Envia o email de boas vindas
        $this->enviarEmailBoasVindas();
    }
    
    /**
     * Valida o c�digo de ativa��o
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
        $mensagem .= "Iremos ajud�-lo a encontrar as passagens mais baratas dispon�veis nas companhias 
            e te poupar tempo com buscas intermin�veis por promo��es.<br />";
        $mensagem .= "Para concluir o cadastro � necess�rio validar seu celular atrav�s de um c�digo 
            via SMS. Caso voc� n�o tenha finalizado o cadastro por um atraso no recebimento do c�digo � 
            poss�vel dar continuidade clicando aqui.";
    }
}

