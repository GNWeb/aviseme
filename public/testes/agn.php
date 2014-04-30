<?php

//Exibiзгo de erros
error_reporting(E_ALL);
ini_set('display_errors', 'on');

// Dados de login
$urlLogin = 'https://www.argentglobalnetwork.com/handler.php?h=user_login';
$formloginemail = 'gustavonobrega.efti@gmail.com';
$formloginpassw = '090288';
$loginRedirect = 'https://www.argentglobalnetwork.com/backoffice/index.html';

// Inicia o cURL
$ch = curl_init();

//Inicia a operaзгo de login
efetuarLogin($ch, $urlLogin, $formloginemail, $formloginpassw, $loginRedirect);

//Valida o anъncio
$urlAd = "http://www.ukadslist.com/view/item-332435-Advertising-works-with-ArgentGlobalNetwork.html";
validarAnuncio($ch, $urlAd);

// Encerra o cURL
curl_close($ch);

//Efetua o login atravйs do curl
function efetuarLogin(&$ch, $urlLogin, $formloginemail, $formloginpassw, $loginRedirect) {
    
    // Define a URL original (do formulбrio de login)
    curl_setopt($ch, CURLOPT_URL, $urlLogin);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    // Habilita o protocolo POST
    curl_setopt($ch, CURLOPT_POST, 1);

    // Define os parвmetros que serгo enviados (usuбrio e senha por exemplo)
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'formloginemail=' . $formloginemail . '&formloginpassw= ' . $formloginpassw);

    // Imita o comportamento patrгo dos navegadores: manipular cookies
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

    // Define o tipo de transferкncia (Padrгo: 1)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Executa a requisiзгo
    //HTML da pбgina resultado (depois do submit do login)
    $store = curl_exec($ch);

    // Define uma nova URL para ser chamada (apуs o login)
    curl_setopt($ch, CURLOPT_URL, $loginRedirect);

    // Executa a segunda requisiзгo
    //HTML da pбgina chamada na segunda requisiзгo
    $content = curl_exec($ch);
}

/**
 * Valida a url do anъncio
 */
function validarAnuncio($ch, $link1) {
    //Parвmetros
    $urlAdValid = "https://www.argentglobalnetwork.com/backoffice/ad-confirm.html";
    $number = 146792;
    $link2 = "http://www.ukadslist.com/";
    
    //Envia os parвmetros para a validaзгo
    
    // Define uma nova URL para ser chamada (apуs o login)
    curl_setopt($ch, CURLOPT_URL, $urlAdValid);
    
    // Habilita o protocolo POST
    curl_setopt($ch, CURLOPT_POST, 1);

    // Define os parвmetros que serгo enviados (usuбrio e senha por exemplo)
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'link1=' . $link1 . '&number= ' . $number . '&link2='.$link2);

    // Executa a requisiзгo
    echo $content = curl_exec($ch);
}

?>