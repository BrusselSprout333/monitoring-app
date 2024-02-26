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

                <!-- Аватарка -->
                <div class="profile-avatar">
                    @if ($user->avatar !== null)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) ?? 'https://via.placeholder.com/150' }}" alt="Аватар">
                    @else
                        <img src='https://via.placeholder.com/150' alt="Аватар">
                    @endif
                </div>

                <!-- Информация о пользователе -->
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

                <!-- Кнопка редактировать -->
                <a href="{{ route('profileEditPage') }}" class="btn btn-primary profile-edit-btn">Редактировать</a>
{{--                TODO: статистика --}}
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
