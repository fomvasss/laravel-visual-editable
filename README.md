# Laravel Visual Editor

## Installation

Run from the command line:

```bash
composer require fomvasss/laravel-visual-editor
```
- Install CKEditor & Laravel file manager

- Publish this package assets
- Set configs
- Run migration
- Make model `Models/Block` and extend `Block extends \Fomvasss\LaravelVisualEditable\Models\Block`
- Make POST route for save blocks - simultaneous conservatio (ex: `admin/blocks/visual`)
- Make controller, etc...
- Add js & css to your editable pages (in head, after front css):
```blade
@if(config('visual-editable.available'))
    <!-- Inline CKEditor styles -->
    <link rel="stylesheet" href="/vendor/visual-editable/styles.css">
    <script src="/vendor/visual-editable/jquery-3.3.1.min.js"></script>
    <!-- Inline CKEditor scripts -->
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="/vendor/visual-editable/scripts.js" defer></script>
@endif
``` 
- Add html after open tag <body>:
```blade
<body>
<div id="cke-panel" style="display: none">
    <a class="btn-cke btn-cke-success js-editable-blocks-save"
       data-url="url('admin/blocks/visual')"
       data-locale="ru"
    >Сохранить</a>
</div>
```

- Add in end html doc (after your svripts) - optional
```blade
@if(! config('visual-editable.available'))
<script>
    $('.csrf-form').append('<input type="hidden" name="_token" value="'+$('meta[name="csrf-token"]').attr('content')+'">')
    $('.csrf-form').append('<input type="hidden" name="locale" value="'+$('html').attr('lang')+'">')
</script>
@endif
```

Use facade:
```blade
{!! \BlockVisualEditor::render('top_casino_reviews', '
	<div class="home-head__block-wrapper">
		<h1 class="home-head__name">Top Reviews</h1>
		<p>from bearded Joker</p>
		<span>Get individual bonuses of Some up to $ 1000 on your first deposit now!</span>
		<div class="home-head__button">
			<a href="#">Get your bonus</a>
		</div>
	</div>
') !!}
```

Or with tempate block (tempate in dir: `front.blocks`)  
```blade
	{!! \BlockVisualEditor::include('some_super_block') !!}
```

## Examples usage

## Links