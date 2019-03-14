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

    /**
     * @param string $content
     * @param array $attrs
     * @return string
     */
    protected function getEditableResult(string $content, array $attrs = [])
    {
        $res = "<div class='editable-block'";
        foreach ($attrs as $key => $attr) {
            if (!empty($attr)) {
                $res .= " $key='$attr'";
            }
        }
        $res .= ">{$content}</div>";

        if (!empty($attrs['data-url-editable-store'])) {
            $res .= "&nbsp;<div class='editable-btn editable-store-btn'><a href='{$attrs['data-url-editable-store']}' data-method='POST'>&#10084;</a></div>";
        }

        if (!empty($attrs['data-url-editable-update'])) {
            $res .= "&nbsp;<div class='editable-btn editable-update-btn'><a href='{$attrs['data-url-editable-update']}' data-method='PATCH'>&#10048;</a></div>";
        }

        if (!empty($attrs['data-url-dashboard-edit'])) {
            $res .= "&nbsp;<div class='editable-btn editable-edit-btn'><a href='{$attrs['data-url-dashboard-edit']}' target='_blank'>&#9998;</a></div>";
        }

        return $res;
    }
}