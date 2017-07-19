@extends('layouts.master')

@section('content')
	<span>
		<img src="{{$image->url}}"><br/>
		<h2>{{ $image->title }}</h2>
	</span>
	<h4>{{ trans("$copyRight") }}</h4>
	<h4>{{ trans("$lastBuildDate") }}</h4>
	<br/>
	<hr/>
	<div>
		<ul>
			@foreach($worldfeeds as $feed)
				<li>
					<strong>{{$feed}}</strong>
					<strong>{{$feed->title}}</strong><br/>
					<blockquote>{{Str::limit(strip_tags($feed->description), 350)}}</blockquote>
					<strong>Date: {{$feed->pubDate}}</strong> <br/>
					<strong>Source: <a href="{{$feed->link}}">{{str_limit($feed->link, 35)}}</a> </strong>
				</li>

			@endforeach
		</ul>
	</div>
@endsection