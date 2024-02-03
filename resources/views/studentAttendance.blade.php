<div class="pagetitle">
    <h1>Teacher</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Teacher</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="container mt-5"></div>
    <div class="container mt-5">
        <div class="welcome text-center">
            <h1 class="mb-4">Welcome,
                <!-- {{$user = auth()->user()}} -->
                {{$user->name}}
            </h1>
            <div class="attendance">
                <form id="attendanceForm">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlSelect1">Class</label>
                            <select class="form-control" id="classSelect">
                            </select>
                        </div>
                        <div class="col">
                            <label for="birthday">Date</label>
                            <input type="date" class="datepicker" id="datepicker" name="datepicker">
                        </div>
                        <!-- Submit Button -->
                        <div class="col-2">
                            <button type="submit" id="datesubmit" class="btn btn-primary" name="signup"
                                style="float: left; background: #717ff5; border: none; margin-top: 23px;">Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- DataTable to display classes -->
            <table id="example" class="display" style="display:none;">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Attendance</th>
                    </tr>
                <tbody>
                </tbody>
                </thead>
                <tbody>
                </tbody>
            </table>
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
        // View Student Attendance
        $('#datesubmit').on('click', function (event) {
            event.preventDefault();

            $('#example').show('slide');

            // Attendance
            var dataTable = $('#example').DataTable({
                "destroy": true,
                "searching": false,
                "paging": false,
                "info": false,
                "serverSide": true,
                dataType: 'json',
                "ajax": {
                    "url": "{{ route('show') }}",
                    "type": "GET",
                    "headers": {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: function (d) {
                        d.classId = $('#classSelect').val();
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "attendence" },
                    // { "data": "email" },
                    // { "data": "class_id" },
                ]
            });
        });


        // To Student Attendance
        $('#example').on('click', '.Attendance_type', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var class_id = $(this).data('class_id');
            var Attendance_type = $(this).val();
            console.log(class_id);
            $.ajax({
                type: 'POST',
                url: "{{ route('studentAttendance') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: { id: id, name: name, class_id: class_id, Attendance_type: Attendance_type },
                success: function (response) {
                    console.log('AJAX Success:', response);
                    $('#example').DataTable().ajax.reload();
                },
                error: function (xhr, status, error) {
                    console.log('AJAX Error:', error);
                    try {
                        var jsonResponse = JSON.parse(xhr.responseText);
                        alert(jsonResponse.message);
                    } catch (e) {
                        // Handle parsing error, if any
                        console.log('Error parsing JSON response:', e);
                    }
                }
            });
        });

        // To Reset Attendance
        $('#example').on('click', '.reset', function () {
            var ClassId = $(this).data('id');
            var email = $(this).data('email');
            console.log('Entered into Delete classes');
            if (confirm("Are you sure you want to delete this class?")) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('deleteClass') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: { id: ClassId, email: email },
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