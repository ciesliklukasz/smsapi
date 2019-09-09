<?php

namespace App\Infrastructure\Communication;

use App\Core\Adapter\MessageSenderAdapter;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailSenderAdapter implements MessageSenderAdapter
{
    public function sendTo(string $recipient, string $content): bool
    {
        $mail = new PHPMailer(true);

        try
        {
            $mail->setFrom('admin@app-comparer.com', 'AppComparer');
            $mail->addAddress($recipient);

            $mail->isHTML(false);
            $mail->Subject = 'Files are difference!';
            $mail->Body = $content;

            return $mail->send();
        }
        catch (Exception $e)
        {
            return false;
        }
    }

}
