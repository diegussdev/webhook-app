# WebhooK App

## Fake Requester
- Endpoint que permite simular respostas
- Passando o parâmetro "code" é possível pré-definir o codigo HTTP de retorno
- Passando o parâmetro "timeout" é possível pré-definir o tempo em segundos que o serviço deve esperar até responder
- Passando um body na requisição, o mesmo sera retornado como resposta
- Tudo funciona em conjunto

## Webhook
- Gerar endpoint por seção
- Armazenar requisições em cache
- Exibir requisições recebidas
- Permite limpar dados em cache referentes ao endpoint armazenado na seção
- Permite definir o codigo HTTP de retorno pela url do Webhook
- A rota '/generateWebhookRequests' gera uma requisição para cada método HTTP para testar o recebimento dos Webhooks
