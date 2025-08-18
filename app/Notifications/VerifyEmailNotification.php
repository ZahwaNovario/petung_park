<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = url(route('verification.verify', [
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ], false));
    
        return (new MailMessage)
            ->subject('Verifikasi Email Anda')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Silakan klik tombol di bawah ini untuk memverifikasi email Anda:')
            ->action('Verifikasi Email', $verificationUrl)
            ->line('Jika Anda tidak membuat akun ini, abaikan email ini.')
            ->markdown('notifications.verify', ['url' => $verificationUrl, 'notifiable' => $notifiable,'logo' => url('images/footer/logoPetungPark.png')]);
    }    
        public function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addHours(6), 
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }
}
