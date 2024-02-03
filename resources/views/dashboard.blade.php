@include('layouts.niceAdminNav')
<main id="main" class="main">
                  <!-- {{$user = auth()->user()}} -->
    <h1>Welcome {{$user->name}}</h1>
    @include('studentAttendance')
</main>
@include('layouts/footer')

<script>
        $(document).ready(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Teacher
            $('#sidebar').on('click', '#teacher', function (event) {
                event.preventDefault();
            console.log('Entered into Delete classes');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('viewTheTeacher') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (data) {
                        $("#main").html(data.main);
                        // window.history.pushState("Details", "Title", "{{url('/')}}/viewTeacher");
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX Error:', error);
                    }
                });
        });
        // Student
        $('#sidebar').on('click', '#student', function (event) {
                event.preventDefault();
            console.log('Entered into Delete classes');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('viewTheStudent') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (data) {
                        $("#main").html(data.main);
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX Error:', error);
                    }
                });
        });
        // Classes
        $('#sidebar').on('click', '#classes', function (event) {
                event.preventDefault();
            console.log('Entered into Delete classes');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('viewTheClasses') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (data) {
                        $("#main").html(data.main);
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX Error:', error);
                    }
                });
        });
    });
</script>