<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Customer</h4>
                </div>
                <div class="align-items-center col">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 bg-gradient-primary">Create</button>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
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

    async function getList(){
        showLoader();
        let res = await axios.get('/getallcustomer');
        hideLoader();

        if(res.status === 200 && res.data['status'] === 'success'){
            
            //for use the jqurey dataTable id selected by jqurey
            let tableData = $("#tableData");
            let tableList = $("#tableList");

            //DataTable(),empty() and destroy() fucntion from jqurey Data Table plagin. those function fast distroy the table and then empty the table
            tableData.DataTable().destroy();
            tableList.empty();

            res.data.customer.forEach(function(item, index){
                let row = `<tr>
                        <td>${index + 1}</td>
                        <td>${item['customerName']}</td>
                        <td>${item['customerEmail']}</td>
                        <td>${item['customerMobile']}</td>
                        <td>
                            <button type="button" data-id = ${item['id']} class="btn EditBtn btn-warning">Edit</button>
                            <button type="button" data-id = ${item['id']} class="btn DeleteBtn btn-danger">Delete</button>
                        </td>
                    </tr>`

                tableList.append(row);
            });

            //jqurey data table plagin 
            new DataTable('#tableData', {
            order:[[0,'desc']],
            lengthMenu:[5,10,15,20,30]
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
    }
</script>



