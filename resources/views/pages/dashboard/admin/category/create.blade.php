@extends('layouts.sidenav-layout')

@section('title')
 create
@endsection
@section('content')

 <div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('pages.dashboard.admin.category.form')
                </form>
            </div>
        </div>
    </div>
</div>

@endsection