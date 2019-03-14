(function($) {

    'use strict';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var $ckeBlocks = $('.editable-block')
    $("#cke-panel").show()

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

    CKEDITOR.config.extraPlugins = 'fontawesome,btgrid,youtube,showblocks,tableresize,copycopy';
    CKEDITOR.config.removeButtons = 'Subscript,Superscript,Paste,PasteText,PasteFromWord,Copy,Cut,Scayt,HorizontalRule,About';

    // Set CKE for css class $ckeBlocks - "cke-block"
    $.each($ckeBlocks, function (key) {
        var $this = $(this);
        $this.attr('contenteditable', "true")

        // Add LFM to CKE
        this.editor = CKEDITOR.inline(this, {
            //toolbar : 'Inline',
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        })
    })

    // Find and save all blocks on page.
    $('.js-editable-blocks-save').on('click', function(e) {
        e.preventDefault()
        var $this = $(this),
            url = $this.data('url'),
            locale = $this.data('locale'),
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
            data: {"blocks": dataBlocks, "locale": locale},
            cache: false,
            success: function (result) {
                alert('Success save! :)')
            },
            error: function (result) {
                alert('Error save! :(')
            }
        })
    })

    $ckeBlocks.on('click', function () {
        $('.js-editable-blocks-save').addClass( "disabled")
    })
    $('#cke-panel').on('click', function () {
        $('.js-editable-blocks-save').removeClass("disabled")
    })

    // TODO
     $('.editable-store-btn').on('click', function(e) {
        e.preventDefault()
        var $this = $(this),
            url = $this.data('url-editable-store'),
            block = $(this).prev('.editable-block'),
            locale = block.data('locale'),
            content = block.html()

        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: {"content": content, "locale": locale},
            cache: false,
            success: function (result) {
                alert('Success save! :)')
            },
            error: function (result) {
                alert('Error save! :(')
            }
        })
    })
    // TODO
    $('.editable-update-btn').on('click', function(e) {
        e.preventDefault()
        var $this = $(this),
            url = $this.data('url-editable-update'),
            block = $(this).prev('.editable-block'),
            locale = block.data('locale'),
            content = block.html()

        $.ajax({
            url: url,
            method: 'PATCH',
            dataType: 'json',
            data: {"content": content, "locale": locale},
            cache: false,
            success: function (result) {
                alert('Success save! :)')
            },
            error: function (result) {
                alert('Error save! :(')
            }
        })
    })

})(jQuery)