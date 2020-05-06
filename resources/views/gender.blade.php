
<canvas id="doughnut" width="200" height="200"></canvas>
<script src="{{ URL::asset('vendor/laravel-admin/chartJs/Chart.bundle.min.js') }}?1.0"></script>
<script>
$(function () {

    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    {{ isset($gender['1'])?$gender['1']:0 }},
                    {{ isset($gender['2'])?$gender['2']:0 }},
                    {{ isset($gender['0'])?$gender['0']:0 }}
                ],
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 205, 86)'
                ]
            }],
            labels: [
                '男',
                '女',
                '保密'
            ]
        },
        options: {
            maintainAspectRatio: false
        }
    };

    var ctx = document.getElementById('doughnut').getContext('2d');
    new Chart(ctx, config);
});
</script>

{{--<canvas id="type" width="200" height="200"></canvas>--}}
{{--<script>--}}
{{--    $(function () {--}}

{{--        var config1 = {--}}
{{--            type: 'doughnut',--}}
{{--            data: {--}}
{{--                datasets: [{--}}
{{--                    data: [--}}
{{--                        {{ isset($user_type['1'])?$user_type['1']:0 }},--}}
{{--                        {{ isset($user_type['2'])?$user_type['2']:0 }},--}}
{{--                        {{ isset($user_type['0'])?$user_type['0']:0 }}--}}
{{--                    ],--}}
{{--                    backgroundColor: [--}}
{{--                        'rgb(54, 162, 235)',--}}
{{--                        'rgb(255, 99, 132)',--}}
{{--                        'rgb(255, 205, 86)'--}}
{{--                    ]--}}
{{--                }],--}}
{{--                labels: [--}}
{{--                    '普通用户',--}}
{{--                    '二级代理',--}}
{{--                    '一级代理'--}}
{{--                ]--}}
{{--            },--}}
{{--            options: {--}}
{{--                maintainAspectRatio: false--}}
{{--            }--}}
{{--        };--}}

{{--        var ctx1 = document.getElementById('type').getContext('2d');--}}
{{--        new Chart(ctx1, config1);--}}
{{--    });--}}
{{--</script>--}}
