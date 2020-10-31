<strong>Name:</strong> {{ $request['name'] }}<br/><br/>
<strong>Subject:</strong> {{ $request['subject'] }}<br/><br/>
<strong>Email:</strong> {{ $request['email'] }}<br/><br/>
<strong>Details:</strong>{{ cs_nl2br($request['message']) }}
