
<div class='container'>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class='d-flex justify-content-between mb-2'>
                        <h4 class="card-title">Category List</h4>

                        <button class="btn btn-primary" onclick="location.href='{{ route('category.create') }}'">
                            <i class="fa fa-plus"></i> Add Category
                        </button>
                        
                    </div>

                    <table id='example' class="table table-bordered table-hover dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Serial</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody >
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ Str::limit($category->description, 100) }}</td>
                                    <td>{{ $category->serial }}
                                    <td>
                                        @if($category->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('category.show', $category->id) }}" class="btn btn-info"><i
                                                class="mdi mdi-file-eye"> Show</i></a>
                                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-success"><i
                                                class="mdi mdi-pencil"></i> Edit</a>
                                        <a href="javascript:void(0);" class="btn btn-danger delete-item"
                                            data-id="{{ $category->id }}">
                                            <i class="mdi mdi-delete"> Delete</i>
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

@push('script')

<script>
    let table = new DataTable('#example');
</script>

@endpush

