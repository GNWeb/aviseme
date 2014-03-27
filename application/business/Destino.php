<?php

/**
 * Classe de negócio da entidade Destino
 */
class Business_Destino
{

    /**
     * Salva ou atualiza uma lista de destinos
     * @param array $destinos
     */
    public function salvarDestinos($destinos)
    {
        
    }

    /**
     * Sincroniza os destinos da base com o do site da Gol
     */
    public function sincronizar() {
        //Model
        $destinoModel = new Model_Destino();
        
        //Recupera a url de acesso aos dados
        $constantsConfig = new Zend_Config_Ini(APPLICATION_PATH."/configs/constants.ini", "gol");
        $urlDestinos = $constantsConfig->url->destinos;
        
        //Recupera os dados do servidor
        $client = new Zend_Http_Client($urlDestinos);
        $destinos = Zend_Json_Decoder::decode($client->request()->getBody());
        
        //Salva os destinos nacionais
        foreach ($destinos['nacionais'] as $destino) {
            $data = array();
            $data['nome']       = $destino['nome'];
            $data['sigla']      = $destino['val'];
            $data['codigo']     = $destino['ID'];
            $data['prioridade'] = $destino['Prioridade'];
            $data['nacional']   = true;
            
            $destinoModel->salvar($data);
        }
        
    }
    
    /**
     * Lista os destinos em ordem alfabética
     * @param string $filtro
     */
    public function listar($filtro) {
        //Model
        $destinoModel = new Model_Destino();
        $filtro = "%".$filtro."%";
        //return $destinoModel->fetchAll("nome ilike " . $destinoModel->getAdapter()->quote($filtro), "nome")->toArray();
        return $destinoModel->fetchAll("remove_acento(nome) ILIKE remove_acento('%" . $filtro . "%')", "nome")->toArray();
    }

}

