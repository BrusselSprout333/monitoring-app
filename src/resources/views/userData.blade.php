<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>User</title>
</head>
<body>
<div class="container mt-5 text-center">
    <h2>User</h2>

    <div hidden id="userId">{{ request()->route('id') }}</div>
    <img src="" alt="User photo" id="avatar" style="margin-bottom: 20px">
    <p id="name"></p>
    <p id="email"></p>

    <a href="{{ route('users') }}" class="btn btn-secondary">Back</a>
</div>

<script>
    const userId = document.getElementById('userId').textContent;

    fetch("{{ route('getById', ['id' => ':id']) }}".replace(':id', userId))
        .then(response => {
            if(response.status === 404) {
                localStorage.setItem('error', 'User not found');
                window.location.href = "{{ route('users') }}";
            } else {
                return response.json();
            }
        })
        .then(data => {
            const user = data.data;

            document.getElementById('avatar').src = user.avatar;
            document.getElementById('name').textContent = user.first_name;
            document.getElementById('name').textContent += ' ' + user.last_name;
            document.getElementById('email').textContent = user.email;
        })
        .catch(error => {
            console.error('Error:', error);
        });
</script>
</body>
</html>
