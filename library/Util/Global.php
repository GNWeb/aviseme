<?php

/**
 * Classe utilitária genérica
 *
 * @author Gustavo
 */
class Util_Global {
    
    /**
     * Converte a data para o formato YYYY-mm-dd
     * @param string $data
     * @return string
     */
    public static function dataIso($data) {
        $data = new Zend_Date($data);
        return $data->toString(Zend_Date::YEAR . '-' . Zend_Date::MONTH .'-' . Zend_Date::DAY);die;
    }
    
}

?>
