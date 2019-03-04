<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 03.03.19
 * Time: 20:23
 */

namespace Fomvasss\LaravelVisualEditable\Editable;

interface EditableContract
{
    public function getEditableUrlVisualStore(): string;

    public function getEditableUrlVisualUpdate(): string;

    public function getEditableUrlDashboardEdit(): string;
}