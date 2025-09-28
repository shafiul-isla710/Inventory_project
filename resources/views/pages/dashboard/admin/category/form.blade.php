<div class="row mb-3">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" item="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="dripicons-wrong me-2"></i> {{ $errors->first() }}
        </div>
    @endif

    <div class="col-lg-4 col-md-4 col-sm-6 py-2">
        <label class="form-label" for="title">@lang('blog.title')<span class="text-danger"> *</span></label>
        <input name="title" type="text" class="form-control" id="title" placeholder="@lang('blog.title')"
            value="{{ old('title',@$category->title) }}" required>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6 py-2">
        <label class="form-label" for="author">@lang('blog.author')<span class="text-danger"> *</span></label>
        <input name="author" type="text" class="form-control" id="author" placeholder="@lang('blog.author')"
            value="{{ old('author',@$category->author) }}" required>
    </div>
    
    <div class="col-lg-4 col-md-4 col-sm-6 py-2">
        <label class="form-label" for="summary">@lang('blog.summary')</label>
        <textarea name="summary" class="form-control" rows="5"  id="">{{ old('summary',@$category->summary) }}</textarea>
    </div>

    <div class='col-lg-8 col-md-8 col-sm-12 py-2'>
        <div class="mb-3">
            <label for="content" class="form-label">@lang('blog.description')</label>
            <textarea class="form-control @error('required_documents') is-invalid @enderror" id="content"
                name="description" rows="5">{{ isset($category) ? $category->description : old('description') }}</textarea>
            <small class="text-muted">List all Contents for this General Content </small>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>  
    </div>

    <div class="col-lg-3 col-md-3 col-sm-12 py-2">
        <label class="form-label" for="image">@lang('common.image')</label>
        <input name="image" type="file" class="form-control" id="image" onchange="preview_image(this)">

        <div class="form-group">
            <label class="col-form-label font-weight-bold"
                for="image">@lang('common.image_preview')</label><br>
            <img class="img-fluid" width="300" height="auto"
                style="border: 2px solid #adb5bd;margin: 0 auto; padding: 2px; border-radius: 2%;"
                id="image_preview"
                src="{{ @$category->image ? $category->image : asset('/assets/images/users/avatar.png') }}" alt="@lang('common.image_preview')">
        </div>
    </div>

    @if (@$category)
    <div class="col-lg-3 col-md-3 col-sm-6 py-2">
        <label class="form-label" for="serial">@lang('common.serial')<span class="text-danger"> *</span></label>
        <input name="serial" type="number" step="1" class="form-control" id="serial" placeholder="Enter serial number"
            value="{{ old('serial',@$category->serial) }}" required>
    </div>
    @endif

    @if (@$category)
    <div class="col-lg-3 col-md-3 col-sm-6">
        @php $error_class = $errors->has('status') ? 'parsley-error ' : ''; @endphp
        <label for="status" class="form-label">@lang('common.status')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group form-group-check pl-4">
            <div class="form-check-custom">
                <input type="radio" name="status" value="1" class="form-check-input " id="active" required
                    @if(@$category->status == 1) checked @endif>
                <label class="form-check-label" for="active">
                    @lang('active')
                </label>
            </div>

            <div class="form-check-custom">
                <input type="radio" name="status" value="0" class="form-check-input" id="inactive"
                    required @if(@$category->status == 0) checked @endif>
                <label class="form-check-label" for="inactive">
                    @lang('inactive')
                </label>
            </div>
            @if ($errors->has('status'))
                <p class="text-danger">{{ $errors->first('status') }}</p>
            @endif
        </div>
    </div>
    @endif

    <div class="col-md-12 text-right my-4">
        <button type="submit" class="btn btn-success waves-effect waves-light">
            <i class="fa fa-save"></i> @lang('common.submit')
        </button>
    </div>
</div>