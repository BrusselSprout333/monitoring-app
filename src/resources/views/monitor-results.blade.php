<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/results.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Результаты оценки уровня комфорта</title>
</head>
<body>

@include('includes.header')

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="result-container">
                <h2>Результаты оценки уровня комфорта</h2>
                <p>Исходя из проведенной оценки вашего рабочего места, мы предоставляем следующие рекомендации:</p>
                @if(!empty($recommends))
                <ul class="result-list">
                    @foreach($recommends as $recommend)
                        <li class="result-item">{{ $recommend }}</li>
                    @endforeach
                </ul>
                @else
                    <p>Либо вы не предоставили данные, либо у вас всё идеально ;)</p>
                @endif

                <div class="mt-4" data-comfort-level="{{ $comfortLevel }}">
                    <h3>Оценка комфорта:</h3>
                    <p>Ваш результат: {{ $comfortLevel }} баллов из 100</p>
                    <canvas id="comfortChart"></canvas>
                </div>

                <div class="btn-container"> <!-- TODO: redirect -->
                    <a href="{{ route('home') }}" class="btn btn-secondary">На главную</a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')

<script>
    // Данные для диаграммы
    var ctx = document.getElementById('comfortChart').getContext('2d');
    var comfortLevel = document.querySelector('.mt-4').dataset.comfortLevel;
    var comfortData = [comfortLevel, 100 - comfortLevel];
    var comfortChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Ваш результат', 'Оставшиеся баллы'],
            datasets: [{
                data: comfortData,
                backgroundColor: ['#2e10ad', '#e9ecef'],
                borderColor: ['#fff', '#fff'],
                borderWidth: 2
            }]
        },
        options: {
            legend: {
                display: false
            },
            responsive: false,
            aspectRatio: 1,
            maintainAspectRatio: false,
            width: 300,
            height: 300
        },
    });
</script>

<!-- Подключение Bootstrap JS (необходим для работы некоторых компонентов) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
