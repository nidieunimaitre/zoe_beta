<?php
	if (isset($_POST["submit"])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		$human = intval($_POST['human']);
		$from = "Contactform";
		$to = 'raphael.guetlin@gmail.com';
		$subject = 'Message From Contactform';

		$body ="From: $name\n E-Mail: $email\n Message:\n $message";
		// Check if name has been entered
		if (!$_POST['name']) {
			$errName = 'Please enter your name';
		};

		// Check if email has been entered and is valid
		if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$errEmail = 'Please enter a valid email address';
		};

		//Check if message has been entered
		if (!$_POST['message']) {
			$errMessage = 'Please enter your message';
		};
		//Check if simple anti-bot test is correct
		if ($human !== 5) {
			$errHuman = 'Your anti-spam is incorrect';
		};
    // If there are no errors, send the email
    if (!$errName && !$errEmail && !$errMessage && !$errHuman) {
    	if (mail($to, $subject, $body, $from)) {
    		$result='Message sent.';
    	} else {
    		$result='Sorry there was an error sending your message. Please try again later.';
    	};
    };
	};
?>

<div class="contactform">
  <form action="index.php?page=contact&pagetype=main&showtext=1" method="post">

    <input type="text" name="name" placeholder="name" value="<?php echo htmlspecialchars($_POST['name']); ?>" />
    <?php echo " $errName";?><br><br>

    <input type="text" name="email" placeholder="yourname@mail.com" value="<?php echo htmlspecialchars($_POST['name']); ?>" />
    <?php echo " $errEmail";?><br><br>

    <textarea name="message" placeholder="your message"><?php echo htmlspecialchars($_POST['message']);?></textarea>
    <?php echo " $errMessage";?><br><br>

    <input type="text" name="human" placeholder="2 + 3 = ?" />
    <?php echo " $errName";?><br><br>

    <input type="submit" value="send" class="hvr-wobble-skew "/><br><br>

    <?php echo $result; ?>
  </form>
</div>
