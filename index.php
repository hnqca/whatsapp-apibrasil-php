<?php

    require_once __DIR__ . '/vendor/autoload.php';

    use ApiBrasil\WhatsApp;

    // https://plataforma.apibrasil.com.br/plataforma/myaccount/apicontrol
    $whatsApp = new WhatsApp([ 
        'SecretKey:     YOUR_SECRET_KEY',
        'PublicToken:   YOUR_PUBLIC_TOKEN',
        'DeviceToken:   YOUR_DEVICE_TOKEN',
        'Authorization: Bearer YOUR_BEARER_TOKEN'
    ]);
    
    try {
        // envia a mensagem de texto.
        print_r($whatsApp->sendText(5518999999999, "Testando API! 😃"));
    } catch (Exception $e) {
        // Caso dê erro, retornará o motivo.
        die("Error: " . $e->getMessage());
    }