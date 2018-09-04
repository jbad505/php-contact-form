<?php 
    // Message vars
    $msg = '';
    $msgClass = '';

    // Check for submit
    if(filter_has_var(INPUT_POST, 'submit')) {
        // Get form data
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        // Check required fields
        if(!empty($name) && !empty($email) && !empty($message)) {
            // Passed
            // Check for valid email
            if(filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                // Failed
                $msg = 'Invalid email address';
                $msgClass = 'alert-danger';
            } else {
                // Passed
                $toEmail = 'YOUR_EMAIL_HERE';
                $subject = 'Contact Request From' . $name;
                $body = '<h2>Contact Request</h2> 
                        <h4>Name</h4><p>' . $name . '</p>
                        <h4>Email</h4><p>' . $email . '</p>
                        <h4>Message</h4><p>' . $message . '</p>';

                // Email headers
                $headers = "MIME-Version 1.0" . "\r\n";
                $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";

                // Additional headers
                $headers = "From: " . $name . "<" . $email . ">" . "\r\n";

                if(mail($toEmail, $subject, $body, $headers)) {
                    // Email sent
                    $msg = 'Your email has been sent';
                    $msgClass = 'alert-success';
                } else {
                    $msg = 'Your email was not sent';
                    $msgClass = 'alert-danger';
                }
            }

        } else {
            // Failed
            $msg = 'All fields required';
            $msgClass = 'alert-danger';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.3/flatly/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-gJWVjz180MvwCrGGkC4xE5FjhWkTxHIR/+GgT8j2B3KKMgh6waEjPgzzh7lL7JZT" 
    crossorigin="anonymous">
    <title>Contact Form</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="index.php">Contact Form</a>
</nav>
<div class="container mt-3">
        <?php if($msg != ''): ?>
            <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : ''; ?>" >
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>" >
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" class="form-control"><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>