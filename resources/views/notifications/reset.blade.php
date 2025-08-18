@component('mail::message')
# Reset Kata Sandi

Halo {{ $notifiable->name }},

Kami menerima permintaan untuk mereset kata sandi akun Anda. Klik tombol di bawah untuk melanjutkan.

@component('mail::button', ['url' => $url])
Reset Kata Sandi
@endcomponent

Jika Anda tidak melakukan permintaan ini, abaikan email ini.

Terima kasih,  
{{ __('Manajemen Petung Park') }}
@endcomponent
