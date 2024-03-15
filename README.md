
# Laravel Brasil CEPs: Consulta e Gerenciamento de CEPs

O **Laravel Brasil CEPs** é um pacote desenvolvido para facilitar a consulta e o gerenciamento de CEPs (Códigos de Endereçamento Postal) brasileiros em aplicações Laravel, oferecendo uma integração rápida e eficiente com dados de endereçamento postal do Brasil. Este pacote permite a importação de dados referentes a estados, cidades, distritos e endereços, além de disponibilizar uma API para consulta de CEPs de forma prática e ágil.

## Recursos do Pacote

- Importação automática de dados para estados, cidades, distritos e endereços brasileiros.
- Configuração flexível, incluindo personalização de prefixos de tabelas.
- Endpoint pronto para consulta de informações por CEP.
- Facilidade de integração com projetos Laravel existentes.

## Como Instalar o Laravel Brasil CEPs

### Instalação via Composer

Inicie a instalação do pacote através do Composer executando o seguinte comando no terminal do seu projeto Laravel:

```bash
composer require samuelrochac/laravel-brasil-ceps
```

### Configuração do ServiceProvider

Após a conclusão da instalação, adicione o `CepServiceProvider` ao array de providers no arquivo `config/app.php`:

```php
'providers' => [
    // Outros Service Providers...
    Samuelrochac\LaravelBrasilCeps\CepServiceProvider::class,
],
```

### Publicação das Configurações

Utilize o comando Artisan abaixo para publicar o arquivo de configuração do pacote no seu projeto Laravel. Isso permitirá que você customize as configurações conforme a necessidade do seu projeto, como ajustar o prefixo das tabelas no banco de dados:

```bash
php artisan vendor:publish --provider="Samuelrochac\LaravelBrasilCeps\CepServiceProvider"
```

Após a publicação, o arquivo `brasil_ceps.php` estará disponível no diretório `config`.

### Personalização do Prefixo das Tabelas

Para modificar o prefixo padrão das tabelas de banco de dados, edite o arquivo `config/brasil_ceps.php`:

```php
<?php

return [
    'db_prefix' => 'bzc_', // Altere conforme necessário
];
```

## Importação de Dados

Com a configuração concluída, importe os dados de CEPs para o seu banco de dados utilizando o comando Artisan:

```bash
php artisan import:zipcodes
```

## Testando o Endpoint de Consulta de CEP

Para verificar o funcionamento do pacote e a consulta de informações por CEP, acesse:

```
http://seu_dominio.com/api/cep/01423010/json
```

Altere `seu_dominio.com` para o domínio ou IP onde sua aplicação Laravel está rodando.

## Contribuições e Suporte

Contribuições são sempre bem-vindas. Para contribuir, faça um fork do repositório, crie um branch para sua feature ou correção, e submeta um pull request.

Para reportar bugs ou solicitar novas funcionalidades, por favor, abra uma issue no GitHub.

## Licença

Este pacote é distribuído sob a licença MIT. Para mais informações, consulte o arquivo [LICENSE](LICENSE.md) incluído com o código fonte.
