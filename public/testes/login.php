<?php
	//Exibi��o de erros
	//display_errors(E_ALL);
	ini_set('display_errors', 'on');
	
	// Dados de login
	$urlLogin = 'https://www.argentglobalnetwork.com/handler.php?h=user_login';
	$formloginemail	= 'gustavonobrega.efti@gmail.com';
	$formloginpassw	= '090288';
	$loginRedirect = 'https://www.argentglobalnetwork.com/backoffice/index.html';

        //Inicia a opera
        efetuarLogin($urlLogin, $formloginemail, $formloginpassw, $loginRedirect);
	
	function efetuarLogin ($urlLogin, $formloginemail, $formloginpassw, $loginRedirect) {
		// Inicia o cURL
		$ch = curl_init();

		// Define a URL original (do formul�rio de login)
		curl_setopt($ch, CURLOPT_URL, $urlLogin);

                curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
                
		// Habilita o protocolo POST
		curl_setopt ($ch, CURLOPT_POST, 1);

		// Define os par�metros que ser�o enviados (usu�rio e senha por exemplo)
		curl_setopt ($ch, CURLOPT_POSTFIELDS, 'formloginemail=' . $formloginemail . '&formloginpassw= ' . $formloginpassw);

		// Imita o comportamento patr�o dos navegadores: manipular cookies
		curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

		// Define o tipo de transfer�ncia (Padr�o: 1)
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

		// Executa a requisi��o
		//HTML da p�gina resultado (depois do submit do login)
		$store = curl_exec ($ch);
var_dump($store);

		// Define uma nova URL para ser chamada (ap�s o login)
		curl_setopt($ch, CURLOPT_URL, $loginRedirect);

		// Executa a segunda requisi��o
		//HTML da p�gina chamada na segunda requisi��o
		$content = curl_exec ($ch);
var_dump($content);
		// Encerra o cURL
		curl_close ($ch);
	}
?>