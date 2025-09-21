@extends('layouts.sidenav-layout')

@section('title')
 Category Details
@endsection

@section('content')

 <h4 class="card-title">Category Details</h4>

 <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Title</th>
                                    <td>{{ $blog->title }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{!! $blog->summary !!}</td>
                                </tr>
                                <tr>
                                    <th>@lang('blog.type')</th>
                                    <td>{{ $blog->type }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('blog.author')</th>
                                    <td>{{ $blog->author }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('blog.serial')</th>
                                    <td>{!! $blog->serial !!}</td>
                                </tr>
                                <tr>
                                    <th>@lang('common.status')</th>
                                    <td>{!!$blog->status_badge!!}</td>
                                </tr>
                            </table>
                    </div>
                    <div class="col-md-6 text-center">
                            @if ($blog->image)
                                <img src="{{ $blog->image ?? asset('/assets/images/users/avatar.png') }}" alt="Picture"
                                    style="max-width: 500px; height: auto; border-radius: 2%; border: 1px solid #d9d9d9; padding: 10px;">
                            @else
                                <img src="{{ asset('/assets/images/users/avatar.png') }}" alt="Picture"
                                    style="width: 150px; height: 150px; border-radius: 50%;">
                            @endif
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.blog.edit', $blog) }}" class="btn btn-primary">Edit Blog</a>
                        <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Back to Blogs List</a>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection