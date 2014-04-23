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
     * @return boolean
     */
    public function salvar(&$tel) {
        //Limpa os telefone inativos
        $this->limparTelefonesInativos($tel['numero'], $tel['id_usuario']);
        
        $where = "numero = '" . $tel['numero'] . "' AND id_usuario = " . $tel['id_usuario'];
        $listTel = $this->fetchAll($where)->toArray();
        
        if( count($listTel) > 0 ) {
            //Atualiza um telefone existente
            $this->update($tel, $where);
        } else {
            //Insere um novo telefone
            $tel['codigo'] = $this->gerarCodigoAtivacao();
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
}

