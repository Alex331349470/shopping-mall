<?php
namespace App\Admin\Extensions;

use Encore\Admin\Actions\RowAction;
use Encore\Admin\Admin;

class OrderRefund extends RowAction {
    protected $id;

    protected $route_name;

    protected $cn_name;

    protected $extra;

    /**
     * ModelDelete constructor.
     * @param $id
     * @param $controllerName
     */
    public function __construct($id, $route_name, $cn_name, $extra)
    {
        $this->id = $id;
        $this->route_name = $route_name;
        $this->cn_name = $cn_name;
        $this->extra = $extra;
    }

    protected function script()
    {
        return <<<SCRIPT
$(".check-draw-money").on('click', function() {
    var url = $(this).data('url');
    var extra = $(this).data('extra');
    Swal.fire({
      title: '是否确认退款?',
      text: extra,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '确认',
      cancelButtonText: '拒绝'
    }).then((result) => {
      if (result.value) {
        var formData = new FormData();
        formData.append("agree", 1);
        $.ajax({
            method: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success:function (message) {
                if (message.message) {
                    Swal.fire({
                      title: message.message,
                      text: "",
                      icon: 'warning',
                      showCancelButton: false,
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: 'OK'
                    }).then((result) => {
                      location.reload();
                    })
                } else {
                    alert(JSON.stringify(message));
                    location.reload();
                }
            },
            error:function (message) {
                if (message.responseJSON.message) {
                    Swal.fire(
                      '数据异常',
                      message.responseJSON.message,
                      'error'
                    )
                } else {
                    alert(JSON.stringify(message));
                    location.reload();
                }
            }
        });
      } else {
        Swal.fire({
          title: '拒绝理由',
          input: 'text',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: '确认',
          showLoaderOnConfirm: true,
          preConfirm: (value) => {
          console.log(value);
            var formData = new FormData();
            formData.append("agree", 0);
            formData.append("reason", value);
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success:function (message) {
                    if (message.message) {
                        Swal.fire({
                          title: message.message,
                          text: "",
                          icon: 'warning',
                          showCancelButton: false,
                          confirmButtonColor: '#3085d6',
                          confirmButtonText: 'OK'
                        }).then((result) => {
                          location.reload();
                        })
                    } else {
                        alert(JSON.stringify(message));
                        location.reload();
                    }
                },
                error:function (message) {
                    if (message.responseJSON.message) {
                        Swal.fire(
                          '数据异常',
                          message.responseJSON.message,
                          'error'
                        )
                    } else {
                        alert(JSON.stringify(message));
                    }
                }
            });
          },
          allowOutsideClick: () => !Swal.isLoading()
        })
      }
    })

});
SCRIPT;

    }

    public function render() {
        Admin::script($this->script());
        $url = route($this->route_name, $this->id);
        return "<a class='check-draw-money' data-extra='{$this->extra}' data-url='{$url}'>{$this->cn_name}</a>";
    }

    public function __toString()
    {
        return $this->render();
    }

}
