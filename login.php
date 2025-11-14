<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['email'] = $email;
      echo "<script>alert('Login successful!'); window.location='index.html';</script>";
    } else {
      echo "<script>alert('Wrong password!'); window.location='login.html';</script>";
    }
  } else {
    echo "<script>alert('No user found! Please sign up.'); window.location='signup.html';</script>";
  }
}
?>
