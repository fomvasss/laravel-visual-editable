<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 03.03.19
 * Time: 20:42
 */

namespace Fomvasss\LaravelVisualEditable\Facades;

use Illuminate\Support\Facades\Facade as LFacade;

class ModelVisualEditor extends LFacade
{
    public static function getFacadeAccessor()
    {
        return \Fomvasss\LaravelVisualEditable\ModelVisualEditor::class;
    }
}