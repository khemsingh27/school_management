@extends('dashboard')

@section('content')
<section class="section">
        <div class="container mt-2">
            <div class="welcome text-center">
               <!-- Button to open the modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTeacherModal"
                    style="float:right">
                    Add Teacher
                </button>

                <!-- Modal for Adding/Edit Class -->
                <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="background: #f6f7fc;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTeacherModalLabel">Add Teacher</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Add your form elements for adding/editing a class here -->
                                <form id="addTeacherForm">
                                    @csrf
                                    <!-- <input type="hidden" name="form_action" value="school_register" /> -->
                                    <input type="hidden" name="form_action" id="edit" value="add_Teacher" />
                                    <input type="hidden" name="user_type" id="user_type" value="teacher" />
                                    <input type="hidden" name="id" id="id" value="id" />
                                    <div class="blockone d-flex justify-content-between" style="column-gap: 10px;">
                                        <!-- Name -->
                                        <div class="mb-3 text-start w-50">
                                            <label for="name" class="form-label">Name</label>
                                            <!-- <input type="text" class="form-control" id="firstname" name="firstname" required> -->
                                            <input type="text" class="form-control newmodel" id="name" name="name"
                                                pattern="[A-Za-z]+" title="Please enter letters only" required>
                                        </div>
                                        <!-- Email -->
                                        <div class="mb-3 text-start w-50">
                                            <label for="email" class="form-label">Email address</label>
                                            <input type="email" class="form-control newmodel" id="email" name="email"
                                                required>
                                        </div>
                                    </div>
                                    <!-- Classes -->
                                    <div class="mb-3 text-start w-100">
                                        <label for="class" class="form-label">Class</label>
                                        <!-- Change the id attribute from 'class' to 'classSelect' -->
                                        <select class="js-example-basic-multiple" id="classSelect" name="class[]"
                                            multiple required>
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                    <div class="blocktwo d-flex justify-content-between" style="column-gap: 10px;">
                                        <!-- Password -->
                                        <div class="mb-3 text-start w-50">
                                            <label for="password" class="form-label" id="passwordLabel">Password</label>
                                            <input type="password" class="form-control newmodel" id="password"
                                                name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                        </div>
                                        <!-- Confirm Password -->
                                        <div class="mb-3 text-start w-50">
                                            <label for="password_confirmation" class="form-label"
                                                id="confirmPasswordLabel">Confirm Password</label>
                                            <input type="password" class="form-control newmodel"
                                                id="password_confirmation" name="password_confirmation" required>
                                            <div id="passwordError" style="color: red;"></div>
                                        </div>
                                    </div>
                                    <!-- Submit Button -->
                                    <button type="submit" id="addTeacherBtn" class="btn btn-primary" name="signup"
                                        style="float: left; background: #717ff5; border: none;">Add Teacher</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DataTable to display classes -->
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Classes</th>
                            <th>Action</th>
                        </tr>
                    <tbody>
                    </tbody>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<script>
    $(document).ready(function () {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        //view Class
        $.ajax({
            "url": "{{ route('viewClass') }}",
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // Append new options based on the received data
                for (var i = 0; i < response.data.length; i++) {
                    $('#classSelect').append($('<option>', {
                        value: response.data[i].id,
                        text: response.data[i].name
                    }));
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching class data:', error);
            }
        });
        // View Teachers
        var dataTable = $('#example').DataTable({
            "serverSide": true,
            "ajax": {
                "url": "{{ route('viewTeacher') }}",
                "type": "GET",
                "headers": {
                    'X-CSRF-TOKEN': csrfToken
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "class_id" },
                {
                    "render": function (data, type, full, meta) {
                        console.log('Full Object:', full);
                        return '<a data-bs-toggle="modal" data-bs-target="#addTeacherModal"  class="btn btn-info edit" data-id="' + (full.id || '') + '" data-name="' + (full.name || '') + '" data-email="' + (full.email || '') + '"><i class="fa-solid fa-pencil"></i></a>&nbsp;' +
                            '<a class="btn btn-danger delete" data-id="' + (full.id || '') + '" data-email="' + (full.email || '') + '"><i class="fa-solid fa-trash"></i></a>';
                    }
                }
            ]
        });


        // Add Teachers
        $('#addTeacherBtn').on('click', function (event) {
            event.preventDefault();

            //Custom Method For Password Validation
            $.validator.addMethod(
                "passwordPattern",
                function (value, element) {
                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
                },
                "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character"
            );
            // Initialize the form validation
            var addTeacherForm = $('#addTeacherForm');
            addTeacherForm.validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    class: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        passwordPattern: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: '#password'
                    }
                },
                messages: {
                    name: {
                        required: 'Please enter your name'
                    },
                    email: {
                        required: 'Please enter your email address',
                        email: 'Please enter a valid email address'
                    },
                    class: {
                        required: 'Please select at least one class'
                    },
                    password: {
                        required: 'Please enter a password',
                        minlength: 'Password must be at least 8 characters long',
                    },
                    password_confirmation: {
                        required: 'Please confirm your password',
                        equalTo: 'Passwords do not match'
                    }
                }
            });

            // Check if the form is valid before making the AJAX request
            if (addTeacherForm.valid()) {
                var id = $('#id').val();
                var name = $('#name').val();
                var email = $('#email').val();
                var classes = $('#classSelect').val();
                var password = $('#password').val();
                var confirmPassword = $('#password_confirmation').val();
                var formAction = $('#edit').val();
                var user_type = $('#user_type').val();

                $.ajax({
                    method: 'POST',
                    // url: "{{ route('addTeacher') }}",
                    url: (formAction == 'add_Teacher') ? "{{ route('addTeacher') }}" : "{{ route('editTeacher') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        id: id,
                        name: name,
                        email: email,
                        classes: classes,
                        password: password,
                        password_confirmation: confirmPassword,
                        user_type: user_type
                    },
                    success: function (response) {
                        console.log('AJAX Success:', response);
                        $('#addTeacherModal').modal('hide');
                        dataTable.ajax.reload();
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX Error:', error, status);
                        console.log(xhr.responseText);

                        try {
                            var jsonResponse = JSON.parse(xhr.responseText);
                            alert(jsonResponse.message);
                        } catch (e) {
                            // Handle parsing error, if any
                            console.log('Error parsing JSON response:', e);
                        }
                    },
                });
            }
        });

        // To edit Teacher
        $('#example').on('click', '.edit', function () {
            console.log('entered 1');
            var currentTeacherId = $(this).data('id');
            // var name = $('#name').val();
            var id = $(this).data('id');
            var name = $(this).data('name');
            var email = $(this).data('email');
            var class_id = $(this).data('class_id');

            // Update modal title, change button label, and set form action to 'edit_classes'
            $('#addTeacherModalLabel').text('Edit Teacher');
            $('#addTeacherBtn').text('Edit Teacher');
            $('#edit').val('edit_Teacher');

            // Prefill the form with the class name
            $('#id').val(id).trigger('change');
            $('#name').val(name).trigger('change');
            $('#email').val(email).trigger('change');
            $('#email').attr('readonly', true);
            $('#password').attr('type', 'hidden');
            $('#passwordLabel').text('');
            $('#password_confirmation').attr('type', 'hidden');
            $('#confirmPasswordLabel').text('');
            // $("#class option[value=" + class_id + "]").attr("selected", "selected");
            // console.log('entered 2');
            // Show the modal
            $('#addTeacherModal').modal('show');
        });


        // To Delete Teachers
        $('#example').on('click', '.delete', function () {
            var teacherId = $(this).data('id');
            var email = $(this).data('email');
            console.log('Entered into Delete classes');
            if (confirm("Are you sure you want to delete this class?")) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('deleteTeacher') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: { id: teacherId, email: email },
                    success: function (response) {
                        console.log('AJAX Success:', response);
                        $('#example').DataTable().ajax.reload();
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX Error:', error);
                    }
                });
            }
        });


        //     // Reset modal state on close
        $('#addTeacherModal').on('hidden.bs.modal', function () {
            $('#addTeacherModalLabel').text('Add Teacher');
            $('#addTeacherBtn').text('Add Teacher');
            $('#edit').val('add_Teacher');
            $('#name').val('').trigger('change');
            $('#email').val('').trigger('change');
            $('#email').attr('readonly', false);
            $('#password').attr('type', 'password');
            $('#password').text('');
            $('#passwordLabel').text('Password');
            $('#password').val('');
            $('#password_confirmation').attr('type', 'password');
            $('#password_confirmation').val('');
            $('#confirmPasswordLabel').text('Confirm Password ');
        });


        // Multi Select Drop Down
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2({
                dropdownParent: $('#addTeacherModal'),
                // dropdownParent: ".mb-3",
                placeholder: 'Select Class',
                width: '100%',
            });
        });
    });
</script>
@endsection