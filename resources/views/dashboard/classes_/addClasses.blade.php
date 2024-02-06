@extends('dashboard')

@section('content')
    <section class="section">
        <div class="container mt-2">
            <div class="welcome text-center">
                <!-- Button to open the modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addClassModal"
                    style="float:right">
                    Add Class
                </button>

                <!-- Modal for Adding/Edit Class -->
                <div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addClassModalLabel">Add Class</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Add your form elements for adding/editing a class here -->
                                <form id="addClassForm">
                                    @csrf
                                    <!-- <input type="hidden" name="form_action" value="school_register" /> -->
                                    <input type="hidden" name="form_action" id="edit" value="add_Class" />
                                    <input type="hidden" name="user_type" id="user_type" value="Class" />
                                    <input type="hidden" name="id" id="id" value="id" />
                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control newmodel" id="name" name="name"
                                            pattern="[A-Za-z]+" title="Please enter letters only" required>
                                    </div>
                                        <!-- Submit Button -->
                                        <button type="submit" id="addClassBtn" class="btn btn-primary"
                                            name="signup" style="float: left; background: #717ff5; border: none;">Sign
                                            Up</button>
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
    // View Classs
    var dataTable = $('#example').DataTable({
    "serverSide": true,
    "ajax": {
        "url": "{{ route('viewClass') }}",
        "type": "GET",
        "headers": {
            'X-CSRF-TOKEN': csrfToken
        }
    },
    "columns": [
        { "data": "id" },
        { "data": "name" },
        {
            "render": function (data, type, full, meta) {
                console.log('Full Object:', full);
                return '<a data-bs-toggle="modal" data-bs-target="#addClassModal"  class="btn btn-info edit" data-id="' + (full.id || '') + '" data-name="' + (full.name || '') + '" data-email="' + (full.email || '') + '"><i class="fa-solid fa-pencil"></i></a>&nbsp;' +
                    '<a class="btn btn-danger delete" data-id="' + (full.id || '') + '" data-email="' + (full.email || '') + '"><i class="fa-solid fa-trash"></i></a>';
            }
        }
    ]
});

        
    // Add Classs
    $('#addClassBtn').on('click', function (event) {
        event.preventDefault();

        // Initialize the form validation
        var addClassForm = $('#addClassForm');
        addClassForm.validate({
            rules: {
                name: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: 'Please enter your name'
                },
            }
        });

        // Check if the form is valid before making the AJAX request
        if (addClassForm.valid()) {
            var id = $('#id').val();
            var name = $('#name').val();
            var formAction = $('#edit').val();
            var user_type = $('#user_type').val();

            $.ajax({
                method: 'POST',
                // url: "{{ route('addClass') }}",
                url: (formAction == 'add_Class') ? "{{ route('addClass') }}" : "{{ route('editClass') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                     },
                data: {
                    id: id,
                    name: name,
                },
                success: function (response) {
                    console.log('AJAX Success:', response);
                    $('#addClassModal').modal('hide');
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

            // To edit Class
            $('#example').on('click', '.edit', function () {
            var currentClassId = $(this).data('id');
            var id = $(this).data('id');
            var name = $(this).data('name');

            // Update modal title, change button label, and set form action to 'edit_classes'
            $('#addClassModalLabel').text('Edit Class');
            $('#addClassBtn').text('Edit Class');
            $('#edit').val('edit_Class');

            // Prefill the form with the class name
            $('#id').val(id).trigger('change');
            $('#name').val(name).trigger('change');
            $('#addClassModal').modal('show');
        });


            // To Delete Classs
            $('#example').on('click', '.delete', function () { 
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
            $('#addClassModal').on('hidden.bs.modal', function () {
            $('#addClassModalLabel').text('Add Class');
            $('#addClassBtn').text('Add Class');
            $('#edit').val('add_Class');
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

});


</script>
@endsection