<?php

/**
 * Classe de modelo da entidade Usuario
 */
class Model_Usuario extends Zend_Db_Table_Abstract {

    /**
     * Nome da tabela
     * @var string
     */
    protected $_name = 'usuario';
    
    /**
     * Salva o usuário
     * @param array $usuario
     * @param string $tel
     * @return boolean
     */
    public function salvar(&$usuario, $tel) {
        $usuario['senha'] = sha1(md5($usuario['senha']));
        
        if( isset($usuario['id_usuario']) ) {
            $where = "id_usuario = " . $usuario['id_usuario'];
            
            //Update
            $this->update($usuario, $where);
        } else {
            //Insert
            $usuario['id_usuario'] = $this->insert($usuario);
        }
        
        return true;
    }
    
}

