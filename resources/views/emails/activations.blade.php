@component('mail::message')
# Aktivasi Akun

Link akan expired dalam waktu 10 menit.

@component('mail::panel')
http://localhost:8000/aktivasi/{{ $code }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
