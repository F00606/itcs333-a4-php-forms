<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/validate.php';

$name = '';
$email = '';
$message = '';
$errors = [];

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
    } else {
        $name = '';
    }

    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
    } else {
        $email = '';
    }

    if (isset($_POST['message'])) {
        $message = trim($_POST['message']);
    } else {
        $message = '';
    }

    if (!validate_required($name)) {
        $errors['name'] = 'Name is required.';
    } else if (!validate_length($name, 2, 60)) {
        $errors['name'] = 'Name must be 2 to 60 characters.';
    }

    if (!validate_email($email)) {
        $errors['email'] = 'Please enter a valid email.';
    }

    if (!validate_required($message)) {
        $errors['message'] = 'Message is required.';
    } else if (!validate_length($message, 10, 1000)) {
        $errors['message'] = 'Message must be 10 to 1000 characters.';
    }

    if (empty($errors)) {
        header('Location: success.php', true, 303);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Contact Us</title>
</head>
<body>
  <h1>Contact Us</h1>

  <form method="post" action="index.php">

    <label>Name <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></label>
    <?php if (isset($errors['name'])) { ?>
      <span class="error"><?php echo htmlspecialchars($errors['name']); ?></span>
    <?php } ?>
    <br>

    <label>Email <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"></label>
    <?php if (isset($errors['email'])) { ?>
      <span class="error"><?php echo htmlspecialchars($errors['email']); ?></span>
    <?php } ?>
    <br>

    <label>Message <textarea name="message"><?php echo htmlspecialchars($message); ?></textarea></label>
    <?php if (isset($errors['message'])) { ?>
      <span class="error"><?php echo htmlspecialchars($errors['message']); ?></span>
    <?php } ?>
    <br>

    <button type="submit">Send</button>
  </form>
</body>
</html>