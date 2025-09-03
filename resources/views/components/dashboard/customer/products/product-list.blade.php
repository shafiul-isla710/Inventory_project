<div class="card">
    <div class="card-body">
        @if($products->isNotEmpty())
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="/storage/{{ $product->image }}" alt="{{ $product->name }}" class="card-img-top" height="150">
                            <div class="card-body">

                                <h4 class="card-title">{{ $product->name }}</h4>
                                <h3>{{ $product->price }}</h3>
                                <h3>{{ $product->descriptions }}</h3>

                                <button type="button" onclick="orderNow('{{ $product->id }}')">Order Now</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
        <div>No Product found</div>
        @endif
    </div>
</div>


@push('script')

    <script>
        async function orderNow(productID)
        {
            try{
                if(confirm('Are you confirm?')){
                let res = await axios.post('/customer/products/order',{
                        'product_id':productID
                    });

                    if(res.status === 200 && res.data.status === true){
                        successToast(res.data.message );
                    }
                    else {
                        errorToast("Something went wrong");
                    } 
                }
            }
            catch(error){
                if(error.response.status === 404){
                    errorToast(error.response.data.message);
                }
                else if(error.response.status === 500){
                    errorToast("Something went wrong. Please try again.");
                }
                else
                errorToast("Something went wrong");
            }
        }
    </script>

@endpush