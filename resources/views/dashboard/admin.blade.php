@extends('layouts.app')

@section('content')
    <h1 class="admin-heading">Selamat Datang, Admin!</h1>
    <p class="admin-subheading">Berikut adalah ringkasan data:</p>

    <section class="admin-stats-row" aria-label="Ringkasan data admin">
        <article class="admin-stat-card">
            <div class="admin-stat-label"></div>
            <div class="admin-stat-body">
                <div class="admin-stat-value"></div>
            </div>
        </article>
        <article class="admin-stat-card">
            <div class="admin-stat-label"></div>
            <div class="admin-stat-body">
                <div class="admin-stat-value"></div>
            </div>
        </article>
        <article class="admin-stat-card">
            <div class="admin-stat-label"></div>
            <div class="admin-stat-body">
                <div class="admin-stat-value"></div>
            </div>
        </article>
        <article class="admin-stat-card">
            <div class="admin-stat-label"></div>
            <div class="admin-stat-body">
                <div class="admin-stat-value"></div>
            </div>
        </article>
        <article class="admin-stat-card">
            <div class="admin-stat-label"></div>
            <div class="admin-stat-body">
                <div class="admin-stat-value"></div>
            </div>
        </article>
        <article class="admin-stat-card">
            <div class="admin-stat-label"></div>
            <div class="admin-stat-body">
                <div class="admin-stat-value"></div>
            </div>
        </article>
        <article class="admin-stat-card">
            <div class="admin-stat-label"></div>
            <div class="admin-stat-body">
                <div class="admin-stat-value"></div>
            </div>
        </article>
    </section>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection
