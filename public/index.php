<?php
declare(strict_types=1);

/**
 * ITCS333 A4 starter — contact form.
 * Requirements (see README rubric):
 *   - GET: render the form
 *   - POST: validate name (required, 2-60 chars), email (valid), message (required, 10-1000 chars)
 *   - invalid POST: re-render with inline errors + repopulated fields (200)
 *   - valid POST: redirect (302/303) to a success page (PRG)
 *   - escape all output with htmlspecialchars
 */

require_once __DIR__ . '/../src/validate.php';

// TODO: implement the form handling here.
function post_value(string $field): string
{
    $value = $_POST[$field] ?? '';

    return is_string($value) ? $value : '';
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$name = '';
$email = '';
$message = '';
$errors = [];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $name = post_value('name');
    $email = post_value('email');
    $message = post_value('message');

    if (!validate_required($name)) {
        $errors['name'] = 'Name is required.';
    } elseif (!validate_length($name, 2, 60)) {
        $errors['name'] = 'Name must be between 2 and 60 characters.';
    }

    if (!validate_email($email)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if (!validate_required($message)) {
        $errors['message'] = 'Message is required.';
    } elseif (!validate_length($message, 10, 1000)) {
        $errors['message'] = 'Message must be between 10 and 1000 characters.';
    }

    if ($errors === []) {
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
  <!-- TODO: render the form, inline errors, and repopulated values -->
  <form method="post" action="index.php" novalidate>
    <label>Name <input type="text" name="name" value="<?= escape($name) ?>"></label>
    <?php if (isset($errors['name'])): ?>
      <span><?= escape($errors['name']) ?></span>
    <?php endif; ?>
    <br>

    <label>Email <input type="email" name="email" value="<?= escape($email) ?>"></label>
    <?php if (isset($errors['email'])): ?>
      <span><?= escape($errors['email']) ?></span>
    <?php endif; ?>
    <br>

    <label>Message <textarea name="message"><?= escape($message) ?></textarea></label>
    <?php if (isset($errors['message'])): ?>
      <span><?= escape($errors['message']) ?></span>
    <?php endif; ?>
    <br>

    <button type="submit">Send</button>
  </form>
</body>
</html>
