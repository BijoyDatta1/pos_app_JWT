<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Product</h4>
                </div>
                <div class="align-items-center col">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0  bg-gradient-primary">Create</button>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tableList">

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>
    getList();
    async function getList() {
        showLoader();
        let req = await axios.get('/getallproduct');
        hideLoader();

        //for use the jqurey dataTable id selected by jqurey
        let tableData = $("#tableData");
        let tableList = $("#tableList");
        
        //DataTable(),empty() and destroy() fucntion from jqurey Data Table plagin. those function fast distroy the table and then empty the table
        tableData.DataTable().destroy();
        tableList.empty();

         if(req.status === 200 && req.data['status'] === 'success'){
            req.data.data.forEach(function(item,index){
                let row = `<tr>
                        <td>${index +1}</td>
                        <td><img class="w-15 h-auto" src="uploads/${item['productImg']}" alt="${item['productName']}"></td>
                        <td>${item['productName']}</td>
                        <td>${item['productPrice']}</td>
                        <td>${item['productUnit']}</td>
                        <td>
                            <button type="button" data-id = ${item['id']} class="btn EditBtn btn-warning">Edit</button>
                            <button type="button" data-id = ${item['id']} class="btn DeleteBtn btn-danger">Delete</button>
                        </td>
                    </tr>`
                    tableList.append(row);
            });
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
        

        //jqurey data table plagin 
        new DataTable('#tableData', {
            order:[[0,'desc']],
            lengthMenu:[5,10,15,20,30]
        });
    }
</script>

