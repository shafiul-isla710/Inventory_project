
<div class='container'>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Category List</h4>
                    <p class="card-title-desc">List of List displayed below.</p>

                    {{-- @include('backend.layouts.alerts') --}}

                    <table id="datatable-buttons" class="table table-bordered table-hover dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ Str::limit($category->description, 100) }}</td>
                                    <td>
                                        @if ($category->image)
                                            <img src="{{ asset('storage/'.$category->image) }}" style="width:60px; height:60px; object-fit:cover;" />
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-success">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
</div> <!-- end row -->
</div>

