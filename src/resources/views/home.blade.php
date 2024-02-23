<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Уровень комфорта</title>
</head>
<body>
@include('includes.header')

<main>
    <div class="jumbotron">
        <h1 class="display-4">Оцените свой уровень комфорта</h1>
        <p class="lead">Нажмите на кнопку ниже, чтобы начать оценку. Мы заботимся о вашем комфорте!</p>
        <a class="btn btn-primary btn-lg" href="{{ route('monitoringForm') }}" role="button">Начать оценку</a>
    </div>

    <div class="container features">
        <div class="row">
            <div class="col-md-4">
                <h2>Простота использования</h2>
                <p>Оцените свой уровень комфорта с легкостью и быстротой.</p>
            </div>
            <div class="col-md-4">
                <h2>Отчеты и статистика</h2>
                <p>Получайте детальные отчеты о вашем уровне комфорта и мониторьте его динамику.</p>
            </div>
            <div class="col-md-4">
                <h2>Мониторинг параметров</h2>
                <p>Отслеживайте факторы, влияющие на ваш комфорт в реальном времени.</p>
            </div>
        </div>
    </div>
    <hr>
    <div class="container advantages">
        <h2>Почему важно оценивать свой уровень комфорта на рабочем месте?</h2>
        <p>Работа в комфортной обстановке имеет решающее значение для вашего благополучия и производительности. ComfortApp предоставляет вам
            возможность систематически оценивать свой уровень комфорта, а также предоставляет детальные отчеты и рекомендации для улучшения вашего
            рабочего пространства.</p>
        <p>Преимущества использования ComfortApp:</p>
        <ul>
            <li>Максимальная эффективность и производительность на работе.</li>
            <li>Снижение стресса и повышение удовлетворенности работой.</li>
            <li>Индивидуальные рекомендации для улучшения вашего рабочего места.</li>
            <li>Отслеживание динамики изменений и анализ факторов, влияющих на ваш комфорт.</li>
        </ul>
    </div>
</main>

@include('includes.footer')

<!-- Подключение Bootstrap JS (необходим для работы некоторых компонентов) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

