<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="container mt-2">
    <div id="error-container"></div>

    <h2 class="mb-4">Create User</h2>

    <form class="order-form" id="createUserForm">
        @csrf
        <div class="mb-3 row">
            <label for="name" class="col-md-2 col-form-label">Name</label>
            <div class="col-md-6">
                <input type="text" name="name" id="name" placeholder="Name"
                       class="form-control" value="{{ old('name') }}" autofocus>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="job" class="col-md-2 col-form-label">Job</label>
            <div class="col-md-6">
                <input type="text" name="job" id="job" placeholder="Job"
                       class="form-control" value="{{ old('job') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary" id="submit-btn">Create</button>
            </div>
        </div>

    </form>
</div>

<script>
    const btn = document.querySelector('#submit-btn');
    const form = document.querySelector('#createUserForm');

    btn.addEventListener('click', (event) => {
        event.preventDefault();
        const formData = new FormData(form);

        fetch("{{ route('create') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    showErrors(data.errors);
                } else {
                    localStorage.setItem('message', 'Employee successfully created');
                    window.location.href = "{{ route('users') }}";
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });


    function showErrors(errors) {
        const errorMessages = Object.values(errors).flat();
        const errorContainer = document.getElementById('error-container');
        errorContainer.classList.add('alert', 'alert-danger');
        errorContainer.innerHTML = '';

        errorMessages.forEach(errorMessage => {
            const errorElem = document.createElement('p');
            errorElem.style.marginBottom = '0';
            errorElem.innerHTML = `${errorMessage}`;
            errorContainer.appendChild(errorElem);
        });
    }
</script>
</body>
</html>
