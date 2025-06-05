<?php

use Illuminate\Support\Facades\Mail;

function sendMail($to, $template, $subject, $data)
{
    Mail::send($template, $data, function ($message) use ($to, $subject) {
        $message->to($to)
            ->subject($subject);
    });
}
