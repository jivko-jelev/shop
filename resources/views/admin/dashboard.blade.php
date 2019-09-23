@extends('admin.partials.master')

@section('content')
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{ \App\User::all()->count() }}</h3>

                <p>Потребители</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('users') }}" class="small-box-footer">Повече <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
@endsection
