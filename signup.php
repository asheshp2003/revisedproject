<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Anupam</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <header class="page-header">
      <div class="wrapper">
        <nav class="main-nav">
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="signup.php">Sign Up</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <div class="box">
      <div class="signup-container">
        <h1>Create an Account</h1>
        <form method="post" action="register.php" onsubmit="return validateForm()">
          <div class="form-group">
            <label for="fullname">Full Name</label>
            <input 
              type="text" 
              id="fullname" 
              name="fullname" 
              required 
              pattern="^[A-Za-z\s]+$" 
              title="Full Name should only contain letters and spaces" 
              placeholder="Enter your full name" 
            />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              required 
              placeholder="Enter your email" 
            />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              required
              minlength="8"
              placeholder="Enter your password"
              pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$"
              title="Password must be at least 8 characters long and contain both letters and numbers"
            />
            <p class="password-hint">
              Password must be at least 8 characters long and include both letters and numbers.
            </p>
          </div>
          <button type="submit">Sign Up</button>
        </form>
        <div class="login-link">
          Already have an account?
          <a href="signin.php">Log in</a>
        </div>
      </div>
    </div>

    <script>
      //  form validation
      function validateForm() {
        var fullname = document.getElementById("fullname").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        
        // Full Name Validation: Only letters and spaces
        if (!/^[A-Za-z\s]+$/.test(fullname)) {
          alert("Full Name should only contain letters and spaces.");
          return false;
        }

        // Email Validation: Check if email is valid
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
          alert("Please enter a valid email address.");
          return false;
        }

        // Password Validation: At least 8 characters and a mix of letters and numbers
        if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/.test(password)) {
          alert("Password must be at least 8 characters long and contain both letters and numbers.");
          return false;
        }

        return true; // If all validations pass, submit the form
      }
    </script>
  </body>
</html>