<?php
namespace App\Admin\Extensions;

use Encore\Admin\Actions\RowAction;
use Encore\Admin\Admin;

class CommissionInfoList extends RowAction {
    protected $id;

    protected $year_month;

    protected $routeName;

    protected $cn_name;

    /**
     * ModelDelete constructor.
     * @param $id
     * @param $controllerName
     */
    public function __construct($id, $year_month, $routeName, $cn_name)
    {
        $this->id = $id;
        $this->year_month = $year_month;
        $this->routeName = $routeName;
        $this->cn_name = $cn_name;
    }

    protected function script()
    {
        return '';
    }

    public function render() {
        Admin::script($this->script());
        $url = route($this->routeName, [$this->id, $this->year_month]);
        return "<a class='check-draw-month' href='{$url}'>{$this->cn_name}</a>";
    }

    public function __toString()
    {
        return $this->render();
    }

}
