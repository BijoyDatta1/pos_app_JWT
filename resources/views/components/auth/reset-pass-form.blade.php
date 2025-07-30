<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br/>
                    <label>New Password</label>
                    <input id="password" placeholder="New Password" class="form-control" type="password"/>
                    <br/>
                    <label>Confirm Password</label>
                    <input id="cpassword" placeholder="Confirm Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="ResetPass()" class="btn w-100 bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  async function ResetPass() {
       let Npassword = document.getElementById('password').value;
       let Cpassword = document.getElementById('cpassword').value;

       if(Npassword.length == 0){
         errorToast('Please Enter The New Password')
       }else if(Cpassword.length == 0){
         errorToast('Please Enter The Confirm Password')
       }else if(Npassword != Cpassword){
        errorToast('Password Does Not Match')
       }else{
         showLoader();
         let res = await axios.post("/resetpassword",{
            password: Npassword   
        });
        hideLoader();
        if(res.status === 200 && res.data['status'] === "success"){
            successToast('Password Reset Successfully');
            setTimeout(() => {
                window.location.href = '/loginpage'
            }, 200);
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
