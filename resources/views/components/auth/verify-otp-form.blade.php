<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>ENTER OTP CODE</h4>
                    <br/>
                    <label>4 Digit Code Here</label>
                    <input id="otp" placeholder="Code" class="form-control" type="text"/>
                    <br/>
                    <button onclick="verifyOtp()" class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function VerityOtp(){
        let otp = document.getElementById('otp').value;

        if(otp.length === 0){
             errorToast('Please Enter The Otp')
        }else{
            showLoader();
            let res = await axios.post("/verifyotp",{
                otp: otp
            });
            hideLoader();
            if(res.status === 200 && res.data['success']){
                successToast(res.data['message']);
                setTimeout(() => {
                    window.location.href = "/resetpasswordpage";
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