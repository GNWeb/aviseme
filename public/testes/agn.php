<?php

//Exibi��o de erros
error_reporting(E_ALL);
ini_set('display_errors', 'on');

// Dados de login
$urlLogin = 'https://www.argentglobalnetwork.com/handler.php?h=user_login';
$formloginemail = 'gustavonobrega.efti@gmail.com';
$formloginpassw = '090288';
$loginRedirect = 'https://www.argentglobalnetwork.com/backoffice/index.html';

// Inicia o cURL
$ch = curl_init();

//Inicia a opera��o de login
efetuarLogin($ch, $urlLogin, $formloginemail, $formloginpassw, $loginRedirect);

//Valida o an�ncio
$urlAd = "http://www.ukadslist.com/view/item-332435-Advertising-works-with-ArgentGlobalNetwork.html";
validarAnuncio($ch, $urlAd);

// Encerra o cURL
curl_close($ch);

//Efetua o login atrav�s do curl
function efetuarLogin(&$ch, $urlLogin, $formloginemail, $formloginpassw, $loginRedirect) {
    
    // Define a URL original (do formul�rio de login)
    curl_setopt($ch, CURLOPT_URL, $urlLogin);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    // Habilita o protocolo POST
    curl_setopt($ch, CURLOPT_POST, 1);

    // Define os par�metros que ser�o enviados (usu�rio e senha por exemplo)
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'formloginemail=' . $formloginemail . '&formloginpassw= ' . $formloginpassw);

    // Imita o comportamento patr�o dos navegadores: manipular cookies
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

    // Define o tipo de transfer�ncia (Padr�o: 1)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Executa a requisi��o
    //HTML da p�gina resultado (depois do submit do login)
    $store = curl_exec($ch);

    // Define uma nova URL para ser chamada (ap�s o login)
    curl_setopt($ch, CURLOPT_URL, $loginRedirect);

    // Executa a segunda requisi��o
    //HTML da p�gina chamada na segunda requisi��o
    $content = curl_exec($ch);
}

/**
 * Valida a url do an�ncio
 */
function validarAnuncio($ch, $link1) {
    //Par�metros
    $urlAdValid = "https://www.argentglobalnetwork.com/backoffice/ad-confirm.html";
    $number = 146792;
    $link2 = "http://www.ukadslist.com/";
    
    //Envia os par�metros para a valida��o
    
    // Define uma nova URL para ser chamada (ap�s o login)
    curl_setopt($ch, CURLOPT_URL, $urlAdValid);
    
    // Habilita o protocolo POST
    curl_setopt($ch, CURLOPT_POST, 1);

    // Define os par�metros que ser�o enviados (usu�rio e senha por exemplo)
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'link1=' . $link1 . '&number= ' . $number . '&link2='.$link2);

    // Executa a requisi��o
    echo $content = curl_exec($ch);
}

?>