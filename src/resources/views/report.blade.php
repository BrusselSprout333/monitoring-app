<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
    <title>Просмотр отчета</title>
    <style>
        .back {
            background-color: #2e10ad;
            border-color: #2e10ad;
            color: white;
        }

        .back:hover {
            color: white;
        }
    </style>
</head>
<body>

@include('includes.header')
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h2>{{ $report->title }}</h2>
        </div>
        <div class="col text-right">
            <a href="#" id="downloadLink">
                <img class="li-img" src="{{ asset('assets/images/download.png') }}" alt="">
            </a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <p>{!! $report->recordText !!}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <a href="{{ route('reportsPage') }}" class="btn back">Назад</a></button>
        </div>
    </div>
</div>
</body>

@include('includes.footer')

<!-- Подключение Bootstrap JS (необходим для работы некоторых компонентов) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    document.getElementById('downloadLink').addEventListener('click', function() {

        this.setAttribute('download', 'report.html');

        const blob = new Blob([{!! json_encode($report->recordText) !!}], { type: 'text/plain' });

        this.href = window.URL.createObjectURL(blob);
    });
</script>
</body>
</html>
