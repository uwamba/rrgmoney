<!DOCTYPE html>
<html>
<head>
    <title>rrgmoney.com</title>
</head>
<body>
   <p>Hello {{$mailData->receiverName}},</p>
   <p>Great news! The money transfer initiated by  {{$mailData->senderName}}  has been successfully approved. the funds are with you now. </p>
   <p>Sender: {{$mailData->senderName}}</p>
   <p>Amount: {{$mailData->request->amount_foregn_currency}} </p>
   <p>Thank you for using rrgmoney for your money transfers.</p>
   <p>If you have any questions or need assistance, feel free to reach out. </p>
   <p>Best regards, </p>
   <p>Thank you, </p>
   <p>RRGMONEY</p>";
</body>
</html>
