<?php


/**Função para adicionar a nomeclatura exigida pelo whatsapp ao contato whatsapp passado como parametro*/
function replaceChatid($value)
{
    return $value . "@s.whatsapp.net";
}

/**Função para gerar QRCODE**/
function m_qrcode($instace, $token)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api2.megaapi.com.br/rest/instance/qrcode/' . $instace,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}


/**Qrcode em Base64**/
function m_qrcodeBase64($instace, $token)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api2.megaapi.com.br/rest/instance/qrcode_base64/' . $instace,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response, true);
    echo '<img src="' . $r["qrcode"] . '" />';
}


/**Status da sua instancia*/
function m_status($instace, $token)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api2.megaapi.com.br/rest/instance/' . $instace,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "instance_key"  => $r["instance"]["key"],
        "whatsapp"      => $r["instance"]["user"]["id"] ?? "",
        "company"       => $r["instance"]["user"]["verifiedName"] ?? "",
        "name"          => $r["instance"]["user"]["verifiedName"] ?? ""
    );
}

/**Logout**/
function m_logout($instace, $token)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api2.megaapi.com.br/rest/instance/' . $instace . '/logout',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "status"        => $r["error"],
        "message"       => $r["message"]
    );
}

/***CheckNumber**/
function m_checkNumber($instace, $token, $contact)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api2.megaapi.com.br/rest/instance/isOnWhatsApp/' . $instace . '?jid=' . replaceChatid($contact),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "exists"        => $r["exists"] ?? 0,
        "whatsapp"      => $r["jid"] ?? "Não existe whatsapp"
    );
}


/**Busca foto do perfil**/
function m_getProfilePicture($instance, $token, $contact)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api2.megaapi.com.br/rest/instance/getProfilePicture/' . $instance . '?to=' . replaceChatid($contact) . '&type=image',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "image"        => $r["data"] ?? "Sem imagem"
    );
}

/**Troca a foto do perfil**/
function m_setProfilePictureUrl($instance, $token, $image, $contact)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api2.megaapi.com.br/rest/instance/setProfilePictureUrl/' . $instance,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
        "messageData": {
            "to": "' . replaceChatid($contact) . '",
            "url": "' . $image . '"
        }
    }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "status"        => $r["error"],
        "message"       => $r["message"]
    );
}

/*Troca o nome do perfil whatsapp*/
function m_setProfileName($instance, $token, $name)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api2.megaapi.com.br/rest/instance/setProfileName/' . $instance,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
        "messageData": {
            "name": "' . $name . '"
        }
    }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "status"        => $r["error"],
        "message"       => $r["message"]
    );
}


/** Função pra enviar mensagem de texto */
function m_text($instance, $token, $contact, $message)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api2.megaapi.com.br/rest/sendMessage/' . $instance . '/text',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
        "messageData": {
            "to": "' . replaceChatid($contact) . '",
            "text": "' . $message . '"
        }
    }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "whatsapp"       => $r["messageData"]["key"]["remoteJid"],
        "from"           => $r["messageData"]["key"]["fromMe"],
        "id"             => $r["messageData"]["key"]["id"],
    );
}


/** Função para enviar arquivos de imagem */
function m_mediaUrl($instance, $token, $contact, $urlFile, $filename, $type, $caption, $mimeType){

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api2.megaapi.com.br/rest/sendMessage/' . $instance . '/mediaUrl',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "messageData": {
            "to": "' . replaceChatid($contact) . '",
            "url": "' .$urlFile. '",
            "fileName": "' .$filename. '",
            "type": "' .$type. '",
            "caption": "' .$caption. '",
            "mimeType": "' .$mimeType. '"
        }
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "whatsapp"       => $r["messageData"]["key"]["remoteJid"],
        "from"           => $r["messageData"]["key"]["fromMe"],
        "id"             => $r["messageData"]["key"]["id"],
    );
}


/** Função para enviar arquivos de imagem em Base64 */
function m_mediaBase64($instance, $token, $contact, $file, $filename, $type, $caption, $mimeType){

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api2.megaapi.com.br/rest/sendMessage/' . $instance . '/mediaBase64',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "messageData": {
            "to": "' . replaceChatid($contact) . '",
            "base64": "' .$file. '",
            "fileName": "' .$filename. '",
            "type": "' .$type. '",
            "caption": "' .$caption. '",
            "mimeType": "' .$mimeType. '"
        }
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "whatsapp"       => $r["messageData"]["key"]["remoteJid"],
        "from"           => $r["messageData"]["key"]["fromMe"],
        "id"             => $r["messageData"]["key"]["id"],
    );

}


