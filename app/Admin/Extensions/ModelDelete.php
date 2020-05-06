<?php
namespace App\Admin\Extensions;

use Encore\Admin\Actions\RowAction;
use Encore\Admin\Admin;

class ModelDelete extends RowAction {
    protected $id;

    protected $controllerName;

    /**
     * ModelDelete constructor.
     * @param $id
     * @param $controllerName
     */
    public function __construct($id, $controllerName)
    {
        $this->id = $id;
        $this->controllerName = $controllerName;
    }

    protected function script()
    {
        return <<<SCRIPT
$(".check-draw-money").on('click', function() {
    var id = $(this).data('id');
    var name = $(this).data('name');
    
    swal({
        title: "确认删除？",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "确认",
        showLoaderOnConfirm: true,
        cancelButtonText: "取消",
        preConfirm: function() {
            $.ajax({
                method: 'post',
                url: '/admin/wx/' + name + '/' + id,
                data: {_method:"DELETE"},
                success: function (data) {
                    location.reload();
                },
                error: function(response, status, error) {
                    var result = response.responseJSON;
                    swal(result.message, '', 'error');
                }
            });
        }
    });

});
SCRIPT;

    }

    public function render() {
        Admin::script($this->script());
        return "<a class='check-draw-money' data-id='{$this->id}' data-name='{$this->controllerName}'>删除</a>";
    }

    public function __toString()
    {
        return $this->render();
    }

}
