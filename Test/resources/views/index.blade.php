@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Employee Listing</h2>
                <a class="btn btn-success float-right mb-4" href="javascript:void(0)" id="createNewEmployee">New
                    Registration</a>

            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Department</th>
                            <th>Hobbies</th>
                            <th>Actions</th>
                            <th><button style="display:none" class="btn btn-danger deleteEmployee">Delete all</button>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr data-id="{{ $employee->id }}">
                                <td><input type="checkbox" class="employeeCheckbox" data-id="{{ $employee->id }}"></td>

                                <td><span class="editable" data-field="name">{{ $employee->name }}</span></td>
                                <td><span class="editable" data-field="email">{{ $employee->email }}</span></td>
                                <td><span class="editable" data-field="phone">{{ $employee->phone }}</span></td>
                                <td><span class="editable" data-field="department">{{ $employee->department }}</span></td>
                                <td><span class="editable" data-field="hobbies">{{ $employee->hobbies }}</span></td>
                                <td>
                                    <a href="#" class="btn btn-info editEmployee">Edit</a>
                                    <a href="#" class="btn btn-success saveEmployee" style="display:none">Save</a>
                                    <button class="btn btn-danger deleteEmployee">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        {{-- modal start --}}
        <!-- Modal -->
        <div class="modal fade" tabindex="-1" id="createEmployeeModal" role="dialog"
            aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createEmployeeModalLabel">New Employee Registration</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                                <label for="hobbies">Hobbies</label>
                                <select name="hobbies[]" id="hobbies"
                                    class="form-control @error('hobbies') is-invalid @enderror" multiple>
                                    <option value="Reading">Reading</option>
                                    <option value="Gaming">Gaming</option>
                                    <option value="Sports">Sports</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div> --}}
                </div>
            </div>
        </div>

    </div>

    {{-- update modal start --}}

    {{-- <div class="modal fade" id="updateEmployeeModal" tabindex="-1" role="dialog"
        aria-labelledby="updateEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateEmployeeModalLabel">Update Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateEmployeeForm" method="POST" action="/employees/update">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="update_name">Name:</label>
                            <input type="hidden" id="id" name="id">
                            <input type="text" class="form-control" id="update_name" name="name" />
                        </div>
                        <div class="form-group">
                            <label for="update_email">Email:</label>
                            <input type="email" class="form-control" id="update_email" name="email" />
                        </div>
                        <div class="form-group">
                            <label for="update_phone">Phone:</label>
                            <input type="text" class="form-control" id="update_phone" name="phone" />
                        </div>
                        <div class="form-group">
                            <label for="update_department">Department:</label>
                            <select class="form-control" id="update_department" name="department">
                                <option value="IT">IT</option>
                                <option value="HR">HR</option>
                                <option value="Finance">Finance</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hobbies">Hobbies</label>
                            <select name="hobbies[]" id="update_hobbies" class="form-control @error('hobbies') is-invalid @enderror" multiple>
                                <option value="Reading">Reading</option>
                                <option value="Gaming">Gaming</option>
                                <option value="Sports">Sports</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div> --}}
@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function(){

        
        document.getElementById('selectAll').addEventListener('change', function () {
    var checkboxes = document.querySelectorAll('.employeeCheckbox');
    checkboxes.forEach(function (checkbox) {
        checkbox.checked = this.checked;
    }, this);

    var deleteAllButton = document.querySelector('.btn.deleteEmployee');
    if (this.checked) {
        deleteAllButton.style.display = 'inline-block';
    } else {
        deleteAllButton.style.display = 'none';
    }
});





        // open modal show

        $('#createNewEmployee').click(function() {
            // alert("FDSFSD");
            $('#createEmployeeModal').modal('show');
        });
        // registration new employee



        // Edit Employee
        // Edit Employee
        $('.editEmployee').click(function() {
            $(this).hide(); // Hide the clicked edit button
            $(this).next('.saveEmployee').show();
            var row = $(this).closest('tr');
            row.find('.editable').each(function() {
                var field = $(this).data('field');
                var value = $(this).text().trim();
                $(this).replaceWith(
                    '<input type="text" class="form-control editable-input" data-field="' +
                    field + '" value="' + value + '">');
            });
            $(this).text('Save').removeClass('btn-info editEmployee').addClass(
                'btn-success saveEmployee');
            $(this).text('Save').removeClass('btn-info editEmployee').addClass(
                'btn-success saveEmployee').attr('id', 'save');

        });

        // save Employee Changes
        $('.saveEmployee').click( function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var data = {};
            row.find('.editable-input').each(function() {
                var field = $(this).data('field');
                var value = $(this).val();
                data[field] = value;
            });
            console.log('Data to be sent:', data);
            $.ajax({
                url: '/employee/update/' + id,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(response) {
                    console.log('Update successful:', response);
                    // Update table cell content with new values
                    row.find('.editable-input').each(function() {
                        var value = $(this).val();
                        var field = $(this).data('field');
                        $(this).replaceWith('<span class="editable" data-field="' + field +
                            '">' + value + '</span>');
                    });
                    row.find('.saveEmployee').text('Edit').removeClass('btn-success saveEmployee')
                        .addClass('btn-info editEmployee');

                        Swal.fire({
                title: 'Success!',
                text: 'Employee data updated successfully.',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500 // 1.5 seconds
            });
      
                },
                error: function(xhr, status, error) {
                    console.error('Update failed:', xhr.responseText);
                    // Handle error if needed
                }
            });

        });

    

    // Delete Employee

    $('.deleteEmployee').click(function() {
    var checkedEmployees = [];
    $('.employeeCheckbox:checked').each(function() {
        checkedEmployees.push($(this).data('id'));
    });

    if (checkedEmployees.length === 0) {
        // No checkboxes checked, display an alert or handle it accordingly
        alert('Please select at least one employee to delete.');
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/employee/delete/multiple',
                type: 'DELETE',
                data: { employeeIds: checkedEmployees },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    });
});




    ///registration form submit///


    $('#employeeForm').submit(function(event) {
        event.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var department = $('#department').val();
        var hobbies = $('#hobbies').val(); // Corrected variable name

        // Reset error messages
        $('#nameError').text('');
        $('#emailError').text('');
        $('#phoneError').text('');
        $('#departmentError').text('');
        $('#hobbiesError').text(''); // Corrected error ID

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

        // Validate Hobbies
        if (!hobbies || hobbies.length === 0) {
            $('#hobbiesError').text('Please select at least one hobby.');
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
                hobbies: hobbies
            },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/';
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
                    // Handle other validation errors if needed
                } else {
                    console.error(xhr.responseText);
                }
            }
        });
    });
}) 
</script>
