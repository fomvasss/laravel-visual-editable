<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 23.10.18
 * Time: 21:25
 */

namespace Fomvasss\LaravelVisualEditable;

use Illuminate\Database\Eloquent\Model;

class BlockVisualEditor extends VisualEditor
{
    /** @var string */
    protected $blade = '';

   /**
     * @param mixed $blade
     */
    public function blade(string $blade): self
    {
        $this->blade = $blade;

        return $this;
    }

    /**
     * @param string $body
     * @return string
     */
    public function render(string $alias, string $defaultBody = ''): string
    {
        $model = $this->getModelBlock($alias, $this->locale);
        $content = $model->body ?: $defaultBody;

        if ($blade = $this->getBladeFullPath($model, $alias, $this->blade)) {
            $content = view($blade, ['block' => $model, 'content' => $content])->render();
        }

        if ($model->isEditableNow()) {
            return $this->getEditableResult($content, [
                'data-key' => $model->getKey(),
                'data-field' => 'body',
                'data-url-dashboard-edit' => $model->getEditableUrlDashboardEdit(),
                'data-url-visual-update' => $model->getEditableUrlVisualUpdate(),
                'data-url-visual-store' => $model->getEditableUrlVisualStore(),
                'contenteditable' => 'true',
            ]);
        }

        return \StrToken::setText($content)->setEntity($model)->replace();
    }

    /**
     * @param string $alias
     * @param array $attrs
     * @return mixed
     * @throws \Exception
     */
    public function include(string $alias, array $attrs = [])
    {
        $block = $this->getModelBlock($alias, $this->locale);

        if ($blade = $this->getBladeFullPath($block, $alias, $this->blade)) {
            return view($blade, compact('block', 'attrs'))->render();
        }

        throw new \Exception("Blade-file for block '$alias' not found!");
    }

    /**
     * @param $blockModel
     * @param string $alias
     * @param string $blade
     * @return string
     */
    protected function getBladeFullPath($blockModel, string $alias, string $blade = ''): string
    {
        if ($blade && view()->exists($blade)) {
            return $blade;
        }

        if ($blockModel->blade && view()->exists($blockModel->blade)) {
            return $blockModel->blade;
        }

        $bladePath = trim($this->config->get('visual-editable.blocks.blade_dir'), '.') . '.' . $alias;
        if (view()->exists($bladePath)) {
            return $bladePath;
        }

        return '';
    }

    /**
     * @return \App\Models\Block
     */
    protected function getModelBlock($alias, $locale)
    {
        $modelClass = $this->config->get('visual-editable.blocks.model');

        return $modelClass::smartFirstOrNew($alias, $locale);
    }
}