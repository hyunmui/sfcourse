<?php

namespace App\Services;

/**
 * Notification
 * 
 * @author Martin Seon
 * @package App\Services
 */
class Notification
{
    public function __construct($email, FileUploader $fileUploader)
    {
        dump($email, $fileUploader);
        die;
        $this->email = $email;
    }

    public function sendNotification()
    {
        # code...
    }
}

/** End of Notification.php */
