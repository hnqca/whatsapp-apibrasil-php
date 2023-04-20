<div align="center">
  <h1>
    <img width="230px" src="https://plataforma.apibrasil.com.br/frontend/img/logo.png" />
    <br>SDK <small>(não oficial)</small> em PHP para consumir a API do WhatsApp através da plataforma <a href="https://apibrasil.com.br">APIBrasil</a> 🐘
  </h1>
</div>

***
<!-- CONFIGURAÇÃO - API Brasil -->
<details>
  <summary><h2>⚙️ Configuração - API Brasil</h2>
  <p>Cadastrando na plataforma APIBrasil.</p>
  </summary>
  <ol><br>
    <li>
      <b>Criando uma conta.</b>
      <p>Acesse <a href="https://plataforma.apibrasil.com.br/auth/register">https://plataforma.apibrasil.com.br/auth/register</a> para criar uma conta na plataforma.</p>
      <ul>
        <p align="center">
          <img src="https://i.ibb.co/XCjRs8p/Screenshot-2023-03-05-at-08-15-23-Criar-minha-conta-APIBrasil-Sites-e-Softwares-LTDA.png">
        </p>
      </ul>
    </li>
    <li>
      <b>Preenchendo os dados da conta.</b>
      <p>Após ter criado a conta, vá até a página <b color="#6a73ff">"Meu plano"</b> e selecione um plano que melhor atende as suas necessidades.</b></p>
        <p align="center">
          <img src="https://i.ibb.co/v107cG6/meu-plano.png">
          <img width="200px" src="https://i.ibb.co/Wt9mygv/cadastro-incompleto.png">
        </p>
        <p>Provavelmente você encontrará um aviso para completar o seu cadastro. Clique sobre o aviso e informe todos os dados necessários</p>
        <p align="center">
          <img src="https://i.ibb.co/VqJwR4M/cadastro-incompleto2.png">
          <!-- https://i.ibb.co/Wt9mygv/cadastro-incompleto.png -->
        </p>
      </ul>
    </li>
    <li>
      <b>Credenciais da API WhatsApp</b>
      <p>Após ter preenchido os dados da sua conta e ter selecionado o plano desejado. Vá até a página <b>"Minhas API's"</b>.</p>
        <p align="center">
          <img src="https://i.ibb.co/PQ9bRWF/minhas-apis.png">
        </p>
        <p>Procure por <b>"API WhatsApp"</b> e clique na chavinha "🔑" para visualizar as suas credenciais.</p>
        <p align="center">
          <img src="https://i.ibb.co/s638zxB/api-whatsapp-1.png">
        </p>
        <p>Nesta página, você encontrará o seu <b>BEARER TOKEN</b> e a sua <b>SECRET KEY</b>.</p>
        <p align="center">
          <img src="https://i.ibb.co/9gk95XT/credenciais-1.png">
        </p>
    </li>
    <li>
      <b>Configurando o dispositivo.</b>
      <p>Clique em <b>"( 0 ) Dispositivos"</b> e clique no botão <b>"+ Adicionar"</b>.</p>
        <p align="center">
          <img src="https://i.ibb.co/0KJfHh8/dispositivos-1.png">
        </p>
        <p>Nesta seção, você encontrará o seu <b>DEVICE TOKEN</b>. Informe todos os dados necessários e clique em <b>"Salvar"</b>.</p>
        <p align="center">
          <img src="https://i.ibb.co/XLtsBbS/device-token.png">
        </p>
        <p><b>Observação:</b> em <b>"IP PERMITIDO"</b>, você deve informar o IP do seu servidor no qual rodará a sua aplicação. Você também pode informar o IP de sua máquina para rodar em ambiente local, <b>Xampp</b> ou <b>WampServer</b>, por exemplo.</p>
    </li>
    <li>
      <b>Public Token & Conectando o seu número de WhatsApp.</b>
      <p>Após ter configurado o dispositivo, você pode encontra-lo na tabela da página <b>"Dispositivos"</b>.</p>
      <p>Você encontrará também o seu <b>"PUBLIC TOKEN"</b>.<br>Para vincular o seu WhatsApp, clique no icone de <b>"QR Code"</b>.</p>
        <p align="center">
          <img src="https://i.ibb.co/3YXmr09/public-token.png">
        </p>
        <p>Aguarde a resposta da API. (isso pode levar alguns segundos ou até minutos).</p>
        <p>Assim que o carregamento for concluído, um QR Code, ficará disponível para você, escaneie o código para conectar ao WhatsApp.</p>
        <p align="center">
          <img src="https://i.ibb.co/DpLttRd/qrcode.png">
        </p>
    </li>
     <li>
      <b>Conectado! ✅🚀</b>
      <p>Se tudo ocorrer bem, um aviso "connected" será mostrado em "status".</p>
        <p align="center">
          <img src="https://i.ibb.co/VVhYQ92/connected.png">
        </p>
      <p>Agora é só pegar todas as credenciais que você anotou durante todo o processo de configuração <br><br>(<b>SecretKey</b>, <b>PublicToken</b>, <b>DeviceToken</b> e <b>Bearer Token</b>)<br><br> e começar a integração.</p>
    </li>
  </ol>
