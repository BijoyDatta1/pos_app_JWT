<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Category</h4>
                </div>
                <div class="align-items-center col">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 bg-gradient-primary">Create</button>
                </div>
            </div>
            <hr class="bg-secondary"/>
            <div class="table-responsive">
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>No</th>
                    <th>Category</th>
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
</div>

 <script>
    getlist();
    async function getlist(){
        showLoader();
        let req = await axios.get('/getallcategory');
        hideLoader();

        let tableData = $("#tableData");
        let tableList = $("#tableList");

        tableData.DataTable().destroy();
        tableList.empty();

        req.data.category.forEach(function(item,index){
            let row = `<tr>
                    <td>${index + 1}</td>
                    <td>${item['category_name']}</td>
                    <td>
                        <button type="button" data-id = ${item['id']} class="btn EditBtn btn-warning">Edit</button>
                        <button type="button" data-id = ${item['id']} class="btn DeleteBtn btn-danger">Delete</button>
                    </td>
                </tr>`
            tableList.append(row);
        });

        
        new DataTable('#tableData', {
            order:[[0,'desc']],
            lengthMenu:[5,10,15,20,30]
        });


        let DeleteButtons = document.querySelectorAll(".DeleteBtn");
        DeleteButtons.forEach(function(button){
            button.addEventListener("click", function(){
                let id = this.getAttribute("data-id");
                let modal = new bootstrap.Modal(document.getElementById('delete-modal'));
                modal.show();
                document.getElementById('deleteID').value = id;
            })
        })

        let UpdateButton = document.querySelectorAll(".EditBtn");
        UpdateButton.forEach(function(button){
            button.addEventListener('click',function(){
                let id  = this.getAttribute('data-id');
                let modal = new bootstrap.Modal(document.getElementById("update-modal"));
                modal.show();
                FillUpUPdateForm(id);
            })
        })

        //     $('.editBtn').on('click', async function () {
        //    let id= $(this).data('id');
        //    await FillUpUpdateForm(id)
        //    $("#update-modal").modal('show');
        //     })
    }


        
 </script>




