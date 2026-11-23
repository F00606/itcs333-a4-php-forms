<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/validate.php';

$name = '';
$email = '';
$message = '';
$errors = [];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!validate_required($name)) {
        $errors['name'] = 'Name is required.';
    } elseif (!validate_length($name, 2, 60)) {
        $errors['name'] = 'Name must be 2 to 60 characters.';
    }

    if (!validate_email($email)) {
        $errors['email'] = 'Please enter a valid email.';
    }

    if (!validate_required($message)) {
        $errors['message'] = 'Message is required.';
    } elseif (!validate_length($message, 10, 1000)) {
        $errors['message'] = 'Message must be 10 to 1000 characters.';
    }

    if (count($errors) === 0) {
        header('Location: index.php?success=1', true, 303);
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

  <?php if (isset($_GET['success'])): ?>
    <p>Thank you! Your message has been sent.</p>
  <?php endif; ?>

  <form method="post" action="index.php">
    <label>Name <input type="text" name="name" value="<?= htmlspecialchars($name) ?>"></label>
    <span class="error"><?= htmlspecialchars($errors['name'] ?? '') ?></span><br>

    <label>Email <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"></label>
    <span class="error"><?= htmlspecialchars($errors['email'] ?? '') ?></span><br>

    <label>Message <textarea name="message"><?= htmlspecialchars($message) ?></textarea></label>
    <span class="error"><?= htmlspecialchars($errors['message'] ?? '') ?></span><br>

    <button type="submit">Send</button>
  </form>
</body>
</html>