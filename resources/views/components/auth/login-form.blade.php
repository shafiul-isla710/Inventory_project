<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4>Sign in with credentials</h4>
                    <br/>
                    <input id="email" placeholder="User Email" id='email' class="form-control" type="email"/>
                    <br/>
                    {{-- <input id="password" placeholder="User Password" id='password' class="form-control" type="password"/> --}}
                    <div class="row">
                        <div class="col-md-10">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter password" autocomplete="off"
                            aria-label="Password">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-outline-secondary" type="button" id="show-password">Show</button>
                        </div>
                    </div>
                    
                    <div class="form-check mt-3">
                        <input class="form-check-input" name="remember" id="remember" type="checkbox" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                    <br/>
                    <button onclick="submitLogin()" class="btn w-100 bg-gradient-primary" id="login-btn" disabled>Next</button>
                    <hr/>
                    <div id="link" class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{ route('register.page') }}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{ route('forgot-password.send-otp.page') }}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')

<style>
   #login-btn.disabled{
       opacity: 0.5;
   }
</style>

@endpush

@push('script')
    <script>
        async function submitLogin() {
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;

            if (email.length === 0) {
                errorToast("Email is required");
            } else if (password.length === 0) {
                errorToast("Password is required");
            } else {
                showLoader();
                try {
                    let res = await axios.post("/backend/login", {
                        email: email,
                        password: password
                    });
                    hideLoader();

                    if (res.status === 200 && res.data.status === true) {
                        successToast(res.data.message);
                        let userData = res.data.data;
                        localStorage.setItem("user", JSON.stringify(userData));
                        setTimeout(() => {
                            window.location.href = "/dashboard";
                        },2000)
                    } else if (res.response.status === 422) {
                        let errors = res.response.data.errors;
                        for (let field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                errorToast(errors[field][0]);
                            }
                        }
                    } 
                     else {
                        errorToast(res.data.message);
                    }
                } catch (err) {
                        hideLoader();

                        if (err.response) {
                            if (err.response.status === 401) {
                                // Handle unauthorized specifically
                                errorToast(err.response.data.message || "Unauthorized");
                            }
                            else if (err.response.status === 422) {
                                // Handle validation errors
                                let errors = err.response.data.errors;
                                if (Array.isArray(errors)) {
                                    errors.forEach(msg => errorToast(msg));
                                } else if (typeof errors === 'object') {
                                    for (let field in errors) {
                                        if (errors.hasOwnProperty(field)) {
                                            errorToast(errors[field][0]);
                                        }
                                    }
                                }
                            }
                            else {
                                // Other server errors
                                errorToast(err.response.data.message || "Something went wrong");
                            }
                        } else {
                            // Network or unknown error
                            errorToast(err.message || "Network error");
                        }
                    }
                }
        }

        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginButton = document.getElementById('login-btn');
       
        function enableLoginButton() {
            if (emailInput.value.length > 0  && passwordInput.value.length >= 6 ) {
                loginButton.disabled = false;
            } else {
                loginButton.disabled = true;
            }
        }

        emailInput.addEventListener('input', enableLoginButton);
        passwordInput.addEventListener('input', enableLoginButton);

        const btn = document.getElementById('show-password');
        const input = document.getElementById('password');

        btn.addEventListener('click', () => {
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = 'Hide'; 
            } else {
                input.type = 'password'; 
                btn.textContent = 'Show'; 
            }
        });
        

    </script>
@endpush
