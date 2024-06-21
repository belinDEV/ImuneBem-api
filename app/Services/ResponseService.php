<?php

namespace App\Services;

class ResponseService
{
    public function sendMessage(string $title, string $message, int $code)
    {
        return response()->json([
            $title => $message
        ], $code);
    }
}
