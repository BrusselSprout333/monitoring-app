<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Редактирование аккаунта</title>
</head>
<body>

@include('includes.header')

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="edit-profile-container">
                <h2>Редактирование личного аккаунта</h2>

                <!-- Аватарка -->
                <div class="edit-profile-avatar">
                    @if ($user->avatar !== null)
                        <img id="preview_avatar" src="{{ asset('storage/avatars/' . $user->avatar) ?? 'https://via.placeholder.com/150' }}" alt="Аватар">
                    @else
                        <img id="preview_avatar" src='https://via.placeholder.com/150' alt="Аватар">
                    @endif
                        <button class="delete-avatar-btn" onclick="deleteAvatar()">&#215;</button>
                </div>

                <!-- Информация о пользователе -->
                <form action="{{ route('editProfile') }}" class="edit-profile-info" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $user->id }}">
                    <input type="hidden" id="delete_avatar" name="delete_avatar" value="0">
                    <div class="file-cover">
                        <input type="file" id="avatar" name="avatar" accept=".jpg, .jpeg, .png" onchange="previewImage(this)">
                    </div>
                    <label for="name">Имя:</label>
                    <input
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        id="name"
                        name="name"
                        value="{{ $user->first_name }}"
                    >
                    @error('name')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror

                    <label for="surname">Фамилия:</label>
                    <input
                        type="text"
                        class="form-control @error('surname') is-invalid @enderror"
                        id="surname"
                        name="surname"
                        value="{{ $user->last_name }}"
                    >
                    @error('surname')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror

                    <label for="email">Почта:</label>
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ $user->email }}"
                    >
                    @error('email')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror

                    <label for="gender">Пол:</label>
                    <select class="form-control" id="gender" name="gender">
                        <option value="">Не выбрано</option>
                        <option value="male" @if($user->gender == 'male') selected @endif>Мужской</option>
                        <option value="female" @if($user->gender == 'female') selected @endif>Женский</option>
                    </select>

                    <label for="age">Возраст:</label>
                    <input
                        type="number"
                        class="form-control @error('age') is-invalid @enderror"
                        id="age"
                        name="age"
                        value="{{ $user->age }}"
                    >
                    @error('age')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror

                    <input type="checkbox" id="change_password_checkbox" name="change_password" {{ $errors->has('old_password') || $errors->has('new_password') ? 'checked' : '' }}>
                    <label for="change_password_checkbox">Изменить пароль</label>

                    <div id="password_fields" style="{{ $errors->has('old_password') || $errors->has('new_password') ? 'display: block;' : 'display: none;' }}">
                        <label for="old_password">Текущий пароль:</label>
                        <input
                            type="password"
                            class="form-control @error('old_password') is-invalid @enderror"
                            id="old_password"
                            name="old_password"
                        >
                        @error('old_password')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror

                        <label for="new_password">Новый пароль:</label>
                        <input
                            type="password"
                            class="form-control @error('new_password') is-invalid @enderror"
                            id="new_password"
                            name="new_password"
                        >
                        @error('new_password')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="edit-profile-btns text-center">
                        <button class="btn btn-primary edit-profile-btn" type="submit">Сохранить</button><br>
                        <button class="btn btn-danger delete-account-btn" id="deleteAccountBtn">Удалить аккаунт</button>

                        <!-- Модальное окно подтверждения удаления -->
                        <div id="confirmDeleteModal" class="modal">
                            <div class="modal-content">
                                <p>Вы уверены, что хотите удалить аккаунт? Все ваши данные будут стерты</p>
                                <div class="modal-buttons">
                                    <button id="cancelDeleteBtn">Отмена</button>
                                    <button id="confirmDeleteBtn">Да</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteAccountBtn = document.getElementById('deleteAccountBtn');
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

        deleteAccountBtn.addEventListener('click', function(event) {
            event.preventDefault();
            confirmDeleteModal.style.display = 'block';
        });

        cancelDeleteBtn.addEventListener('click', function(event) {
            event.preventDefault();
            confirmDeleteModal.style.display = 'none';
        });

        confirmDeleteBtn.addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = "{{ route('deleteAccount', $user->id) }}";
        });
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                $('#preview_avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function deleteAvatar() {
        $.ajax({
            url: '{{ route("deleteAvatar") }}',
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'avatar': '{{ $user->avatar }}',
                'id': '{{ $user->id }}'
            },
            success: function() {
                $('#preview_avatar').attr('src', 'https://via.placeholder.com/150');
                $('#avatar').val('');
                $('#delete_avatar').val('1');
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        const changePasswordCheckbox = document.getElementById('change_password_checkbox');
        const passwordFields = document.getElementById('password_fields');

        changePasswordCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordFields.style.display = 'block';
            } else {
                passwordFields.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>
