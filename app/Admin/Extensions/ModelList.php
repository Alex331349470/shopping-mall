<?php
namespace App\Admin\Extensions;

use Encore\Admin\Actions\RowAction;
use Encore\Admin\Admin;

class ModelList extends RowAction {
    protected $id;

    protected $routeName;

    protected $cn_name;

    /**
     * ModelDelete constructor.
     * @param $id
     * @param $controllerName
     */
    public function __construct($id, $routeName, $cn_name)
    {
        $this->id = $id;
        $this->routeName = $routeName;
        $this->cn_name = $cn_name;
    }

    protected function script()
    {
        return '';
    }

    public function render() {
        Admin::script($this->script());
        $url = route($this->routeName, $this->id);
        return "<a class='check-draw-money' href='{$url}'>{$this->cn_name}</a>";
    }

    public function __toString()
    {
        return $this->render();
    }

}
