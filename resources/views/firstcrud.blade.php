<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 12 CRUD API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 text-center">Laravel 12 CRUD (API + AJAX)</h4>
        </div>

        <div class="card-body">
            <!-- ✅ FORM -->
            <form id="crudForm">
                <div class="row">
                    <input type="hidden" id="id" name="id">
                    <div class="col-md-4 mb-3">
                        <input type="text" id="name" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="email" id="email" class="form-control" placeholder="Enter Email" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" id="phone" class="form-control" placeholder="Enter Phone" required>
                    </div>
                    <div class="col-md-1 mb-3 d-grid">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>

            <hr>

            <!-- ✅ TABLE -->
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="dataTable"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    const apiUrl = "{{ url('api/firstcrudapi') }}";

    // 🔹 Load Data
    function fetchData() {
        $.get(apiUrl, function (res) {
            let html = '';
            $.each(res.data, function (key, item) {
                html += `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.name}</td>
                        <td>${item.email}</td>
                        <td>${item.phone}</td>
                        <td>
                            <button class="btn btn-warning btn-sm editBtn" data-id="${item.id}" data-name="${item.name}" data-email="${item.email}" data-phone="${item.phone}">Edit</button>
                            <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}">Delete</button>
                        </td>
                    </tr>`;
            });
            $('#dataTable').html(html);
        });
    }

    fetchData();

    // 🔹 Insert / Update
    $('#crudForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#id').val();
        let method = id ? 'PUT' : 'POST';
        let url = id ? `${apiUrl}/${id}` : apiUrl;

        $.ajax({
            url: url,
            type: method,
            data: {
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
            },
            success: function () {
                alert(id ? 'Updated successfully!' : 'Inserted successfully!');
                $('#crudForm')[0].reset();
                $('#id').val('');
                fetchData();
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });

    // 🔹 Edit
    $(document).on('click', '.editBtn', function () {
        $('#id').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#email').val($(this).data('email'));
        $('#phone').val($(this).data('phone'));
    });

    // 🔹 Delete
    $(document).on('click', '.deleteBtn', function () {
        if (confirm('Are you sure you want to delete this record?')) {
            let id = $(this).data('id');
            $.ajax({
                url: `${apiUrl}/${id}`,
                type: 'DELETE',
                success: function () {
                    alert('Deleted successfully!');
                    fetchData();
                }
            });
        }
    });

});
</script>

</body>
</html>
