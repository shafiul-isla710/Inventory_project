@extends('layouts.sidenav-layout')

@section('title')
 create
@endsection
@section('content')

 <div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.blog.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('backend.core.blog.form')
                </form>
            </div>
        </div>
    </div>
</div>

@endsection