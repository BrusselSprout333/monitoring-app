<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Личный кабинет</title>
</head>
<body>

@include('includes.header')

<div class="container">
    <div class="row" style="margin-top: 20px">
        <div class="col-md-8 mx-auto">
            <div class="profile-container">
                <h2>Личный кабинет</h2>

                <div class="profile-avatar">
                    @if ($user->avatar !== null)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) ?? 'https://via.placeholder.com/150' }}" alt="Аватар">
                    @else
                        <img src='https://via.placeholder.com/150' alt="Аватар">
                    @endif
                </div>

                <div class="profile-info">
                    <label>Имя:</label>
                    <p>{{ $user->first_name . ' ' . $user->last_name }}</p>

                    <label>Почта:</label>
                    <p>{{ $user->email }}</p>

                    <label>Пол:</label>
                    <p>{{ $user->gender == 'male' ? 'Мужчина' : ($user->gender == 'female' ? 'Женщина' : '-') }}</p>

                    <label>Возраст:</label>
                    <p>{{ $user->age ? $user->age . ' лет' : '-' }}</p>
                </div>

                <a href="{{ route('profileEditPage') }}" class="btn btn-primary profile-edit-btn">Редактировать</a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row" style="margin-top: 20px">
        <div class="col-md-8 mx-auto">
            <div class="profile-stats">
                <h3>Статистика</h3>
                @if(!empty($monitoringData) && !empty($monitoringData[0]))
                    <div>
                        <canvas id="monitoringChart" width="800" height="400"></canvas>
                    </div>
                    <p>Последняя сессия: <span class="lastDate" style="color: black;"></span></p>
                    <div class="statistics">
                        <p class="rateStats"></p>
                        <p class="brightnessStats"></p>
                    </div>
                @else
                    <p>Статистика появится после первой сессии мониторинга.</p>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var monitoringData = @json($monitoringData);

    var dates = [];
    var rates = [];
    var brightness = [];
    var x = [];
    var y = [];
    var distance = [];

    monitoringData.forEach(function(item) {
        var date = new Date(item.date);
        var formattedDate = ('0' + date.getDate()).slice(-2) + '.' + ('0' + (date.getMonth() + 1)).slice(-2) + '.' + date.getFullYear();
        dates.push(formattedDate);
        rates.push(item.rate);
        brightness.push(item.totalBrightness);
        x.push(item.totalX);
        y.push(item.totalY);
        distance.push(item.totalDistance);
    });

    var lastDate = document.querySelector('.lastDate');
    if (monitoringData.length > 0) {
        var initialDate = new Date(monitoringData[monitoringData.length - 1].date);
        var duration = monitoringData[monitoringData.length - 1].duration;

        var endDate = new Date(initialDate.getTime() + (duration * 60000));

        var formattedInitialDate = formatDate(initialDate);
        var formattedEndDate = formatDate(endDate, false);

        lastDate.textContent = formattedInitialDate + ' – ' + formattedEndDate;
    }

    function formatDate(date, withDay = true) {
        var year = date.getFullYear();
        var month = ('0' + (date.getMonth() + 1)).slice(-2);
        var day = ('0' + date.getDate()).slice(-2);
        var hours = ('0' + date.getHours()).slice(-2);
        var minutes = ('0' + date.getMinutes()).slice(-2);

        if(withDay) {
            return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes;
        } else {
            return hours + ':' + minutes;
        }
    }

    var statisticsDiv = document.querySelector('.rateStats');

    function compareBrightness() {
        if (monitoringData.length > 0) {
            var currentBrightness = Math.round(monitoringData[monitoringData.length - 1].totalBrightness * 100 / 255);
            var previousBrightness = Math.round(monitoringData.length > 1 ? monitoringData[monitoringData.length - 2].totalBrightness * 100 / 255 : 0);

            if ((currentBrightness >= 19.5 && currentBrightness <= 70.5) &&
                (!previousBrightness || previousBrightness < 19.5 || previousBrightness > 70.5)) {
                return 'Яркость: <span style="color: green;">' + currentBrightness + '% &#8593; </span>' + '<span style="color: grey; font-size: 14px;">' + previousBrightness + '%</span>' + '<br>';
            } else if ((currentBrightness < 19.5 || currentBrightness > 70.5) &&
                (previousBrightness >= 19.5 && previousBrightness <= 70.5)) {
                return 'Яркость: <span style="color: red;">' + currentBrightness + '% &#8595; </span>' + '<span style="color: grey; font-size: 14px;">' + previousBrightness + '%</span>' + '<br>';
            } else {
                return 'Яркость: <span style="color: black;">' + currentBrightness + '% - </span>' + '<span style="color: grey; font-size: 14px;">' + previousBrightness + '%</span>' + '<br>';
            }
        }
    }

    function compareDistance() {
        if (monitoringData.length > 0) {
            var currentDistance = Math.round(monitoringData[monitoringData.length - 1].totalDistance);
            var previousDistance = Math.round(monitoringData.length > 1 ? monitoringData[monitoringData.length - 2].totalDistance : 0);

            if ((currentDistance >= 50 && currentDistance <= 70) &&
                (!previousDistance || previousDistance < 50 || previousDistance > 70)) {
                return 'Расстояние от экрана: <span style="color: green;">' + currentDistance + 'см &#8593; </span>' + '<span style="color: grey; font-size: 14px;">' + previousDistance + 'см</span>' + '<br>';
            } else if ((currentDistance < 50 || currentDistance > 70) &&
                (previousDistance >= 50 && previousDistance <= 70)) {
                return 'Расстояние от экрана: <span style="color: red;">' + currentDistance + 'см &#8595; </span>' + '<span style="color: grey; font-size: 14px;">' + previousDistance + 'см</span>' + '<br>';
            } else {
                return 'Расстояние от экрана: <span style="color: black;">' + currentDistance + 'см - </span>' + '<span style="color: grey; font-size: 14px;">' + previousDistance + 'см</span>' + '<br>';
            }
        }
    }

    function compareXPosition() {
        let previousText;
        let currentText;
        if (monitoringData.length > 0) {
            var currentX = Math.round(monitoringData[monitoringData.length - 1].totalX);
            var previousX = Math.round(monitoringData.length > 1 ? monitoringData[monitoringData.length - 2].totalX : 0);

            if (currentX >= 300 && currentX <= 600) {
                currentText = 'в центре';
            } else {
                currentText = 'сбоку';
            }

            if (previousX >= 300 && previousX <= 600) {
                previousText = 'в центре';
            } else {
                previousText = 'сбоку';
            }

            if((currentText === 'в центре') && (previousText === 'сбоку')) {
                return 'Положение по горизонтали: <span style="color: green;">в центре' + ' &#8593; </span>' + '<span style="color: grey; font-size: 14px;">сбоку' + '</span>' + '<br>';
            } else if((currentText === 'сбоку') && (previousText === 'сбоку')) {
                return 'Положение по горизонтали: <span style="color: black;">в центре' + ' - </span>' + '<span style="color: grey; font-size: 14px;">сбоку' + '</span>' + '<br>';
            } else if((currentText === 'сбоку') && (previousText === 'в центре')) {
                return 'Положение по горизонтали: <span style="color: red;">сбоку' + ' </span>' + '<span style="color: grey; font-size: 14px;">в центре' + '</span>' + '<br>';
            } else {
                return 'Положение по горизонтали: <span style="color: black;">сбоку' + ' - </span>' + '<span style="color: grey; font-size: 14px;">сбоку' + '</span>' + '<br>';
            }
        }
    }

    function compareYPosition() {
        let previousText;
        let currentText;
        if (monitoringData.length > 0) {
            var currentY = Math.round(monitoringData[monitoringData.length - 1].totalY);
            var previousY = Math.round(monitoringData.length > 1 ? monitoringData[monitoringData.length - 2].totalY : 0);

            if (currentY < 100) {
                currentText = 'высоко';
            } else if(currentY > 300) {
                currentText = 'низко';
            } else {
                currentText = 'в центре';
            }

            if (previousY < 100) {
                previousText = 'высоко';
            } else if(previousY > 300) {
                previousText = 'низко';
            } else {
                previousText = 'в центре';
            }

            if((currentText === 'в центре') && (previousText !== 'в центре')) {
                return 'Положение по вертикали: <span style="color: green;">в центре' + ' &#8593; </span>' + '<span style="color: grey; font-size: 14px;">' + previousText + '</span>' + '<br>';
            } else if((currentText !== 'в центре') && (previousText !== 'в центре')) {
                return 'Положение по вертикали: <span style="color: black;">' + currentText + ' - </span>' + '<span style="color: grey; font-size: 14px;">' + previousText + '</span>' + '<br>';
            } else if((currentText !== 'в центре') && (previousText === 'в центре')) {
                return 'Положение по вертикали: <span style="color: red;">' + currentText + ' </span>' + '<span style="color: grey; font-size: 14px;">в центре' + '</span>' + '<br>';
            } else {
                return 'Положение по вертикали: <span style="color: black;">' + currentText + ' - </span>' + '<span style="color: grey; font-size: 14px;">' + previousText + '</span>' + '<br>';
            }
        }
    }

    function compareLastTwoValues(arr) {
        var lastIndex = arr.length - 1;
        var prevIndex = lastIndex - 1;

        var lastValue = arr[lastIndex];
        var prevValue = arr[prevIndex] ?? 0;

        if (lastValue > prevValue) {
            return '<span style="color: green;">' + lastValue + ' &#8593; </span>' + '<span style="color: grey; font-size: 14px;">' + prevValue + '</span>';
        } else if (lastValue === prevValue || !prevValue) {
            return '<span style="color: black;">' + lastValue + ' - </span>' + '<span style="color: grey; font-size: 14px;">' + prevValue + '</span>';
        } else {
            return '<span style="color: red;">' + lastValue + ' &#8595; </span>' + '<span style="color: grey; font-size: 14px;">' + prevValue + '</span>';
        }
    }

    statisticsDiv.innerHTML = 'Общий балл: ' + compareLastTwoValues(rates) + '<br>'
    + compareBrightness() + compareDistance() + compareXPosition() + compareYPosition();

    var ctx = document.getElementById('monitoringChart').getContext('2d');
    var monitoringChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Ваш балл за сессию',
                data: rates,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
