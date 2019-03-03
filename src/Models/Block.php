<?php

namespace Fomvasss\LaravelVisualEditable\Models;

use Fomvasss\LaravelVisualEditable\Editable\EditableContract;
use Illuminate\Database\Eloquent\Model;

abstract class Block extends Model implements EditableContract
{
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('visual-editable.block.table_name'));
    }

    public static function smartFirstOrNew($alias, $locale)
    {
        return self::where(function ($q) use ($alias, $locale) {
            $q->where('alias', $alias)->where('locale', $locale);
        })->orWhere('system_name', $alias)->first() ?? new static();
    }
}
