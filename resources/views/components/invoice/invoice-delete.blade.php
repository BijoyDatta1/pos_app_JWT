<div class="modal animated zoomIn" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-nond" id="deleteID"/>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn bg-gradient-success" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn bg-gradient-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function itemDelete() {
        let invoice_id = document.getElementById('deleteID');
        showLoader();
        let req = await axios.post("/deleteinvoice",{
            "invoice_id" : invoice_id
        });
        hideLoader();
        
        if(req.status === 200 && req.data['status'] === 'success'){
            successToast(req.data['message']);
            document.getElementById('delete-modal-close').click();
            getList();
        }else{
            let data = req.data.message;
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

