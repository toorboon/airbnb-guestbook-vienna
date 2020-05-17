<p>Dear {{ $dataArray['toName'] ?? 'Guest' }},</p>

<p>Thank you for choosing my airbnb {{ $dataArray['accommodation'] }}! I would like to ask you to register yourself for your upcoming stay in Vienna
    by clicking on the below link and filling out the register form. Be aware that the link is only valid for
    {{ $dataArray['lifetime']/60/24/7 }} week(s) from today on and you can only use it {{ $dataArray['numMaxVisits'] }} times.</p>

<a href="{{ $dataArray['url'] }}">Click here</a> to register yourself and your travel companions!
