<?php

/**
 * Controladora da entidade Destino
 */
class DestinoController extends Zend_Controller_Action
{

    /**
     * Sincroniza os destinos da base com o do site da Gol
     */
    public function sincronizarAction() {
        $destinoBsn = new Business_Destino();
        $destinoBsn->sincronizar();
        
        die;
    }
    
    /**
     * Carrega a lista de destinos
     */
    public function listarAjaxAction() {
        $destinoBsn = new Business_Destino();
        $filtro = @$_REQUEST['query'];
        $destinos = $destinoBsn->listar($filtro);
        $rs = array();
        foreach($destinos as $destino) {
            $dest = array();
            $dest['data'] = $destino['id_destino'];
            $dest['value'] = $destino['nome'];
            
            $rs['suggestions'][] = $dest;
            
        }
        echo json_encode($rs);
        die;
    }

}