</details>

***

## Instalação

#### Composer

```
composer require henriquecacerez/whatsapp-apibrasil-php
```

```
// Exemplo:
require_once __DIR__ . '/vendor/autoload.php';
```

#### Manual

Baixe ou clone o repositório completo. [Faça o download aqui](https://github.com/henriquecacerez/whatsapp-apibrasil-php/archive/master.zip).

```
// Exemplo:
require_once __DIR__ . '/App/ApiBrasil/WhatsApp.php';
```

***

### Métodos:

| Método      | Descrição                                                                                                                                                                                                            |
| -------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| ```sendText```          | Envia uma mensagem de texto simples. |
| ``` sendImage```        | Envia uma imagem. Formatos aceitos: (<b>jpeg, jpg, png e gif</b>). |
| ```sendVideo```         | Envia um vídeo. Formatos aceitos: (<b>mp4</b>)  |
| ```sendPDF```           | Envia um arquivo <b>.PDF</b>   |
| ```sendButton```        | Envia uma mensagem com botões. |


***
### Iniciando
```php
<?php

    require_once __DIR__ . '/vendor/autoload.php';

    use ApiBrasil\WhatsApp;

    // https://plataforma.apibrasil.com.br/plataforma/myaccount/apicontrol
    $credentials = [ 
        'SecretKey:     YOUR_SECRET_KEY',
        'PublicToken:   YOUR_PUBLIC_TOKEN',
        'DeviceToken:   YOUR_DEVICE_TOKEN',
        'Authorization: Bearer YOUR_BEARER_TOKEN'
    ];

    $whatsApp = new WhatsApp($credentials);
```
---------

#### MENSAGEM DE TEXTO 💬

![Mensagem de Texto](https://i.ibb.co/X22PzPP/Whats-App-Image-2023-02-16-at-15-24-54.jpg)
 
```php

    /**
      * número de WhatsApp que receberá a mensagem.
      * (obrigatório conter o código do país e o DDD).
    */
    $phoneNumber = "+55 (18) 99999-9999";

    // mensagem que será enviada.
    $message = "Testando API! 😃"; 

    try {
        // envia a mensagem de texto.
        print_r($whatsApp->sendText($phoneNumber, $message));
    } catch (Exception $e) {
        // Caso dê erro, retornará o motivo.
        die("Error: " . $e->getMessage());
    }
```
---------

#### ENVIO DE IMAGEM 🖼️

![Mensagem de Imagem](https://i.ibb.co/ykzxCk8/Whats-App-Image-2023-02-16-at-15-32-32.jpg)

```php
  // caminho da imagem
  $image = "cat.jpg";

  // legenda da imagem (opcional)
  $caption = "Legenda da imagem";

  // envia a imagem
  $whatsApp->sendImage(5518999999999, $image, $caption);
```

---------
#### ENVIO DE VÍDEO 📽️

<img src="https://i.ibb.co/KLj6VY9/example-Video.jpg" width="360">

```php
  $whatsApp->sendVideo(5518999999999, "files/simplevideo.mp4");
```

---------
#### ENVIO DE PDF 📁
 
![Envio de PDF](https://i.ibb.co/98gnNGG/Whats-App-Image-2023-02-16-at-17-53-23.jpg)

```php
    // titulo do arquivo (opcional)
    $title = "Aplicação";
    
    // envia o arquivo pdf
    $whatsApp->sendPDF(5518999999999, "https://www.africau.edu/images/default/sample.pdf", $title);
```
---------

#### MENSAGEM COM BOTÕES 🔢

![Mensagem com botões](https://i.ibb.co/72yN4ww/Whats-App-Image-2023-02-16-at-18-12-47.jpg)

```php
    $buttons = [
      [
        'id'   => 'resposta_01',
        'text' => 'Botão 1️⃣'
      ], 
      [
        'id'   => 'resposta_02',
        'text' => 'Botão 2️⃣'
      ],
      [
        'id'   => 'resposta_03',
        'text' => 'Botão 3️⃣'
      ]
    ];

    // envia a mensagem com botões.
    $whatsApp->sendButtonMessage(5518999999999, [
        'title'  => "Titulo da mensagem",
        'text'   => "Imagine um texto bem legal aqui.\n\n👋😁",
        'footer' => "Aqui vai o texto do rodapé da mensagem"
    ], $buttons);

```
#### MENSAGEM COM BOTÕES 🔢 (COMPACTO)
```php
    // cria o botão (id, texto)
    $whatsApp->createButton('resposta_01', "Botão 1️⃣");
    $whatsApp->createButton('resposta_02', "Botão 2️⃣");
    $whatsApp->createButton('resposta_03', "Botão 3️⃣");

    // envia a mensagem com botões.
    $whatsApp->sendButtonMessage(5518999999999, [
        'title'  => "Titulo da mensagem",
        'text'   => "Imagine um texto bem legal aqui.\n\n👋😁",
        'footer' => "Aqui vai o texto do rodapé da mensagem"
    ]);
```