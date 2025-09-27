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
                    
                    <!-- Left side (table) -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <tbody>
                                    <tr>
                                        <th style="width: 150px;">Title</th>
                                        <td>{{ $category->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td style="white-space: pre-line;">{{ $category->description ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Serial</th>
                                        <td>{!! $category->serial !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        @if($category->status == 'active')
                                            <td class="badge bg-success">Active</td>
                                        @else
                                            <td class="badge bg-danger">Inactive</td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Right side (image) -->
                    <div class="col-md-6 text-center">
                        @if ($category->image)
                            <img src="{{ $category->image ?? asset('/assets/images/users/avatar.png') }}" 
                                 alt="Picture"
                                 style="max-width: 500px; height: auto; border-radius: 2%; border: 1px solid #d9d9d9; padding: 10px;">
                        @endif
                    </div>

                </div>

                <!-- Buttons -->
                <div class="mt-4">
                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary">Edit Category</a>
                    <a href="{{ route('category.index') }}" class="btn btn-secondary">Back to Blogs List</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection