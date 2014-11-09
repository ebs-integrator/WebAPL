<?php

class EmailModel {

    public static function sendToAdmins($title, $view, $data, $attachFile = false) {
        $sendToUsers = \User::withRole('user-getemails');

        foreach ($sendToUsers as $user) {
            $data['user'] = $user;
            Mail::send($view, $data, function($message) use ($title, $user, $attachFile) {
                $message->from("noreply@{$_SERVER['SERVER_NAME']}", 'WebLPA');
                $message->subject($title);
                $message->to($user->email);
                if ($attachFile) {
                    $message->attach($_SERVER['DOCUMENT_ROOT'] . $attachFile);
                }
            });
        }
    }

}
