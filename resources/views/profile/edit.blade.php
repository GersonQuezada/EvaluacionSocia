@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Perfil')

{{-- Content body: main page content --}}

@section('content_body')
    <section class="content-header">
        <h1> Datos del Perfil</h1>
    </section>
    <div class="card">
        <div class="card-body">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>




@stop




