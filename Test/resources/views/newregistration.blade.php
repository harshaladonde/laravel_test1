{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="card col-lg-8 col-md-6">
            <div class="card-header">
                <h2 class="mb-0">Employee Registration</h2>
            </div>
            <div class="card-body">
                <form id="employeeForm" method="POST" action="/employee/store">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" />
                        <span id="nameError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" />
                        <span id="emailError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" id="phone" name="phone" />
                        <span id="phoneError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="department">Department:</label>

                        <select class="form-control" id="department" name="department">
                            <option value="">Select Department</option>
                            <option value="IT">IT</option>
                            <option value="HR">HR</option>
                            <option value="Finance">Finance</option>
                        </select>
                        <span id="departmentError" class="text-danger"></span>

                    </div>
                    <div class="form-group">
                        <label for="remark">Remark:</label>
                        <textarea class="form-control" id="remark" name="remark"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#employeeForm').submit(function(event) {
                event.preventDefault(); 

                var name = $('#name').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var department = $('#department').val();
                var remark = $('#remark').val();

                // Reset error messages
                $('#nameError').text('');
                $('#emailError').text('');
                $('#phoneError').text('');
                $('#departmentError').text('');

                // Validate Name
                if (!name || name.length < 3) {
                    $('#nameError').text('Name must be at least 3 characters long.');
                    return;
                }

                // Validate Email
                if (!email) {
                    $('#emailError').text('Email is required.');
                    return;
                }

                // Validate Phone
                if (!phone || phone.length !== 10 || isNaN(phone)) {
                    $('#phoneError').text('Phone must be a 10-digit number.');
                    return;
                }

                // Validate Department
                if (!department) {
                    $('#departmentError').text('Please select a department.');
                    return;
                }

               
                $.ajax({
                    url: '{{ route('employee.store') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: name,
                        email: email,
                        phone: phone,
                        department: department,
                        remark: remark
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/employees';
                            }
                        });
                        $('#employeeForm')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.hasOwnProperty('email')) {
                                $('#emailError').text(errors.email[0]);
                            }
                            if (errors.hasOwnProperty('phone')) {
                                $('#phoneError').text(errors.phone[0]);
                            }
                        } else {
                            console.error(xhr.responseText);
                        }
                    }
                });

            });
        });
    </script>

</body>

</html> --}}
