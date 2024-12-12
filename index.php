<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="production/images/logs.jpg" type="image/ico" />
    <title>OSVG</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendors/swal/dist/sweetalert2.min.css">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> 
    <style>
   body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
  }

  /* Zigzag Image Styling */
  .zigzag-image {
    position: relative;
    height: 100vh;
    clip-path: polygon(20% 0, 100% 0, 100% 100%,0  100%, 0 100%);
    overflow: hidden;
  }

  .zigzag-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Login Form Wrapper */
  .login_wrapper {
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  }

  /* Login Form Heading */
  h1 {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
    color: #343a40;
  }

  /* Form Fields */
  .form-control {
    height: 45px;
    font-size: 16px;
    border-radius: 5px;
  }

  .styled-input {
    padding-right: 40px;
  }

  .styled-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 6px rgba(0, 123, 255, 0.3);
  }

  /* Button Styles */
  .btn-secondary {
    width: 100%;
    height: 45px;
    background-color: #343a40;
    color: white;
    font-size: 16px;
    border-radius: 5px;
    transition: background-color 0.3s ease-in-out;
  }

  .btn-secondary:hover {
    background-color: #495057;
  }

  /* Toggle Password Icon */
  .toggle-password-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background-color: transparent;
    border: none;
    cursor: pointer;
    z-index: 3;
  }

  .toggle-password-btn i {
    color: #007bff;
    font-size: 18px;
  }

  .toggle-password-btn:hover i {
    color: #0056b3;
  }

  /* Footer Styles */
  .separator {
    margin-top: 20px;
    text-align: center;
  }

  .separator p {
    color: #6c757d;
    font-size: 14px;
  }

  .separator p strong {
    color: #343a40;
  }
</style>

  </head>

  <body class="login" style="background-color:#ffffff;">
  <div class="row align-items-center" style="min-height: 100vh; margin: 0;">
  <!-- Left Login Form Section -->
  <div class="col-md-4">
    <div class="login_wrapper">
      <section class="login_content">
        <form id="loginForm">
          <h1>Login</h1>
          <div>
            <input type="text" id="username" class="form-control" placeholder="Username" required>
          </div>
          <div style="position: relative; margin-top: 20px;">
            <input type="password" id="password" class="form-control styled-input" placeholder="Password" required>
            <button class="toggle-password-btn" type="button" id="togglePassword">
              <i class="fa fa-eye"></i>
            </button>
          </div>
          <div style="margin-top: 20px;">
            <button class="btn btn-secondary" type="submit" name="login">Log in</button>
          </div>

          <div class="separator">
            <p>©2016 All Rights Reserved. We Are The Solution</p>
          </div>
        </form>
      </section>
    </div>
  </div>

  <!-- Right Zigzag Image Section -->
  <div class="col-md-8 p-0 zigzag-image">
    <img src="production/images/bg-plant.jpg" alt="Background Image">
  </div>
</div>
    <script src="vendors/swal/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function (e) {
    // Toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    // Toggle the eye icon
    this.querySelector('i').classList.toggle('fa-eye');
    this.querySelector('i').classList.toggle('fa-eye-slash');
  });


      $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();  // Prevent default form submission

            var email = $('#username').val();
            var password = $('#password').val();
            // Perform AJAX request
            $.ajax({
                url: 'process.php',  // Change this URL to your server-side script
                type: 'POST',
                dataType: 'json',
                data: {
                    email: email,
                    password: password
                },
                success: function(response) {
                    if (response.success) {
                        // If login is successful, redirect to dashboard or another page
                       // Show SweetAlert notification on successful login
                        var href = "production/index?link=dashboard";
                          Swal.fire({
                              icon: "success",
                              title: "Successfully Logged In!",
                              showConfirmButton: false,
                              timer: 1500  // Show for 1.5 seconds
                          }).then(() => {
                              // Redirect to the dashboard after the notification
                              window.location.href = href;  // Change this URL to your desired destination
                          });
                    } else {
                        // If login failed, show an error message
                        toastr.error('Incorrect username or password!', 'Error');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors (e.g., server not responding, etc.)
                    console.error('AJAX Error:', error);
                    alert('An error occurred while logging in.');
                }
            });
        });
      });

    </script>
  </body>
</html>
