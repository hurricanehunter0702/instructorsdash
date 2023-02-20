@if(isset($data['pagewebsites']))
	@foreach($data['pagewebsites'] as $p)
		@if(!$p->is_shown_on_header)
			<li><a href="{{ route('pagewebsite', $p->slug) }}">{{ $p->title }}</a></li>
		@endif
	@endforeach
@endif