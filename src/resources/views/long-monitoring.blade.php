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

<div id="notification" class="notification hidden">
    <span id="notificationText"></span>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="monitoring-container">
                <div class="flex-title">
                    <h2>Длительный мониторинг</h2>
                    <img class="settings-btn" src="{{ asset('assets/images/settings.png') }}" width="30" height="30" alt="" onclick="openModal()">
                </div>

                <p>При включении длительного мониторинга включится камера на вашем компьютере, которая будет отслеживать ваше положения, освещение и перерывы в фоновом режиме.</p>
                <p>Это означает, что вы можете продолжать работать так же, как раньше, но при этом вам будут также приходить уведомления о необходимости изменения условий работы.</p>
                <p>Вы можете отключить мониторинг в любое время, сессия сохранится автоматически и всегда будет доступна в ваших отчетах.</p>
                <div class="btn-div">
                    <a id="startMonitoringBtn" class="btn btn-primary" onclick="startMonitoring()">Начать мониторинг</a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')

<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="flex-title">
            <h2 class="settings-title">Настройки уведомлений</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <form action="{{ route('monitorPage') }}" method="GET">
            <div class="form-group">
                <label for="breakNotifications">Уведомления о перерывах:</label>
                <input type="checkbox" id="breakNotifications" name="breakNotifications" onchange="toggleBreakFrequency()" checked>
            </div>
            <div id="breakFrequencyField" class="form-group">
                <label for="breakFrequency">Частота перерывов:</label>
                <select id="breakFrequency" name="breakFrequency">
                    <option value="1800">30 мин</option>
                    <option value="2700">45 мин</option>
                    <option value="3600">1 час</option>
                    <option value="5400">1 час 30 мин</option>
                </select>
            </div>
            <div class="form-group">
                <label for="notificationFrequency">Частота отправки уведомлений:</label>
                <select id="notificationFrequency" name="notificationFrequency">
                    <option value="10">10 сек</option>
                    <option value="20">20 сек</option>
                    <option value="30">30 сек</option>
                    <option value="60">1 мин</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary settings-form-btn">Сохранить</button>
        </form>
    </div>
</div>

<!-- Подключение Bootstrap JS (необходим для работы некоторых компонентов) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let xhr;

    function openModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
    }

    function closeModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

    function toggleBreakFrequency() {
        var breakNotifications = document.getElementById("breakNotifications");
        var breakFrequencyField = document.getElementById("breakFrequencyField");
        if (breakNotifications.checked) {
            breakFrequencyField.classList.remove("hidden");
        } else {
            breakFrequencyField.classList.add("hidden");
        }
    }

    function startMonitoring() {
        const button = $("#startMonitoringBtn");
        button.removeClass("btn-primary").text("Нажмите Esc на камере для завершения");
        button.attr("onclick", "");
        button.css({
            "background-color": "white",
            "color": "#2e10ad",
            "border": "2px solid #2e10ad",
            "cursor": "default"
        });

        xhr = new XMLHttpRequest();
        xhr.open('GET', '{{ route("longMonitoring") }}', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 3 && xhr.status === 200) {
                const sentences = xhr.responseText.split('.');
                const notification = $("#notification");

                if (sentences.length >= 2 && sentences[sentences.length - 2]) {
                    notification.removeClass('hidden');
                    notification.html(sentences[sentences.length - 2]);
                } else if(sentences.length === 1) {
                    notification.removeClass('hidden');
                    notification.html(sentences[1]);
                }

                setTimeout(function() {
                    notification.addClass('hidden');
                }, 5000);
            }
            if (xhr.readyState === 4 && xhr.status === 200) {
                const sentences = xhr.responseText.split('.');
                $("#notification").removeClass('hidden').text(sentences[sentences.length - 1]);
                setTimeout(function() {
                    $("#notification").addClass('hidden');
                }, 5000);

                button.removeClass("btn-onmonitor").addClass("btn-primary").text("Начать мониторинг");
                button.attr("onclick", "startMonitoring()");
                button.css({
                    "background-color": "#2e10ad",
                    "color": "white",
                    "cursor": "pointer"
                });
            }
        };
        xhr.send();
    }
</script>
</body>
</html>
