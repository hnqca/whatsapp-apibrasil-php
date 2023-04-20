<?php

    /**
     * Classe responsável por consumir a API do WhatsApp através da plataforma APIBrasil.
     * https://plataforma.apibrasil.com.br/plataforma/myaccount/apicontrol
    */

    namespace ApiBrasil;

    class WhatsApp {

        private $header  = [];
        private $body    = [];
        private $buttons = [];

        // Endereço do servidor da APIBrasil que será feita as requisições HTTP via cURL.
        const SERVER_ADDRESS = "https://cluster.apigratis.com/api/v1/whatsapp";

        /**
         * Construtor da classe. Recebe as credenciais de autenticação da plataforma APIBrasil.
         * @param array $credentials
         */
        function __construct(array $credentials){
          // Mescla o header da requisição com o array de credenciais passado como parâmetro
          $this->header = array_merge(['Content-type: application/json'], $credentials);
        }

        /**
         * Responsável por enviar mensagens de texto simples.
         * @param  string $phoneNumber
         * @param  string $text
         * @return array
         */
        function sendText(string $phoneNumber, string $text){

            // Define o número de WhatsApp (que receberá a mensagem) e o texto a ser enviado na requisição
            $this->body = [
                'number' => self::formatPhoneNumber($phoneNumber),
                'text'   => $text
            ];

            // Executa a requisição HTTP via cURL e retorna a resposta
            return $this->executeCurl(self::SERVER_ADDRESS."/sendText");
        }

        /**
         * Responsável por enviar uma mensagem com botões.
         * @param  string $phoneNumber
         * @param  array  $content
         * @param  array  $buttons
         * @return array
         */
        function sendButtonMessage(string $phoneNumber, array $content, array $buttons = [])
        {
            // Se não houver botões passados como parâmetro, utiliza os botões definidos anteriormente na classe
            $buttons = $buttons ? $buttons : $this->buttons;

            // Se nenhum botão for definido, lança uma exceção.
            if(!$this->button){
               throw new \Exception("Nenhum botão criado anteriormente.");
            }

            // Define o número de WhatsApp, o conteúdo da mensagem e os botões a serem enviados na requisição
            $content['number'] = self::formatPhoneNumber($phoneNumber);
            $this->body = array_merge($content, ['buttons' => $buttons]);

            // Executa a requisição HTTP via cURL e retorna a resposta
            $response = $this->executeCurl(self::SERVER_ADDRESS."/sendButton");
            
            // Limpa os botões definidos anteriormente na classe
            $this->buttons = [];

            // retorna a resposta do servidor.
            return $response;
        }

        /**
         * Método responsável por enviar imagens.
         * @param  string      $phoneNumber
         * @param  string      $image
         * @param  string|null $caption (opcional)
         * @return array
         */
        function sendImage($phoneNumber, $image, $caption = null){
          return $this->sendFile64($phoneNumber, $image, $caption, 'image');
        }

        /**
         * Método responsável por enviar vídeos.
         * @param string      $phoneNumber
         * @param string      $video
         * @param string|null $caption (opcional)
         * @return array
         */
        function sendVideo($phoneNumber, $video, $caption = null){
            return $this->sendFile64($phoneNumber, $video, $caption, 'video');
        }

        /**
         * Método responsável por enviar arquivos PDF.
         * @param string      $phoneNumber
         * @param string      $pdf
         * @param string|null $title (opcional)
         * @return array
         */
        function sendPDF($phoneNumber, $pdf, $title = null){
          return $this->sendFile64($phoneNumber, $pdf, $title, 'pdf');
      }

      // Método privado responsável por enviar arquivos em base64
      private function sendFile64($phoneNumber, $file, $caption = null, $type){

          // Lista de tipos de arquivo e seus cabeçalhos em base64
          $listFiles = [
              'image' => 'data:image/{{extension}};base64,',
              'video' => 'data:video/mp4;base64,',
              'pdf'   => 'data:application/pdf;base64,'
          ];

          // Obtém a extensão do arquivo
          $extensionFile = pathinfo($file, PATHINFO_EXTENSION);

          // Verifica se o tipo de arquivo é uma imagem
          if($type === "image"){
              // Se a extensão do arquivo não for uma imagem válida, lança uma exceção
              in_array($extensionFile, ["jpeg", "jpg", "png", "gif"]) ? '' :
              throw new \Exception("Informe uma imagem válida. Formatos aceitos: (jpeg|jpg|png|gif)");

              // Substitui o marcador de posição da extensão pelo tipo de extensão real no cabeçalho em base64
              $rewriteExtesionInBase64 = str_replace("{{extension}}", $extensionFile, $listFiles[$type]);
              $listFiles[$type] = $rewriteExtesionInBase64;
          }

          // Verifica se o tipo de arquivo é um PDF
          if($type === "pdf" AND $extensionFile !== "pdf"){
              // Se a extensão do arquivo não for um PDF válido, lança uma exceção
              throw new \Exception("Informe um arquivo do tipo .PDF válido.");
          }

          // Verifica se o tipo de arquivo é um vídeo
          if($type === "video" AND $extensionFile !== "mp4"){
              // Se a extensão do arquivo não for um vídeo MP4 válido, lança uma exceção
              throw new \Exception("Informe um vídeo do tipo .MP4 válido.");
          }

          // Obtém o arquivo em base64
          $fileToBase64 = base64_encode(file_get_contents($file));

          // Cria o corpo da requisição com o número de WhatsApp, o arquivo em base64 e a legenda (se houver)
          $this->body = [
              'number'  => self::formatPhoneNumber($phoneNumber),
              'path'    => $listFiles[$type] . $fileToBase64,
              'caption' => $caption
          ];

          // Remove a legenda se ela for nula.
          if(!$caption){
              unset($this->body['caption']);
          }

          // Executa a requisição cURL para enviar o arquivo
          return $this->executeCurl(self::SERVER_ADDRESS."/sendFile64");
      }

      private function executeCurl(string $url){
        // Inicia uma nova sessão curl
        $curl = curl_init();
    
        // Configura as opções da sessão curl
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode($this->body, true),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $this->header
        ]);
    
        // Executa a requisição e fecha a sessão curl
        $response = curl_exec($curl);
        curl_close($curl);
    
        // Decodifica a resposta da requisição em formato JSON
        // Lança uma exceção caso a resposta seja inválida ou contenha erros
        $response = json_decode($response, true) ?? throw new \Exception("Não foi possível realizar a requisição ao servidor.");
        return $response['error'] ? throw new \Exception($response['message']) : $response;
    }
    
      function createButton($id, $text){
          // Adiciona um botão ao array de botões
          $this->buttons[] = ['id' => $id, 'text' => $text];
      }
      
      static function formatPhoneNumber($phoneNumber) {
          // Remove todos os caracteres não numéricos do número de telefone
          $numberFormated = preg_replace("/[^0-9]/", "", $phoneNumber);
      
          // Lança uma exceção caso o número de WhatsApp seja inválido
          if(!$numberFormated){
              throw new \Exception("Número de WhatsApp inválido!");
          }
      
          // Retorna o número de WhatsApp formatado
          return $numberFormated;
      }
      
    }