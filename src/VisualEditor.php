<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 23.10.18
 * Time: 21:25
 */

namespace Fomvasss\LaravelVisualEditable;

use Illuminate\Database\Eloquent\Model;

abstract class VisualEditor
{
    protected $config;

    /** @var null|string */
    protected $locale = null;

    /**
     * VisualEditorModel constructor.
     *
     * @param null $app
     */
    public function __construct($app = null)
    {
        if (! $app) {
            $app = app();   //Fallback when $app is not given
        }
        $this->app = $app;

        $this->config = $this->app['config'];

        $this->locale = $this->app->getLocale();
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    protected function getEditableResult(string $content, array $attrs = [])
    {
        // TODO
        $res = "<div class='editable-block";
        foreach ($attrs as $key => $attr) {
            $res .= " $key=$attr";
        }
        $res .= ">{$content}</div>";

        if (!empty($attrs['data-url-visual-update'])) {
            $res .= "&nbsp;<div class='editable-update-btn' style='position: absolute;top: 50%;right: 50%'><a href='{$attrs['data-url-visual-update']}'>&#10050;</a></div>&nbsp;";
        }
        if (!empty($attrs['data-url-visual-store'])) {
            $res .= "&nbsp;<div class='editable-store-btn' style='position: absolute;top: 50%;right: 50%'><a href='{$attrs['data-url-visual-store']}'>&#10050;</a></div>&nbsp;";
        }
        if ($attrs['data-url-dashboard-edit']) {
            $res .= "&nbsp;<div class='editable-edit-btn' style='position: absolute;top: 50%;right: 50%'><a href='{$attrs['data-url-dashboard-edit']}' target='_blank'>&#10050;</a></div>&nbsp;";
        }

        return $res;
    }
}