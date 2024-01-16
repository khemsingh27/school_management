<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
    <form id="addStudentForm" method="POST" action="{{ route('form') }}">
        @csrf
                                <!-- <input type="hidden" name="form_action" value="school_register" /> -->
                                <input type="hidden" name="form_action" id="edit" value="add_student" />
                                <input type="hidden" name="user_type" id="user_type" value="student" />
                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <!-- <input type="text" class="form-control" id="firstname" name="firstname" required> -->
                                    <input type="text" class="form-control" id="name" name="name"
                                        pattern="[A-Za-z]+" title="Please enter letters only" required>
                                </div>
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label" id="passwordLabel">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                </div>
                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label" id="confirmPasswordLabel">Confirm
                                        Password</label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                        name="confirmPassword" required>
                                    <div id="passwordError" style="color: red;"></div>
                                </div>
                                <!-- Submit Button -->
                                <button type="submit" id="addStudentBtn" class="btn btn-primary" name="signup">Sign
                                    Up</button>
                            </form>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>