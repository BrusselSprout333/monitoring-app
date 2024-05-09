<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
    <title>Просмотр отчетов</title>
</head>
<body>

@include('includes.header')

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="reports-container">
                <h2 style="text-align: center; margin-bottom: 20px;">Отчеты</h2>

                <form action="{{ route('reportsPage') }}" class="form-inline mb-3" method="GET">
                    <input type="date" name="date" class="form-control mr-2" value="{{ $_GET['date'] ?? '' }}" placeholder="Поиск по дате">
                    <button type="submit" class="btn btn-primary" style="background-color: #2e10ad">Искать</button>
                </form>

                @if ($reports->isEmpty())
                    <p>Возможно у вас еще нет отчетов или они не найдены с текущими фильтрами.</p>
                @else
                <ul class="list-group">
                    @foreach ($reports as $report)
                        <li class="list-group-item">
                            <a href="{{ route('report', $report->id) }}" class="flex-link">
                                <p>{{ $report->title }}: {{ $report->date }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{ $reports->appends(['date' => $date])->links('pagination::bootstrap-4') }}
                @endif
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
