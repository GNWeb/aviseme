<?php

/**
 * Classe de modelo da entidade Voo
 */
class Model_Voo extends Zend_Db_Table_Abstract {

    /**
     * Nome da tabela
     * @var string
     */
    protected $_name = 'voo';
    
    /**
     * Salva o voo
     * @param array $voo
     * @return boolean
     */
    public function salvar(&$voo) {
        if( isset($voo['id_voo']) ) {
            $where = "id_voo = " . $voo['id_voo'];
            
            //Update
            $this->update($voo, $where);
        } else {
            //Insert
            $voo['id_voo'] = $this->insert($voo);
        }
        
        return true;
    }
    
}

