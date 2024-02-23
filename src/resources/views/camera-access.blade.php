<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/camera-access.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Разрешение на использование веб-камеры</title>
</head>
<body>

@include('includes.header')

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="form-container">
                <h2>Разрешить приложению использовать веб-камеру?</h2>
                <p class="mt-3">Разрешив использование веб-камеры, вы предоставите возможность более точного сбора сведений для улучшения вашего комфорта в приложении.</p>
                <form action="{{ route('processCameraAccess') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="webcamPermission" id="allowWebcam" value="allow" checked>
                            <label class="form-check-label" for="allowWebcam" style="color: green">
                                Да, разрешить
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="webcamPermission" id="denyWebcam" value="deny">
                            <label class="form-check-label" for="denyWebcam" style="color: red">
                                Нет, запретить
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="background-color: #2e10ad">Отправить</button>
                </form>
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
