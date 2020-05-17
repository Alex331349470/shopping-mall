
<canvas id="type" width="200" height="200"></canvas>
<script src="{{ URL::asset('vendor/laravel-admin/chartJs/Chart.bundle.min.js') }}?1.0"></script>
<script>
$(function () {

    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    {{ isset($user_type['0'])?$user_type['0']:0 }},
                    {{ isset($user_type['1'])?$user_type['1']:0 }},
                    {{ isset($user_type['2'])?$user_type['2']:0 }},
                ],
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 205, 86)'
                ]
            }],
            labels: [
                '普通用户',
                '二级代理',
                '一级代理'
            ]
        },
        options: {
            maintainAspectRatio: false
        }
    };

    var ctx = document.getElementById('type').getContext('2d');
    new Chart(ctx, config);
});
</script>
