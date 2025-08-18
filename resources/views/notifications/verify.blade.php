@component('mail::message')
# Verifikasi Email Anda

Halo {{ $notifiable->name }},

Silakan klik tombol di bawah ini untuk memverifikasi email Anda.

@component('mail::button', ['url' => $url])
Verifikasi Email
@endcomponent

Jika Anda tidak membuat akun ini, abaikan email ini.

Terima kasih,  
{{ __('Manajemen Petung Park') }}

@endcomponent
