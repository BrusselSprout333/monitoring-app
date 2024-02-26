<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/monitoring.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Мониторинг</title>
</head>
<body>

@include('includes.header')

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="monitoring-container">
                <h2>Длительный мониторинг</h2>
                <p>При включении длительного мониторинга включится камера на вашем компьютере, которая будет отслеживать ваше положения, освещение и перерывы в фоновом режиме.</p>
                <p>Это означает, что вы можете продолжать работать так же, как раньше, но при этом вам будут также приходить уведомления о необходимости изменения условий работы.</p>
                <p>Вы можете отключить мониторинг в любое время, сессия сохранится автоматически и всегда будет доступна в ваших отчетах.</p>
                <div class="btn-div">
                    <button id="startMonitoringBtn" class="btn btn-primary">Начать мониторинг</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')

<!-- Подключение Bootstrap JS (необходим для работы некоторых компонентов) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
