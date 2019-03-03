(function($) {

    'use strict';

    var d = $(document),
        b = d.find('body'),
        w = $(window),
        L = window.Laravel,
        csrf = $('meta[name="csrf-token"]').attr('content'),
        $ckeBlocks = $('.editable-block')

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrf
        }
    });

    CKEDITOR.disableAutoInline = true;
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
    // CKEDITOR.config.config.shiftEnterMode = CKEDITOR.ENTER_P;
    // CKEDITOR.config.autoParagraph = false;
    // CKEDITOR.config.forcePasteAsPlainText = true
    // CKEDITOR.config.fillEmptyBlocks = true;
    CKEDITOR.config.ignoreEmptyParagraph = true;
    CKEDITOR.dtd.$removeEmpty['span'] = 0;
    CKEDITOR.dtd.$removeEmpty['i'] = 0;
    CKEDITOR.dtd.$removeEmpty['p'] = 0;
    CKEDITOR.config.extraPlugins = 'fontawesome';

    $("#cke-panel").show()

    // цепляем редактор на блоки с классом .cke-block
    $.each($ckeBlocks, function (key) {
        var $this = $(this);
        $this.attr('contenteditable', "true")
        // if ($this.data('block-url-edit')) {
        //     $this.after("&nbsp;<div class='cke-edit-btn'><a href='"+$this.data('block-url-edit')+"' target='_blank'>&#10050;</a></div>&nbsp;")
        // }
        this.editor = CKEDITOR.inline(this, {
            //toolbar : 'Inline',
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token='+csrf,
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='+csrf
        })
    })

    // сохранить все блоки страницы
    $('.js-cke-blocks-save').on('click', function(e) {
        e.preventDefault()
        var $this = $(this),
            url = $this.data('url'),
            dataBlocks = {}
        $.each($ckeBlocks, function (key) {
            var block = this.getAttribute('data-alias'),
                html = this.editor.getData()
            if (block) {
                dataBlocks[block] = html
            }
        })
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: {"blocks": dataBlocks},
            cache: false,
            success: function (result) {
                alert('Успешно сохранено!')
            },
            error: function (result) {
                alert('Ошибка сохранения! Попробуйте повторить.')
            }
        })
    })

    $ckeBlocks.on('click', function () {
        $('.js-cke-save').addClass( "disabled")
    })
    $('#cke-panel').on('click', function () {
        $('.js-cke-save').removeClass("disabled")
    })

})(jQuery)