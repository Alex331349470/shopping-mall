<?php
namespace App\Admin\Extensions;

use Encore\Admin\Actions\RowAction;
use Encore\Admin\Admin;

class BonusFlush extends RowAction {
    protected $user_id;

    protected $year_month;

    protected $cn_name;

    /**
     * ModelDelete constructor.
     * @param $id
     * @param $controllerName
     */
    public function __construct($user_id, $year_month, $cn_name)
    {
        $this->user_id = $user_id;
        $this->year_month = $year_month;
        $this->cn_name = $cn_name;
    }

    protected function script()
    {
        return <<<SCRIPT
$(".check-draw-money").on('click', function() {
    var id = $(this).data('id');
    var month = $(this).data('month');
    
    swal({
        title: "确认清除绩效？",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "确认",
        showLoaderOnConfirm: true,
        cancelButtonText: "取消",
        preConfirm: function() {
            $.ajax({
                method: 'post',
                url: '/admin/wx/commission/flush',
                data: {year_month: month, user_id: id},
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
        return "<a class='check-draw-money' data-id='{$this->user_id}' data-month='{$this->year_month}'>{$this->cn_name}</a>";
    }

    public function __toString()
    {
        return $this->render();
    }

}
