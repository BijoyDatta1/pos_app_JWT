<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate">

                                <label class="form-label mt-3">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmailUpdate">

                                <label class="form-label mt-3">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobileUpdate">

                                <input type="text" class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>
        </div>
    </div>
</div>
<script>
    async function FillUpUPdateForm(id){
        showLoader();
        let res = await axios.post('/getcustomeritem',{
            id:id
        });
        hideLoader();
        if(res.status === 200 && res.data['status'] === 'success'){
            console.log(res.data['customer']['customerName']);
            document.getElementById('customerNameUpdate').value = res.data['customer']['customerName'];
            document.getElementById('customerEmailUpdate').value = res.data['customer']['customerEmail'];
            document.getElementById('customerMobileUpdate').value = res.data['customer']['customerMobile'];
            document.getElementById('updateID').value = res.data['customer']['id'];
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

    async function Update(){
        let customerName = document.getElementById('customerNameUpdate').value;
        let customerEmail = document.getElementById('customerEmailUpdate').value;
        let customerMobile = document.getElementById('customerMobileUpdate').value;
        let id = document.getElementById('updateID').value;

        showLoader();
        let res = await axios.post('/customerupdate',{
            customerName:customerName,
            customerEmail:customerEmail,
            customerMobile:customerMobile,
            id:id
        });
        hideLoader();

        if(res.status === 200 && res.data['status'] === 'success'){
            successToast(res.data['message']);
            document.getElementById('update-modal-close').click();
            getList();
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
</script>

