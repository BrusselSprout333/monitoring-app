<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>Users</title>
    <style>
        h1, #create {
            margin-bottom: 20px
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container mt-2">
    <div id="message-container"></div>

    <h1>Users</h1>

    <div class="d-flex align-items-center" id="create">
        <a href="{{ route('createPage') }}" class="btn btn-primary">Add User</a>
    </div>

    <table class="table" id="table">
        <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Photo</th>
            <th>Show</th>
        </tr>
        </thead>

        <tbody class="align-middle">
        {{--    dynamically loaded content  --}}
        </tbody>
    </table>

    <button id="prevButton" class="btn btn-primary" onclick="prevPage()">Previous Page</button>
    <button id="nextButton" class="btn btn-primary" onclick="nextPage()">Next Page</button>
</div>

<script>
    const messageData = localStorage.getItem('message') ?? localStorage.getItem('error');

    if(messageData) {
        const messageType = localStorage.getItem('message') ? 'info' : (localStorage.getItem('error') ? 'error' : '');

        let message = {
            'type': messageType,
            'content': messageData
        }

        showMessage(message);
        localStorage.removeItem('message');
        localStorage.removeItem('error');
    }

    let page = 1;

    const getUsers = (page) => fetch(`{{ route('getAll') }}?page=${page}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if(response.status >= 500) {
                alert('Some error occurred with our server. Please, try again later.');
                return Promise.reject('Server Error');
            } else {
                return response.json();
            }
        })
        .then(data => {
            createContent(data.users);

            document.getElementById('prevButton').disabled = page === 1;
            document.getElementById('nextButton').disabled = !data.hasMorePages;
        })
        .catch(error => {
            console.error('Error:', error);
        });

    //changing pages
    const prevPage = () => {
        if (page > 1) {
            page--;
        }
        getUsers(page);
    };

    const nextPage = () => {
        page++;
        getUsers(page);
    };

    getUsers(page);


    function createContent(users) {
        const tableBody = document.getElementById('table').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';

        users.forEach(user => {
            const row = tableBody.insertRow();

            row.insertCell(0).textContent = user.first_name;
            row.insertCell(1).textContent = user.last_name;
            row.insertCell(2).textContent = user.email;

            let img = new Image();
            img.src = user.avatar;
            img.style.height = '50px';
            img.style.width = '50px';
            row.insertCell(3).append(img);

            const showLinkUrl = `{{ route('userData', ['id' => ':id']) }}`.replace(':id', user.id);
            row.insertCell(4).innerHTML = `
                    <button class="btn btn-primary btn-sm">
                        <a href="${showLinkUrl}" class="text-white">Show</a>
                    </button>
                `;
        });
    }

    function showMessage(message) {
        const errorContainer = document.getElementById('message-container');
        if(message.type === 'info') {
            errorContainer.classList.add('alert', 'alert-success');
        } else if(message.type === 'error') {
            errorContainer.classList.add('alert', 'alert-danger');
        }

        const errorElem = document.createElement('p');
        errorElem.style.marginBottom = '0';
        errorElem.innerHTML = `${message.content}`;
        errorContainer.appendChild(errorElem);
    }
</script>
</body>
</html>
