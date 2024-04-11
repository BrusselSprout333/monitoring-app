<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Вход в аккаунт</title>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a href="/"><img src="{{ asset('assets/images/gaming-chair.png') }}" width="50" alt="" style="margin-right: 10px"></a>
        <a class="navbar-brand" href="/">ComfortApp</a>
    </nav>
</header>

<main>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="form-container">
                    <h2>Авторизация</h2>
                    <p>Введите свои учетные данные для входа в систему.</p>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="loginEmail">Email: <span class="text-danger">*</span></label>
                            <input
                                type="email"
                                class="form-control @error('loginEmail') is-invalid @enderror"
                                id="loginEmail"
                                name="loginEmail"
                                placeholder="Введите ваш Email"
                                value="{{ old('loginEmail') }}"
                                required
                            >
                        </div>
                        @error('loginEmail')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <div class="form-group">
                            <label for="loginPassword">Пароль: <span class="text-danger">*</span></label>
                            <input
                                type="password"
                                class="form-control @error('loginPassword') is-invalid @enderror"
                                id="loginPassword"
                                name="loginPassword"
                                placeholder="Введите ваш пароль"
                                required
                            >
                        </div>
                        @error('loginPassword')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        @error('authError')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-container">
                    <h2>Регистрация</h2>
                    <p>Зарегистрируйтесь, чтобы начать использование ComfortApp.</p>
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="registerName">Имя: <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control @error('registerName') is-invalid @enderror"
                                id="registerName"
                                name="registerName"
                                placeholder="Введите ваше имя"
                                value="{{ old('registerName') }}"
                                required
                            >
                        </div>
                        @error('registerName')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <div class="form-group">
                            <label for="registerSurname">Фамилия:</label>
                            <input
                                type="text"
                                class="form-control @error('registerSurname') is-invalid @enderror"
                                id="registerSurname"
                                name="registerSurname"
                                placeholder="Введите вашу фамилию"
                                value="{{ old('registerSurname') }}"
                            >
                        </div>
                        @error('registerSurname')
                        <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <div class="form-group">
                            <label for="registerEmail">Email: <span class="text-danger">*</span></label>
                            <input
                                type="email"
                                class="form-control @error('registerEmail') is-invalid @enderror"
                                id="registerEmail"
                                name="registerEmail"
                                placeholder="Введите ваш Email"
                                value="{{ old('registerEmail') }}"
                                required
                            >
                        </div>
                        @error('registerEmail')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <div class="form-group">
                            <label for="registerPassword">Пароль: <span class="text-danger">*</span></label>
                            <input
                                type="password"
                                class="form-control @error('registerPassword') is-invalid @enderror"
                                id="registerPassword"
                                name="registerPassword"
                                placeholder="Введите пароль"
                                required
                            >
                        </div>
                        @error('registerPassword')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <div class="form-group">
                            <label for="registerGender">Пол:</label>
                            <select name="registerGender" class="form-control" id="registerGender">
                                <option value="">Не выбрано</option>
                                <option value="male" @if(old('registerGender') == 'Мужской') selected @endif>Мужской</option>
                                <option value="female" @if(old('registerGender') == 'Женский') selected @endif>Женский</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="registerAge">Возраст:</label>
                            <input
                                type="number"
                                class="form-control"
                                id="registerAge"
                                name="registerAge"
                                min="1"
                                max="150"
                                value="{{ old('registerAge') }}"
                            >
                        </div>

                        <button type="submit" class="btn btn-primary">Создать аккаунт</button>
                    </form>
                </div>
            </div>
        </div>
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
