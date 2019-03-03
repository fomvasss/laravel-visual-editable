<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 23.10.18
 * Time: 21:25
 */

namespace Fomvasss\LaravelVisualEditable;

use Illuminate\Database\Eloquent\Model;

class ModelVisualEditor extends VisualEditor
{
    /**
     * @param $model
     * @param $field
     * @param string $defaultContent
     * @return string
     */
    public function render($model, $field, $defaultContent = '')
    {
        $content = $model->{$field} ?? $defaultContent;

        if ($model->isEditableNow()) {
            return $this->getEditableResult($content, [
                'data-key' => $model->getKey(),
                'data-field' => $field,
                'data-url-dashboard-edit' => $model->getEditableUrlDashboardEdit(),
                'data-url-visual-update' => $model->getEditableUrlVisualUpdate(),
                'data-url-visual-store' => $model->getEditableUrlVisualStore(),
                'contenteditable' => 'true',
            ]);
        }

        return \StrToken::setText($content)->setEntity($model)->replace();
    }
}