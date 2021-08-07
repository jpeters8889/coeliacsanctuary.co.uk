<h1>New Place Recommendation</h1>

<strong>Name:</strong> {{ $placeRecommendation->name }}<br/><br/>
<strong>Email:</strong> {{ $placeRecommendation->email }}<br/><br/>
<hr/>
<strong>Place Name:</strong> {{ $placeRecommendation->place_name }}<br/><br/>
<strong>Place Location:</strong> {{ cs_nl2br($placeRecommendation->place_location) }}<br/><br/>
<strong>Place Web Address:</strong> {{ $placeRecommendation->place_web_address }}<br/><br/>
<strong>Place Venue Type:</strong> {{ $placeRecommendation->venueType?->venue_type }}<br/><br/>
<strong>Place Details:</strong>{{ cs_nl2br($placeRecommendation->place_details) }}
