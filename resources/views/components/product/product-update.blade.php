<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">


                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Name</label>
                                <input type="text" class="form-control" id="productNameUpdate">

                                <label class="form-label mt-2">Price</label>
                                <input type="text" class="form-control" id="productPriceUpdate">

                                <label class="form-label mt-2">Unit</label>
                                <input type="text" class="form-control" id="productUnitUpdate">
                                <br/>
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>
                                <label class="form-label mt-2">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control" id="productImgUpdate">

                                <input type="text" class="d-none" id="updateID">


                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
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
        let categorySection = document.getElementById('productCategoryUpdate');
        if(req.status === 200 && req.data['status'] === 'success'){

            req.data.category.forEach(function(item,index){
                let row = `<option value="${item['id']}">${item['category_name']}</option>`
                categorySection.innerHTML += row;
            })

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

    async function FillUpUPdateForm(id,path){
        document.getElementById('updateID').value = id;

        showLoader();
        let req = await axios.post('/getproductitem',{
            id:id
        });
        hideLoader();
        if(req.status === 200 && req.data['status'] === 'success'){
            let product = req.data['data'];
            let pathRevice = `/uploads/${path}`;
            
            document.getElementById('productNameUpdate').value = product['productName'];
            document.getElementById('productPriceUpdate').value = product['productPrice'];
            document.getElementById('productUnitUpdate').value = product['productUnit'];
            document.getElementById('productCategoryUpdate').value = product['category_id'];
            document.getElementById('oldImg').src = pathRevice;


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

    async function update(){
        let id = document.getElementById('updateID').value;
        let productName = document.getElementById('productNameUpdate').value;
        let productPrice =  document.getElementById('productPriceUpdate').value;
        let productUnit = document.getElementById('productUnitUpdate').value;
        let category_id = document.getElementById('productCategoryUpdate').value;
        let productImg = document.getElementById('productImgUpdate').files[0];

        if(productName.length === 0){
            errorToast('Please Enter the Product Name')
        }else if(productPrice.length === 0){
            errorToast('Please Enter the Product Price')
        }else if (productUnit.length === 0){
            errorToast('Please Enter the Product Unit')
        }else if (category_id.length === 0){
            errorToast('Please Enter the Product Category')
        }else{
            showLoader();
            let formData = new FormData();
            formData.append('id', id);
            formData.append('productName', productName);
            formData.append('productPrice', productPrice);
            formData.append('productUnit', productUnit);
            formData.append('category_id', category_id);
            formData.append('productImg', productImg);
            let req = await axios.post('/updateproduct',formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            hideLoader();

            if(req.status === 200 && req.data['status'] === 'success'){
                successToast(req.data['message']);
                document.getElementById('update-form').reset();
                document.getElementById('update-modal-close').click();
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


