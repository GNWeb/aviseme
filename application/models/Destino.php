<?php

/**
 * Classe de modelo da entidade Destino
 */
class Model_Destino extends Zend_Db_Table_Abstract
{
    /**
     * Nome da tabela
     * @var string
     */
    protected $_name = 'destino';
    
    /**
     * Insere ou atualiza um registro
     * @param array $destino
     */
    public function salvar($destino) {
        $where = "sigla = '" . $destino['sigla'] . "'";
        $rs = $this->fetchAll($where)->toArray();
        if (count($rs) > 0) {
            //Update
            $this->update($destino, $where);

            return $rs[0]['id_destino'];
        } else {
            //Insert
            return $this->insert($destino);
        }
    }
}

