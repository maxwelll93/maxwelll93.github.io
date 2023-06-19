<?php
require_once "functions.php";
session_start();
// Check if the user is already logged in
if (isset($_SESSION['username'])) {
  // Redirect to the dashboard or any other authorized page
  header("Location: Catalog");
  exit;
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $mysql_Connection->real_escape_string(strip_tags(trim($_POST["username"])));
  $password = $mysql_Connection->real_escape_string(strip_tags(trim($_POST["password"])));


  //arrray of credentials to be validated
  $validate = array();
  $validate['user'] = $username;
  $validate['pass'] = $password;
  $validate['response'] = "";
  $validate['status'] = false;

  $validate = Validate($validate);
  //if all is good send to index page
  if ($validate['status']){
      header("Location: Search");
      die();
  } 
  else {
    // Invalid username or password
    $errorMessage = "Invalid username or password.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="styles/login.css">
</head>
<body>
  <main>
    <section id="login-form">
      <h1>Login</h1>
      <?php if (isset($errorMessage)) { ?>
        <p class="error-message"><?php echo $errorMessage; ?></p>
      <?php } ?>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter your username">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password">

        <button type="submit">Log In</button>
      </form>
    </section>
  </main>
</body>
</html>
