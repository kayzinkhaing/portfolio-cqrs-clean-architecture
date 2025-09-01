@component('mail::message')
# New Contact Message

**Name:** {{ $messageData->name }}
**Email:** {{ $messageData->email }}
**Subject:** {{ $messageData->subject ?? 'N/A' }}

**Message:**
{{ $messageData->message }}

@component('mail::button', ['url' => config('app.url') . '/admin/contact-messages'])
View in Admin Panel
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
