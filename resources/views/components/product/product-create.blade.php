<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategory">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Name</label>
                                <input type="text" class="form-control" id="productName">

                                <label class="form-label mt-2">Price</label>
                                <input type="text" class="form-control" id="productPrice">

                                <label class="form-label mt-2">Unit</label>
                                <input type="text" class="form-control" id="productUnit">

                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label">Image</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImg">

                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
                </div>
            </div>
    </div>
</div>
<script>
    getCategory();
    async function getCategory(){
        showLoader();
        let req = await axios.get('/getallcategory');
        hideLoader();
        let categorySection = document.getElementById('productCategory');
        if(req.status === 200 && req.data['status'] === 'success'){

            req.data.category.forEach(function(item,index){
                let row = `<option value="${item['id']}">${item['category_name']}</option>`
                categorySection.innerHTML += row;
            })

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

    async function Save(){
        let category_id = document.getElementById('productCategory').value;
        let productName = document.getElementById('productName').value;
        let productPrice = document.getElementById('productPrice').value;
        let productUnit = document.getElementById('productUnit').value;
        let productImg = document.getElementById('productImg').files[0];

        if(category_id.length === 0){
            errorToast('Please select a category');
        }else if(productName.length === 0){
            errorToast('Please enter product name');
        }else if(productPrice.length === 0){
            errorToast('Please enter product price');
        }else if(productUnit.length === 0){
            errorToast('Please enter product unit');
        }else if (!productImg){
            errorToast('Please select a product image');
        }else{
            showLoader();

             let formData = new FormData();
            formData.append("category_id", category_id);
            formData.append("productName", productName);
            formData.append("productPrice", productPrice);
            formData.append("productUnit", productUnit);
            formData.append("productImg", productImg);

            let req = await axios.post("/createproduct", formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            });
            hideLoader();
            if(req.status === 200 && req.data['status'] === 'success'){
                successToast(req.data['message']);
                document.getElementById("save-form").reset();
                document.getElementById('modal-close').click();
                await getList();
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
    }
</script>



