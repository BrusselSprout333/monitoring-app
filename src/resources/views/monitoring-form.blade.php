<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Оценка уровня комфорта - Форма</title>
</head>
<body>

@include('includes.header')

<div class="container form-container mt-5">
    <h1 class="mb-4">Оценка уровня комфорта</h1>
    <p>Заполните форму, чтобы предоставить дополнительные данные для оценки вашего уровня комфорта.
        <br><span class="note-item">*Все поля являются необязательными</span>
    </p>
    <form action="{{ route('showMonitorPage') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="temperature">Температура (°C):</label>
            <input
                type="number"
                class="form-control @error('temperature') is-invalid @enderror"
                id="temperature"
                name="temperature"
                min="-40"
                max="40"
                value="{{ old('temperature') }}"
                autofocus
            >
        </div>
        @error('temperature')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
        <div class="form-group">
            <label for="ventilation-time">Время последнего проветривания:</label>
            <input
                type="datetime-local"
                class="form-control @error('ventilation-time') is-invalid @enderror"
                id="ventilation-time"
                name="ventilation-time"
                value="{{ old('ventilation-time') }}"
            >
        </div>
        @error('ventilation-time')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
        <div class="form-group">
            <label for="break-time">Время последнего перерыва:</label>
            <input
                type="time"
                class="form-control @error('break-time') is-invalid @enderror"
                id="break-time"
                name="break-time"
                value="{{ old('break-time') }}"
            >
        </div>
        @error('break-time')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
        <div class="form-group">
            <label for="screen-brightness">Яркость экрана (%):</label>
            <input
                type="number"
                class="form-control"
                id="screen-brightness"
                name="screen-brightness"
                min="0"
                max="100"
                value="{{ old('screen-brightness') }}"
            >
        </div>
        <div class="form-group">
            <label for="humidity">Влажность воздуха (по вашим ощущениям):</label>
            <select name="humidity" class="form-control" id="humidity">
                <option value="default">Не выбрано</option>
                <option value="low" @if(old('humidity') == 'Низкая') selected @endif>Низкая</option>
                <option value="medium" @if(old('humidity') == 'Средняя') selected @endif>Средняя</option>
                <option value="high" @if(old('Высокая') == 'Высокая') selected @endif>Высокая</option>
            </select>
        </div>
        <div class="form-group">
            <label for="noise">Уровень шума (по вашим ощущениям):</label>
            <select name="noise" class="form-control" id="noise">
                <option value="default">Не выбрано</option>
                <option value="low">Низкий</option>
                <option value="medium">Средний</option>
                <option value="high">Высокий</option>
            </select>
        </div>
        <div class="form-group">
            <label for="water-time">Когда вы последний раз пили воду:</label>
            <input
                type="time"
                class="form-control @error('water-time') is-invalid @enderror"
                id="water-time"
                name="water-time"
                value="{{ old('water-time') }}"
            >
        </div>
        @error('water-time')
            <p class="text-red-500">{{ $message }}</p>
        @enderror

        <button type="button" onclick="window.history.back();" class="btn btn-secondary">Отмена</button>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>

@include('includes.footer')

<!-- Подключение Bootstrap JS (необходим для работы некоторых компонентов) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
