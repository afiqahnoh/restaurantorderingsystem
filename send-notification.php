<?php
// Required if your environment does not handle autoloading
require 'twilio-php-main\src\Twilio\autoload.php';

// Your Account SID and Auth Token from console.twilio.com
$sid = "AC6e77b5639fa2f373502cd9d56743109f";
$token = "68872e7397bab367b673af75a3db9f2c";
$client = new Twilio\Rest\Client($sid, $token);

// Use the Client to make requests to the Twilio REST API
$client->messages->create(
    // The number you'd like to send the message to
    '+60134578797',
    [
        // A Twilio phone number you purchased at https://console.twilio.com
        'from' => '+16672708030',
        // The body of the text message you'd like to send
        'body' => "Your order is ready for pickup!"
    ]
);

// Redirect back to user-order.php after sending the SMS
header("Location: user-order.php");
exit(); // Make sure to exit after the redirection to prevent further script execution.
?>
