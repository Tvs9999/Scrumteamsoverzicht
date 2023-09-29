@extends('layout/app')

@section('content')
<div id="users">
    <div class="content-header">
        <h1>Gebruikers</h1>
    </div>

    <div class="add-user">
        <a href="/register"><i class="fa-solid fa-plus"></i></a>
    </div>

    @if (count($users) > 0)
        @foreach ($users as $user)
            <div class="user">
                <div class="info">
                    <p class="name">{{$user->firstname}} {{$user->lastname}}</p>
                    <div class="divider"></div>
                    <p>{{$user->email}}</p>
                    <div class="divider"></div>
                    @if ($user->role === 0)
                        <p>Leerling</p>
                        <div class="divider"></div>
                        <p>{{$user->class->name}}</p>
                    @else
                        <p>Leraar</p>
                    @endif
                </div>
                @if ($user->role === 0)
                    @if ($user->present === 0)
                        <div class="absent">
                            <i class="fa-solid fa-xmark"></i>
                        </div>    
                        @else
                        <div class="present">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    @endif
                    
                @endif
            </div>
        @endforeach    
    @else
        <div class="no-users">
            <p>Er zijn geen gebruikers gevonden</p>
        </div>
    @endif
</div>

@endsection