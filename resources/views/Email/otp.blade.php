<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Deers Family!</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">

    <div class="email-container"
        style="font-family: Arial, sans-serif;
            padding: 20px; background-color: #f9f9f9; border: 1px solid #dddddd;
            border-radius: 8px; max-width: 600px; margin: 20px auto; background-color: rgba(249, 249, 249, 1);">
        <div class="header" style="text-align: center; margin-bottom: 20px;">
            <h1 style="color: #102BFE;">Welcome to Deers Family!</h1>
            <p style="font-size: 1.2em; color: #555555;">
                Your ultimate hub for buying and selling gaming accounts.
            </p>
        </div>

        <div class="content"
            style="background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
            <p style="font-size: 1em; color: #555555;">
                <span style="color: #102BFE">Hello {{ $user->name }},</span>
            </p>
            <p>Thank you for joining Deers Family! We're excited to have you on board. To complete your
                registration, please use the OTP below to verify your email address:</p>

            <div class="otp" style="margin: 20px 0; text-align: center;">
                <span style="font-size: 1.5em; font-weight: bold; color: #102BFE;">{{ $otp }}</span>
            </div>

            <p>This OTP is valid for the next <b>15 minutes</b>. If you did not sign up, please ignore this email.</p>
        </div>

        <footer style="margin-top: 20px; text-align: center; font-size: 0.9em; color: #888888;">
            <p>Deers</p>
            <p>For support, contact us at <a style="color: #9b4caf; text-decoration: none;"
                    href="mailto:lucaswillis741@gmail.com">lucaswillis741@gmail.com</a>
            </p>
        </footer>
    </div>

</body>

</html>
