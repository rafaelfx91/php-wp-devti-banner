jQuery(document).ready(function($) {
    // Uploader para imagens
    $(document).on('click', '.devti-banner-upload-image', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var index = button.data('index');
        var container = button.closest('.devti-banner-item');
        var preview = container.find('.devti-banner-image-preview');
        var imageUrl = container.find('.devti-banner-image-url');
        var removeBtn = container.find('.devti-banner-remove-image');
        
        // Cria o uploader
        var uploader = wp.media({
            title: 'Selecione a imagem do banner',
            button: {
                text: 'Usar esta imagem'
            },
            multiple: false
        });
        
        // Quando uma imagem é selecionada
        uploader.on('select', function() {
            var attachment = uploader.state().get('selection').first().toJSON();
            imageUrl.val(attachment.url);
            preview.show().find('img').attr('src', attachment.url);
            removeBtn.show();
        });
        
        // Abre o uploader
        uploader.open();
    });
    
    // Remover imagem
    $(document).on('click', '.devti-banner-remove-image', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var container = button.closest('.devti-banner-item');
        var preview = container.find('.devti-banner-image-preview');
        var imageUrl = container.find('.devti-banner-image-url');
        
        imageUrl.val('');
        preview.hide().find('img').attr('src', '');
        button.hide();
    });
});