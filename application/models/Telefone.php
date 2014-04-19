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
        $where = "numero = '" . $tel['numero'] . "'";
        $listTel = $this->fetchAll($where);
        
        if( count($listTel) > 0 ) {
            $this->update($tel, $where);
        } else {
            $tel['id_telefone'] = $this->insert($tel);
        }
        
        return true;
    }
}

