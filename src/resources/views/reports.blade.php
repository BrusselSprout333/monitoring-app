<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
            color: #495057;
        }

        .navbar-brand img {
            margin-right: 10px;
        }

        .reports-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .reports-container h2 {
            color: #2e10ad;
        }

        .pagination {
            justify-content: center;
        }

        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .list-group-item:hover {
            background-color: #e3e3e3;
        }

        .footer {
            background-color: #2e10ad;
            color: #fff;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }

        .download-btn {
            color: #fff;
            background-color: #2e10ad;
        }
    </style>
    <title>Просмотр отчетов</title>
</head>
<body>

@include('includes.header')

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="reports-container">
                <h2 style="text-align: center; margin-bottom: 20px;">Отчеты</h2>

                <!-- Search Form -->
                <form class="form-inline mb-3">
                    <input type="text" class="form-control mr-2" placeholder="Поиск по названию">
                    <button type="submit" class="btn btn-primary" style="background-color: #2e10ad">Искать</button>
                </form>

                <!-- Report List -->
                <ul class="list-group">
                    <li class="list-group-item">
                        Отчет №1: 25.04.2023
                       <img width="20px" src="{{ asset('assets/images/download.png') }}" alt="">
                    </li>
                    <li class="list-group-item">
                        Отчет №2: 26.04.2023
                        <img width="20px" src="{{ asset('assets/images/download.png') }}" alt="">                    </li>
                    <li class="list-group-item">
                        Отчет №3: 27.04.2023
                        <img width="20px" src="{{ asset('assets/images/download.png') }}" alt="">                    </li>
                    <li class="list-group-item">
                        Отчет №4: 28.04.2023
                        <img width="20px" src="{{ asset('assets/images/download.png') }}" alt="">                    </li>
                    <li class="list-group-item">
                        Отчет №5: 29.04.2023
                        <img width="20px" src="{{ asset('assets/images/download.png') }}" alt="">                    </li>
                </ul>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination mt-3">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Предыдущая</a>
                        </li>
                        <li class="page-item active" style="background-color: #2e10ad"><a class="page-link" href="#" style="background-color: #2e10ad">1</a></li>
                        <li class="page-item"><a class="page-link" href="#" style="color: #2e10ad">2</a></li>
                        <li class="page-item"><a class="page-link" href="#"  style="color: #2e10ad">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"  style="color: #2e10ad">Следующая</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')

<!-- Подключение Bootstrap JS (необходим для работы некоторых компонентов) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/2f482b036e.js" crossorigin="anonymous"></script>

</body>
</html>
