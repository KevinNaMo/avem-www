@extends('layouts.main')

@section('content')
	<div class="cta">
		<h3 class="cta-title">
			Porque la medicina no solo está en los libros.
		</h3>

		<p class="cta-text">
			Somos la asociación de estudiantes de medicina más grande de
			la Universitat de València. No pases por la facultad como un mero
			trámite. Conoce gente, aprende, sé crítico, y diviértete.
			Lo mejor está por llegar.
		</p>

		<a href="{{ route('register') }}" class="cta-button" role="button">Hazte socio</a>
	</div>

	{{-- <div id="welcome-carousel" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner" role="listbox">
			<div class="carousel-item active">
				<img class="carousel-image" src="http://placehold.it/1200x400">
			</div>
			<div class="carousel-item">
				<img class="carousel-image" src="http://placehold.it/1200x400">
			</div>
			<div class="carousel-item">
				<img class="carousel-image" src="http://placehold.it/1200x400">
			</div>
		</div>
	</div> --}}
@stop
