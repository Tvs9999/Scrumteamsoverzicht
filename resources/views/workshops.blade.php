@extends('layout/app')

@section('content')
    <div id="workshops">
        <div class="content-header">
            <h1>Workshops</h1>
        </div>
        <div class="workshops">
            @if ($workshops->count()>0)
                @foreach ($workshops as $workshop)
                    <div class="workshop">
                        <div class="icons">
                            <p>{{$workshop->name}}</p>
                            <p></p>
                        </div>
                        <div class="title">
                            <div class="icon"></div>
                            <h2></h2>
                        </div>
                        <div class="info">
                            <p></p>
                            <div class="divider"></div>
                            <p></p>
                            <div class="divider"></div>
                            <p></p>
                        </div>
                        <button>Aanmeldingen</button>
                    </div>       
                @endforeach
            @else 
                <div class="no-workshops">
                    <p>no workshops</p>
                </div>
            @endif
        </div>
        <div class="add-workshop">
            <a href="/addWorkshop"><i class="fa-solid fa-plus"></i></a>
        </div>
    </div>
@endsection