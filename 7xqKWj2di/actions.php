<?php

function getYouTubeTitle($videoId) {
        $url = "https://www.youtube.com/watch?v=" . $videoId;
        $html = file_get_contents($url);
        if ($html !== false) {
                preg_match("/<title>(.*?)<\/title>/", $html, $matches);

                if (isset($matches[1])) {
                        $title = str_replace(" - YouTube", "", $matches[1]);
                        return $title;
                }
        }
	// SE A FUNCAO FALHAR EM OBTER O TITULO DO VIDEO, RETORNA UM TITULO ALEATORIO
	// APENAS PARA DEBUG CASO, NO FUTURO O CODIGO FALHE
        return "TOP 5 motivos para comprar BITCOIN";

}


function getRealIpAddr() {
	/*
	PRIMEIRO TENTA PEGAR O IP ATRAVEZ DO HEADER HTTP
	PERSONALIZADO DO CLOUDFLARE (EM CASO DO SERVIDOR ESTAR
	PROTEGIDO PELO PROXY DA CF.

	O PARAMETRO HTTP_X_FORWARDED_FOR CASO O SERVIDOR ESTEJA PROTEGIDO
	POR ALGUM OUTRO PROXY OU LOUDBALANCE

	SE TODOS OS PARAMETROS NAO EXISTIREM, ELE TENTA PEGAR O IP DO CLIENTE
	QUE DE FATO FEZ A CHAMADA
	*/
	if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
		$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
	} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} elseif (isset($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	} else {
		$ip = 'SEM IP';
	}

	return $ip;
}

function saveArray($arquivo, $dados){
        $json = json_encode($dados, JSON_PRETTY_PRINT);
        file_put_contents($arquivo, $json);
}

function getContent($arquivo){
        $conteudo = file_get_contents($arquivo);
        $dados = json_decode($conteudo, true);
        return $dados;
}

function logsIniciais($arquivo){
        date_default_timezone_set('America/Sao_Paulo');

        $client_ip = getRealIpAddr();
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $data = date('d-m-Y:H:i:s');

        $dados_cliente = array("UA" => $user_agent, "DATA" => $data, "FOTO" => 0, "TELA" => 0, "GPS" => 0);

        if (file_exists($arquivo)) {
                $dados = getContent($arquivo);

                if (!array_key_exists($client_ip, $dados)) {
                        $dados[$client_ip] = $dados_cliente;
                        saveArray($arquivo, $dados);
                }
        } else {
                $json = array($client_ip => $dados_cliente);
                saveArray($arquivo, $json);
       }
}

?>
