<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>EMAIL ADDRESS</h4>
                    <br/>
                    <label>Your email address</label>
                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                    <br/>
                    <button onclick="sendOtp()"  class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function sendOtp() {
        let email = document.getElementById('email').value;

    
        if(email.length == 0){
            errorToast('Please Enter The Email')
        }else{
            showLoader();
            let res = await axios.post("/sendotp",{
                email:email
            });
            hideLoader();
            if(res.status === 200 && res.data['status'] === 'success'){
                sessionStorage.setItem('email', email);
                 successToast(res.data['message']);
                setTimeout(() => {
                    window.location.href = "/verifyotppage";
                }, 2000);
            }else{
                let data = res.data.message;

                if(typeof data === 'object'){
                    for (let key in data) {
                        errorToast(data[key]);
                    }
                }else{
                    errorToast(data);
                }
            }
        }
    }
</script>
