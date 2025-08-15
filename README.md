DevTI Banner - Plugin WordPress

https://img.shields.io/wordpress/plugin/v/devti-banner https://img.shields.io/github/license/seu-usuario/devti-banner

Um plugin WordPress para exibição de banners responsivos em formato de carrossel, com controles avançados de administração.
Recursos Principais

    🖼️ Exibição de múltiplos banners em carrossel

    📱 Totalmente responsivo para todos os dispositivos

    ⚙️ Painel de configuração intuitivo

    ⏱️ Controle do tempo de transição entre banners

    🔗 Links individuais para cada banner

    🎨 Personalização de tamanhos (altura e largura)

Instalação

    Faça o download do plugin aqui

    Acesse seu painel WordPress em Plugins > Adicionar Novo > Enviar Plugin

    Faça upload do arquivo ZIP

    Ative o plugin através do link 'Ativar Plugin'

Ou instale manualmente:
cd wp-content/plugins
git clone https://github.com/seu-usuario/devti-banner.git

Uso

    Acesse Configurações > DevTI Banner para configurar seus banners

    Defina a quantidade, imagens, links e tempo de transição

    Insira o shortcode [devti-banner] em qualquer página/post/widget

Parâmetros opcionais do shortcode:

    class: Adiciona classes CSS personalizadas
    Exemplo: [devti-banner class="meu-banner"]

Capturas de Tela

https:///screenshot-1.png
Configurações do plugin

https:///screenshot-2.png
Exemplo de banner em funcionamento
Requisitos Técnicos

    WordPress 5.8+

    PHP 8.0+

    jQuery (já incluído no WordPress)

Contribuição

Contribuições são bem-vindas! Siga estes passos:

    Faça um fork do projeto

    Crie sua branch (git checkout -b feature/nova-feature)

    Commit suas mudanças (git commit -m 'Adiciona nova feature')

    Push para a branch (git push origin feature/nova-feature)

    Abra um Pull Request

Changelog
1.0.0

    Versão inicial lançada

    Funcionalidades básicas de carrossel

    Painel de administração completo

Licença

Este plugin é licenciado sob a GPLv2 ou posterior. Veja o arquivo LICENSE para mais informações.
Suporte

Para reportar bugs ou solicitar features, por favor abra uma issue.
Estrutura do Projeto

devti-banner/
├── assets/
│   ├── css/
│   │   ├── devti-banner-admin.css
│   │   └── devti-banner-frontend.css
│   └── js/
│       ├── devti-banner-admin.js
│       └── devti-banner-frontend.js
├── includes/
│   ├── class-devti-banner.php
│   ├── class-devti-banner-admin.php
│   └── class-devti-banner-shortcode.php
├── languages/
│   └── devti-banner.pot
├── devti-banner.php
├── README.md
├── LICENSE
└── screenshot-1.png

Documentação para Desenvolvedores
Hooks disponíveis
Filtros

    devti_banner_options - Filtra as opções antes de salvar

    devti_banner_container_classes - Adiciona classes ao container do banner

Actions

    devti_banner_before_container - Executa antes do container do banner

    devti_banner_after_container - Executa após o container do banner

Exemplo de uso avançado

// Adicionar classe CSS personalizada
add_filter('devti_banner_container_classes', function($classes) {
    $classes[] = 'minha-classe-personalizada';
    return $classes;
});

// Adicionar conteúdo antes do banner
add_action('devti_banner_before_container', function() {
    echo '<div class="minha-mensagem">Confira nossos banners!</div>';
});



