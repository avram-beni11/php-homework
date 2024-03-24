<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Import Bootstrap CSS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <title>Newsletter</title>
</head>

<body>
  <div>
    <div class="form-group col-md-6 offset-md-3">
      <h1 class="text-center mt-3">Newsletter</h1> <!--Centres text and adds a margin of 3 to the top-->
      <hr>
      <?php 
        $firstName = $lastName = $gender = $email = "";
        $errors = array();

          if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $firstName = $_POST['firstName'];
              $lastName = $_POST['lastName'];
              $gender = $_POST['gender'];
              $box = $_POST['check'];
              $email = $_POST['email'];

              // Validation
              if (empty($firstName)) {
                  $errors[] = "First name is required";
              }
              if (empty($lastName)) {
                  $errors[] = "Last name is required";
              }
              if (empty($gender)) {
                  $errors[] = "Gender is required";
              }
              if (empty($box)){
                $errors[] = "Accepting the terms is required";
              }
              if (empty($email)) {
                  $errors[] = "Email is required";
              } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $errors[] = "Invalid email format";
              }
          }
           
      ?>
      <form class="needs-validation was-validated" novalidate="" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
          <label for="firstName" class="form-label">First Name</label>
          <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required />
          <div class="valid-feedback">
            Looks good!
          </div>
        </div> <!--First name div-->
        <div class="form-group">
          <label for="lastName" class="mt-2">Last Name</label>
          <input type="text" class="form-control" id="lastName" name="lastName"value="<?php echo $lastName; ?>" required />
          <div class="valid-feedback">
            Looks good!
          </div>
        </div> <!--Last name div-->
        <div class="form-group">
          <label class="mt-2">Gender</label><br />
          <div class="form-check form-check-inline mt-2">
            <input type="radio" name="gender" class="form-check-input" id="male-radio" value="male" <?php if ($gender === 'male') echo 'checked'; ?> required />
            <label class="form-check-label" for="male">Male</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" name="gender" class="form-check-input" id="female" value="female" <?php if ($gender === 'female') echo 'checked'; ?> required />
            <label class="form-check-label" for="female">Female</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" name="gender" class="form-check-input" id="other" value="other" <?php if ($gender === 'other') echo 'checked'; ?>required />
            <label class="form-check-label" for="other">Other/Prefer not to say</label>
          </div>
        </div> <!--End radio div-->
        <div class="mb-3 mt-2"> <!--Margin Bottom-->
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
          <div class="valid-feedback">
            Looks good!
          </div>
          <div class="invalid-feedback">
            Please enter a valid email address
          </div>
        </div> <!--Email div-->
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="newsletter-check" name="check"  required>
          <label class="form-check-label" for="newsletter-check">By accepting you agree to our ToS and agree to
            receieving our monthly newsletter</label>
        </div> <!--Check box div-->
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Subscribe</button>
        </div> <!--Subscribe btn div-->
      </form>

      <?php
        //If request is POST and $errors array is empty, print data and push to MySQL database
        if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors)) {
            echo "<h2 class='mt-3'>Submitted Data</h2>";
            echo "<p><strong>First Name:</strong> $firstName</p>";
            echo "<p><strong>Last Name:</strong> $lastName</p>";
            echo "<p><strong>Gender:</strong> $gender</p>";
            echo "<p><strong>Email:</strong> $email</p>";
              $servername = "localhost";
              $username = "root";
              $password = "";
              $dbname = "newsletter";
      
              // Create connection
              $conn = new mysqli($servername, $username, $password, $dbname);
              // Check connection
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }
      
              $sql = "INSERT INTO users (first_name, last_name, gender ,email)
              VALUES ('$firstName', '$lastName', '$gender', '$email')";
      
              if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }
      
              $conn->close();
        //If request if POST and $errors array is NOT empty, display what needs to be fixed
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($errors)) {
            echo "<div class='alert alert-danger mt-3'>";
            echo "<h4>Please correct the following:</h4><ul>";
            foreach ($errors as $error) { //For every error in the errors array, print out error
                echo "<li>$error</li>";
            }
            echo "</ul></div>";
        }
        ?>

    </div>
  </div>

</body>

</html>