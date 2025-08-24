<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h5>Invoices</h5>
                </div>
                <div class="align-items-center col">
                    <a    href="{{url("/salepage")}}" class="float-end btn m-0 bg-gradient-primary">Create Sale</a>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>No</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Total</th>
                    <th>Vat</th>
                    <th>Discount</th>
                    <th>Payable</th>
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
    // window.onload = function() {
    //      var myModal = new bootstrap.Modal(document.getElementById('create-modal'));
    //      myModal.show();
    //     }

    getList();
    async function getList(){
        showLoader();
        let req = await axios.get("/getallinvoice");
        hideLoader();

        if(req.status === 200 && req.data['status'] === 'success'){
            //for use the jqurey dataTable id selected by jqurey
            let tableData = $("#tableData");
            let tableList = $("#tableList");

            //DataTable(),empty() and destroy() fucntion from jqurey Data Table plagin. those function fast distroy the table and then empty the table
            tableData.DataTable().destroy();
            tableList.empty();

            req.data.data.forEach(function(item,index){
                let row = `<tr>
                        <td>${index + 1}</td>
                        <td>${item['customer']['customerName']}</td>
                        <td>${item['customer']['customerMobile']}</td>
                        <td>${item['total']}</td>
                        <td>${item['vat']}</td>
                        <td>${item['discount']}</td>
                        <td>${item['payable']}</td>
                        <td>
                            <button data-id="${item['id']}" data-cus="${item['customer']['id']}" class="viewBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0"><i class="fa text-sm fa-eye"></i></button>
                            <button data-id="${item['id']}" data-cus="${item['customer']['id']}" class="deleteBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0"><i class="fa text-sm  fa-trash-alt"></i></button>
                        </td>
                    </tr>`
                tableList.append(row);
            });

            let buttons = document.querySelectorAll(".deleteBtn");
            buttons.forEach(function(button){
                button.addEventListener('click',function(){
                    document.getElementById('deleteID').value = this.getAttribute('data-id');
                    let myModal = new bootstrap.Modal(document.getElementById('delete-modal'));
                    myModal.show();
                })
            })

            //jqurey data table plagin 
            new DataTable('#tableData', {
            order:[[0,'desc']],
            lengthMenu:[5,10,15,20,30]
            });

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

