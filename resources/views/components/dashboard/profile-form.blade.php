@push('style')
<style>
    #previewImage{
        width: 100px;
        height: 100px;
        border-radius: 80%;
    }
</style>
@endpush
<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Role</label>
                                <input id="role" readonly class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" readonly type="email"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Full Name</label>
                                <input id="name" placeholder="Full Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Phone Number</label>
                                <input id="phone" placeholder="Phone Number" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Address</label>
                                <textarea id="address" placeholder="Address" class="form-control"></textarea>
                            </div>
                            <div class="col-md-4 p-2 row">  
                                <div class="col-md-8 p-2">
                                    <input  id="avatar" class="form-control mt-2" type="file" onchange="onFileChange(event)">
                                </div> 
                                <div class="col-md-4 p-2">                          
                                    <img id="previewImage" alt="">
                                </div>
                            </div>
                            <script>
                                
                            </script>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  bg-gradient-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        getProfile()
        async function getProfile(){
            showLoader();
            let res = await axios.get("/backend/user-profile")
            hideLoader();

            if(res.status===200){
                // console.log(res.data.data);
                // let data = JSON.parse(localStorage.getItem('user'));
                let data = res.data.data;
                document.getElementById('role').value=data.role;
                document.getElementById('email').value=data.email;
                document.getElementById('name').value=data.name;
                document.getElementById('phone').value=data.phone;
                document.getElementById('address').value=data.address;
                
                if(data.avatar){
                    document.getElementById('previewImage').src=data.avatar;
                }
            }
            else{
                errorToast(res.data['message'])
            }
        }

        function onFileChange(event){
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('previewImage');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        document.querySelector('.previewImage').addEventListener('click',function(){
            document.getElementById('avatar').click();
        })

        async function onUpdate() {
            let name = document.getElementById('name').value;
            let phone = document.getElementById('phone').value;
            let address = document.getElementById('address').value;
            let avatarFile = document.getElementById('avatar');
            let avatarImage = avatarFile.files[0];

            if(name.length===0){
                errorToast('First Name is required')
            }

            else if(phone.length===0){
                errorToast('Phone is required')
            }
            else if(address.length===0){
                errorToast('Address is required')
            }

            showLoader();
            try {

                let formData = new FormData();
                formData.append('name', name);
                formData.append('phone', phone);
                formData.append('address', address);
                
                if(avatarImage){
                    formData.append('avatar', avatarImage);
                }

                let res = await axios.post("/backend/profile-update",formData,{
                     Headers:{
                        'Content-Type':'multipart/form-data'
                    }
                })
                hideLoader();
                if (res.status === 200 && res.data.status === true) {

                    let updateUser = res.data.data;
                    // localStorage.setItem('user', JSON.stringify(updateUser));
                    localStorage.setItem("user", JSON.stringify(res.data.data))
                    phone.value = updateUser.phone;
                    address.value = updateUser.address;
                    
                    if(updateUser.avatar){
                        document.getElementById('previewImage').src=updateUser.avatar;
                    }   
                    successToast(res.data.message);
                    setTimeout(() => {
                        window.location.href = '/profile';
                    },3000)
                }
                else if (res.response.status === 422) {
                    let errors = res.response.data.errors;
                    for (let field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorToast(errors[field][0]);
                        }
                    }
                }
                else {
                    console.log(res.data);
                    errorToast(res.data.message);
                }

            } catch (err) {
                hideLoader();
                if (err.response) {
                    let errors = err.response.data.errors;
                    if (Array.isArray(errors)) {
                        errors.forEach(msg => errorToast(msg));
                    } else {
                        for (let field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                errorToast(errors[field][0]);
                            }
                        }
                    }
                } else if (err.response && err.response.status === 401) {
                    errorToast(err.response.data.message);
                } else {
                    errorToast(err.response.data.message);
                }
            }
        }

    </script>
@endpush
