<?php

/**
 * Classe de modelo da entidade Telefone
 */
class Model_Telefone extends Zend_Db_Table_Abstract {

    /**
     * Nome da tabela
     * @var string
     */
    protected $_name = 'telefone';
    
    /**
     * Verifica se o telefone foi registrado
     * @param string $tel
     * @return boolean
     */
    public function verificarTelefone($tel) {
        $rs = $this->fetchAll("numero = '{$tel}'")->toArray();
        if (count($rs) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Persiste o telefone no banco
     * @param array $tel
     * @param boolean $flgEnviarSms
     * @return boolean
     */
    public function salvar(&$tel, $flgEnviarSms) {        
        $where = "id_usuario = " . $tel['id_usuario'];
        $listTel = $this->fetchAll($where)->toArray();
        $tel['ativo'] = ( !isset($tel['ativo']) ) ? 0 : 1; 
        
        if( count($listTel) > 0 ) {
            //Atualiza um telefone existente
            $this->update($tel, $where);
        } else {
            //Insere um novo telefone
            if ($flgEnviarSms) {
                $tel['codigo'] = $this->gerarCodigoAtivacao();
            }
            $tel['id_telefone'] = $this->insert($tel);
        }
        return true;
    }
    
    /**
     * Limpa os telefone inativos
     * @param string $tel Número de telefone
     * @param int $idUsuario Id do usuário
     */
    public function limparTelefonesInativos($tel, $idUsuario) {
        $where = "ativo = FALSE ";
        $where .= "AND numero <> '{$tel}' ";
        $where .= "AND id_usuario = " . $idUsuario;

        $this->delete($where);
    }
    
    /**
     * Gera o código de ativação do telefone
     * @return int Código de ativação
     */
    public function gerarCodigoAtivacao() {
        return rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    }
    
    /**
     * Valida o código de ativação
     * @param integer $idUsuario
     * @param integer $codigo
     * @return boolean
     */
    public function validarCodigoAtivacao($idUsuario, $codigo) {
        //Consulta o código no banco
        $where = "id_usuario = {$idUsuario} AND codigo = {$codigo}";
        $listTel = $this->fetchAll($where)->toArray();
        //Altera o status de ativação
        if( count($listTel) ) {
            $tel = $listTel[0];
            $tel['ativo'] = 1;
            $this->update($tel, "id_telefone = {$tel['id_telefone']}");
            
            return true;
        } else {
            return false;
        }
    }
}