/* Função para enviar localização */
function m_location($instance, $token, $contact, $address, $caption, $latitude, $longitude){

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api2.megaapi.com.br/rest/sendMessage/' . $instance . '/location',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "messageData": {
            "to": "' . replaceChatid($contact) . '",
            "address": "' .$address. '",
            "caption": "' .$caption. '",
            "latitude": '.$latitude.',
            "longitude": '.$longitude.'
        }
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "whatsapp"       => $r["messageData"]["key"]["remoteJid"],
        "from"           => $r["messageData"]["key"]["fromMe"],
        "id"             => $r["messageData"]["key"]["id"],
    );

}


/* Função para enviar mensagem com um link com vizualização */
function m_templateMensage($instance, $token, $contact, $message, $title1, $title2, $linkPayload1, $title3, $linkPayload2, $footerText){

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api2.megaapi.com.br/rest/sendMessage/' . $instance . '/templateMessage',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "messageData": {
            "to": "' . replaceChatid($contact) . '",
            "text": "' .$message. '",
            "buttons": [
                {
                    "type": "replyButton",
                    "title": "' .$title1. '"
                },
                {
                    "type": "urlButton",
                    "title": "' .$title2. '",
                    "payload": "' .$linkPayload1. '"
                },
                {
                    "type": "callButton",
                    "title": "' .$title3. '",
                    "payload": "'.$linkPayload2.'"
                }
            ],
            "footerText": "' .$footerText. '"
        }
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "whatsapp"       => $r["messageData"]["key"]["remoteJid"],
        "from"           => $r["messageData"]["key"]["fromMe"],
        "id"             => $r["messageData"]["key"]["id"],
    );
    
}


/* Função para enviar mensagem com um link e imagem com vizualização */
function m_templateMessageWithMedia($instance, $token, $contact, $message, $title1, $title2, $linkPayload1, $title3, $linkPayload2, $footerText, $imageUrl, $mediaType, $mimeType){

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api2.megaapi.com.br/rest/sendMessage/' . $instance . '/templateMessageWithMedia',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "messageData": {
            "to": "' . replaceChatid($contact) . '",
            "text": "' .$message. '",
            "buttons": [
                {
                    "type": "replyButton",
                    "title": "' .$title1. '"
                },
                {
                    "type": "urlButton",
                    "title": "' .$title2. '",
                    "payload": "' .$linkPayload1. '"
                },
                {
                    "type": "callButton",
                    "title": "' .$title3. '",
                    "payload": "' .$linkPayload2. '"
                }
            ],
            "footerText": "' .$footerText. '",
            "imageUrl": "' . $imageUrl. '",
            "mediaType": "' .$mediaType. '",
            "mimeType": "' .$mimeType. '"
        }
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "whatsapp"       =>  $r["messageData"]["key"]["remoteJid"],
        "from"           => $r["messageData"]["key"]["fromMe"],
        "id"             => $r["messageData"]["key"]["id"],
    );
}


/* Função para enviar uma mensagem com botões */
function m_listMessage($instance, $token, $contact, $buttonText, $message, $title1, $description, $titleSection1, $titleRow1, $descriptionRow1, $rowId1){

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api2.megaapi.com.br/rest/sendMessage/' . $instance . '/listMessage',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "messageData": {
            "to": "' . replaceChatid($contact) . '",
            "buttonText": "'.$buttonText.'",
            "text": "' .$message. '",
            "title": "' .$title1 .'",
            "description": "' .$description. '",
            "sections": [
                {
                    "title": "'.$titleSection1.'",
                    "rows": [
                        {
                            "title": "'. $titleRow1.'",
                            "description": "'.$descriptionRow1.'",
                            "rowId": "'.$rowId1.'"
                        }
                    ]
                }
            ],
            "listType": 0
        }
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "whatsapp"       => $r["messageData"]["key"]["remoteJid"],
        "from"           => $r["messageData"]["key"]["fromMe"],
        "id"             => $r["messageData"]["key"]["id"],
    );
}


/* Função para enviar um contato */
function m_contactMessage($instance, $token, $contact, $fullName, $displayName, $organization, $phoneNumber){

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api2.megaapi.com.br/rest/sendMessage/' . $instance . '/contactMessage',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
      "messageData": {
        "to": "' . replaceChatid($contact) . '",
        "vcard": {
          "fullName": "' .$fullName. '",
          "displayName": "' .$displayName. '",
          "organization": "' .$organization. '",
          "phoneNumber": "' .replaceChatid($phoneNumber). '"
        }
      }
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    $r = json_decode($response, true);
    return array(
        "whatsapp"       => $r["messageData"]["key"]["remoteJid"],
        "from"           => $r["messageData"]["key"]["fromMe"],
        "id"             => $r["messageData"]["key"]["id"],
    );

}


