<!DOCTYPE html>
<html>

<head>
    <title>rrgmoney.com</title>
</head>

<body>
    <p>Hello {{ $mailData['senderName'] }},</p>
    <p> We'd like to inform you that your money transfer to {{ $mailData['receiverName'] }} has been successfully
        initiated.</p>

    <p>Rest assured, the transaction will be processed shortly.</p>

    <p>Thank you for choosing RRGMONEY.</p>

    <p>Best regards,</p>

    <p>RRGMONEY </p>

</body>

</html>
