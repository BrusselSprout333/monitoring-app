<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Report</title>
</head>
<body>
<h1>Отчет мониторинга</h1>
<p>Пользователь: {{ $user->first_name }} {{ $user->last_name }}</p>
<p>Дата: {{ $data->date }}</p>
<p>Продолжительность сессии: {{ $time }}</p>
<ul style="list-style-type: none;">
    @foreach($recommends as $recommend)
        <li>{{ $recommend }}</li>
    @endforeach
</ul>

<p>Оценка: {{ $data->rate }} баллов</p>

</body>
</html>
