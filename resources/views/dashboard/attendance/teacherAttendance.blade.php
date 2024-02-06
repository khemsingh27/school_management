@extends('dashboard')

@section('content')
<section class="section">
    <div class="container mt-2">
        <div class="welcome text-center">
            <div class="attendance">
                <form id="attendanceForm">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlSelect1">Class</label>
                            <select class="form-control" id="classSelect" required>
                            </select>
                        </div>
                        <div class="col">
                            <label for="birthday">Date</label>
                            <input type="date" class="datepicker" id="datepicker" name="datepicker" required>
                        </div>
                        <!-- Submit Button -->
                        <div class="col-2">
                            <button type="submit" id="datesubmit" class="btn btn-primary" name="signup"
                                style="float: left; background: #717ff5; border: none; margin-top: 23px;">Search</button>
                        </div>
                    </div>
                    <div id="error-message" class="text-danger"></div>
                </form>
            </div>

            <!-- DataTable to display classes -->
            <table id="example" class="display" style="display:none;">
                <thead>
                    <tr>
                        <th>Teacher ID</th>
                        <th>Teacher Name</th>
                        <th>Attendance</th>
                    </tr>
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

        // View Class
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

        // View teacher Attendance
        $('#datesubmit').on('click', function (event) {
            event.preventDefault();
            var selectedClass = $('#classSelect').val();
            var selectedDate = $('#datepicker').val();

            if (selectedClass && selectedDate) {
                $('#error-message').hide().text('');
                $('#classSelect, #datepicker').css('box-shadow', '');
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
                        "url": "{{ route('showTeacher') }}",
                        "type": "GET",
                        "headers": {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: function (d) {
                            d.classId = $('#classSelect').val();
                            d.date = $('#datepicker').val();
                        }
                    },
                    "columns": [
                        { "data": "id" },
                        { "data": "name" },
                        { "data": "attendence" },
                    ]
                });
            } else {
                $('#error-message').text('Please select both Class and Date before searching.').show();
                $('#classSelect, #datepicker').css('box-shadow', '0 0 5px rgba(255, 0, 0, 0.7)');
            }
        });

        // To teacher Attendance
        $('#example').on('click', '.Attendance_type', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var class_id = $(this).data('class_id');
            var Attendance_type = $(this).val();
            var date = $('#datepicker').val();
            var teacherId = $(this).data('id');
            console.log(id);
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: { id: id, name: name, class_id: class_id, Attendance_type: Attendance_type, date: date},
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
            var teacherId = $(this).data('id');
            var date = $('#datepicker').val();
            console.log((teacherId)); 
            if (confirm("Are you sure you want to reset this attendance?")) {
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: { teacherId: teacherId, date: date},
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
    });
</script>
@endsection