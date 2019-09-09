<?php

namespace App\Core\Adapter;

interface MessageSenderAdapter
{
    public function sendTo(string $recipient, string $content);
}
