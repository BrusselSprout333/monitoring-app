<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<table class="table" id="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Job</th>
    </tr>
    </thead>

    <tbody>

    </tbody>
</table>

<script>
    fetch(`{{ route('getAll') }}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            const users = data.data;

            const tableBody = document.getElementById('table').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = '';

            users.forEach(user => {
                console.log(user);
                const row = tableBody.insertRow();

                row.insertCell(0).textContent = user.name;
                row.insertCell(1).textContent = user.job;
            });
        });
</script>
</body>
</html>
