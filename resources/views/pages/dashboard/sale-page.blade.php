@extends('layout.sidenav-layout')
@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- sale calculation section --}}
            <div class="col-md-4 col-lg-4 p-2">
                <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                    <div class="row">
                        <div class="col-8">
                            <span class="text-bold text-dark">BILLED TO </span>
                            <p class="text-xs mx-0 my-1">Name:  <span id="CName"></span> </p>
                            <p class="text-xs mx-0 my-1">Email:  <span id="CEmail"></span></p>
                            <p class="text-xs mx-0 my-1">User ID:  <span id="CId"></span> </p>
                        </div>
                        <div class="col-4">
                            <img class="w-50" src="{{"images/logo.png"}}">
                            <p class="text-bold mx-0 my-1 text-dark">Invoice  </p>
                            <p class="text-xs mx-0 my-1">Date: {{ date('Y-m-d') }} </p>
                        </div>
                    </div>
                    <hr class="mx-0 my-2 p-0 bg-secondary"/>
                    <div class="row">
                        <div class="col-12">
                            <table class="table w-100" id="invoiceTable">
                                <thead class="w-100">
                                <tr class="text-xs">
                                    <td>Name</td>
                                    <td>Qty</td>
                                    <td>Total</td>
                                    <td>Remove</td>
                                </tr>
                                </thead>
                                <tbody  class="w-100" id="invoiceList">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr class="mx-0 my-2 p-0 bg-secondary"/>
                    <div class="row">
                       <div class="col-12">
                           <p class="text-bold text-xs my-1 text-dark"> TOTAL: <i class="bi bi-currency-dollar"></i> <span id="total"></span></p>
                           <p class="text-bold text-xs my-2 text-dark"> PAYABLE: <i class="bi bi-currency-dollar"></i>  <span id="payable"></span></p>
                           <p class="text-bold text-xs my-1 text-dark"> VAT(5%): <i class="bi bi-currency-dollar"></i>  <span id="vat"></span></p>
                           <p class="text-bold text-xs my-1 text-dark"> Discount: <i class="bi bi-currency-dollar"></i>  <span id="discount"></span></p>
                           <span class="text-xxs">Discount(%):</span>
                           <input onkeydown="return false" value="0" min="0" type="number" step="0.25" onchange="DiscountChange()" class="form-control w-40 " id="discountP"/>
                           <p>
                              <button onclick="createInvoice()" class="btn  my-3 bg-gradient-primary w-40">Confirm</button>
                           </p>
                       </div>
                        <div class="col-12 p-2">

                        </div>

                    </div>
                </div>
            </div>

            {{-- pick product --}}
            <div class="col-md-4 col-lg-4 p-2">
                <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                    <table class="table  w-100" id="productTable">
                        <thead class="w-100">
                        <tr class="text-xs text-bold">
                            <td>Product</td>
                            <td>Pick</td>
                        </tr>
                        </thead>
                        <tbody  class="w-100" id="productList">

                        </tbody>
                    </table>
                </div>
            </div>

            {{-- pick customer --}}
            <div class="col-md-4 col-lg-4 p-2">
                <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                    <table class="table table-sm w-100" id="customerTable">
                        <thead class="w-100">
                        <tr class="text-xs text-bold">
                            <td>Customer</td>
                            <td>Pick</td>
                        </tr>
                        </thead>
                        <tbody  class="w-100" id="customerList">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>




    <div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Add Product</h6>
                </div>
                <div class="modal-body">
                    <form id="add-form">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 p-1">
                                    <label class="form-label">Product ID *</label>
                                    <input type="text" class="form-control" id="PId">
                                    <label class="form-label mt-2">Product Name *</label>
                                    <input type="text" class="form-control" id="PName">
                                    <label class="form-label mt-2">Product Price *</label>
                                    <input type="text" class="form-control" id="PPrice">
                                    <label class="form-label mt-2">Product Qty *</label>
                                    <input type="text" class="form-control" id="PQty">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="add()" id="save-btn" class="btn bg-gradient-success" >Add</button>
                </div>
            </div>
        </div>
    </div>


    <script>

        (async ()=>{
            showLoader();
            await CustomerList();
            await ProductList();
            hideLoader();
        })();

        let InvoiceProducts =[];

        
        function addProducts(){

             //for use the jqurey dataTable id selected by jqurey
            let tableData = $("#invoiceTable");
            let tableList = $("#invoiceList");

            //DataTable(),empty() and destroy() fucntion from jqurey Data Table plagin. those function fast distroy the table and then empty the table
            // tableData.DataTable().destroy();
            tableList.empty();

            InvoiceProducts.forEach(function(item,index){
                let row = `<tr>
                    <td>${item['productName']}</td>
                    <td>${item['ProductQnt']}</td>
                    <td>${item['ProductTotalPrice']}</td>
                    <td><a data-index="${index}" class="btn remove text-xxs px-2 py-1  btn-sm m-0">Remove</a></td>
                    </tr>`
                tableList.append(row);
            });

            InvoiceCalculation();

            let buttons = document.querySelectorAll('.remove');
            buttons.forEach(function(button){
                button.addEventListener('click',function(){
                    let index = button.getAttribute('data-index');
                    InvoiceProducts.splice(index,1);
                    addProducts();
                })
            })

            //jqurey data table plagin 
            new DataTable('#tableData', {
            order:[[0,'desc']],
            lengthMenu:[5,10,15,20,30]
            });
        }

        function DiscountChange(){
            InvoiceCalculation();
        }

        function InvoiceCalculation(){
            //get Total
            let Total = 0;
            InvoiceProducts.forEach(function(item){
                Total += Number(item['ProductTotalPrice']);
            });
            
            //get Vat
            let vatRate = 5;
            let vat = Total * vatRate / 100;
            

            //get Discount
            let discountParcentage =Number(document.getElementById('discountP').value) || 0;
            let discount = Total * discountParcentage / 100;
            if(discountParcentage > 0){
                Total = Total - discount;
            }


            //payable
            let Payable = Total + vat;

            document.getElementById('total').innerText = Total;
            document.getElementById('payable').innerText = Payable;
            document.getElementById('vat').innerText = vat;
            document.getElementById('discount').innerText = discount;


        }

        function add(){
            // parseFloat(PPrice)*parseFloat(PQty)).toFixed(2)
            let productId = document.getElementById('PId').value;
            let productName =  document.getElementById('PName').value.trim();
            let productPrice = document.getElementById('PPrice').value.trim();
            let ProductQnt = document.getElementById('PQty').value.trim();
            let ProductTotalPrice = parseFloat(productPrice) * parseFloat(ProductQnt).toFixed(2)

            if(productName.length === 0){
                errorToast("Please Enter the Product Name");
            }else if(productPrice.length === 0 || Number(productPrice) < 1){
                errorToast("Please Enter the Product Price");
            }else if(ProductQnt.length === 0 || Number(ProductQnt) < 1){
                errorToast("Please Enter the Product Quntaty");
            }else{
                let item = {"productId" : productId,"productName" : productName,"productPrice":productPrice,"ProductQnt":ProductQnt,"ProductTotalPrice":ProductTotalPrice};
                InvoiceProducts.push(item);
                console.log(InvoiceProducts);
                document.getElementById('modal-close').click();
                addProducts();
            }
        }

        function showProductDetail(productName,productPrice,productId){
            document.getElementById('PId').value = productId;
            document.getElementById('PName').value = productName;
            document.getElementById('PPrice').value = productPrice;
        }

        async function CustomerList() {

            let req = await axios.get('/getallcustomer');

            //for use the jqurey dataTable id selected by jqurey
            let tableData = $("#customerTable");
            let tableList = $("#customerList");

            //DataTable(),empty() and destroy() fucntion from jqurey Data Table plagin. those function fast distroy the table and then empty the table
            tableData.DataTable().destroy();
            tableList.empty();


            if(req.status === 200 && req.data['status'] === 'success'){
            req.data.customer.forEach(function(item, index){
                let row = `<tr>
                    <td> ${item['customerName']}</td>
                    <td>
                        <a data-name="${item['customerName']}" data-email="${item['customerEmail']}" data-id="${item['id']}" class="btn btn-outline-dark addCustomer  text-xxs px-2 py-1  btn-sm m-0">Add</a>
                    </td>
                </tr>`
                tableList.append(row);
            });
            }else{
                tableList.html("<tr><td>NO Customer Found</td></tr>");
            }

            let buttons = document.querySelectorAll(".addCustomer");
            buttons.forEach(function(button){
                button.addEventListener('click',function(){
                    document.getElementById('CName').innerText = this.getAttribute('data-name');
                    document.getElementById('CEmail').innerText = this.getAttribute('data-email');
                    document.getElementById('CId').innerText = this.getAttribute('data-id');
                    // console.log(button.getAttribute('data-name'));
                })
            })

            //jqurey data table plagin 
            new DataTable('#tableData', {
            order:[[0,'desc']],
            lengthMenu:[5,10,15,20,30]
            });
        }

        async function ProductList() {
            let req = await axios.get('/getallproduct');

            //for use the jqurey dataTable id selected by jqurey
            let tableData = $("#productTable");
            let tableList = $("#productList");

            //DataTable(),empty() and destroy() fucntion from jqurey Data Table plagin. those function fast distroy the table and then empty the table
            tableData.DataTable().destroy();
            tableList.empty();
            if(req.status === 200 && req.data['status'] === 'success'){

                req.data.data.forEach(function(item, index){
                     let row = `<tr>
                            <td> <img class="w-10" src="uploads/${item['productImg']}"/> ${item['productName']} ($ ${item['productPrice']})</td>
                            <td><a data-name="${item['productName']}" data-price="${item['productPrice']}" data-id="${item['id']}" class="btn btn-outline-dark text-xxs px-2 py-1 addProduct  btn-sm m-0">Add</a></td>
                        </tr>`
                        tableList.append(row);
                });

                let buttons = document.querySelectorAll('.addProduct');
                
                buttons.forEach(function(button){
                    button.addEventListener('click',function(){
                        let modal = new bootstrap.Modal(document.getElementById('create-modal'));
                        modal.show();
                        let productName = button.getAttribute('data-name');
                        let productPrice = button.getAttribute('data-price');
                        let productId = button.getAttribute('data-id');
                        showProductDetail(productName,productPrice,productId);

                        // AllProducts.push =[{'productName': productName, 'productPrice': productPrice,"productId" : productId}]
                        
                    })
                })

               
            }else{
                tableList.html("<tr><td>NO Product Found</td></tr>");
            }



            //jqurey data table plagin 
            new DataTable('#tableData', {
            order:[[0,'desc']],
            lengthMenu:[5,10,15,20,30]
            });

        }

        async function createInvoice(){
         
            let customer_id = document.getElementById('CId').innerText;
            let total = document.getElementById('total').innerText;
            let payable = document.getElementById('payable').innerText;
            let vat = document.getElementById('vat').innerText;
            let discount = document.getElementById('discount').innerText;
            let product = InvoiceProducts;

            if(customer_id.length === 0){
                errorToast('Select Customer');
            }else if(product.length === 0){
                errorToast('Please Select the Product form Product List');
            }else{
                showLoader();
                let req = await axios.post("/createinvoice",{
                    "customer_id" : customer_id,
                    "total" : total,
                    "payable" : payable,
                    "vat" : vat,
                    "discount" : discount,
                    "product" : product
                });
                hideLoader();
                if(req.status === 200 && req.data['status'] === 'success'){
                    window.location.href = "/invoicepage";
                    successToast(req.data['message']);
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

        

        
    //     (async ()=>{
    //       showLoader();
    //       await  CustomerList();
    //       await ProductList();
    //       hideLoader();
    //     })()
          

    //     let InvoiceItemList=[];


    //     function ShowInvoiceItem() {

    //         let invoiceList=$('#invoiceList');

    //         invoiceList.empty();

    //         InvoiceItemList.forEach(function (item,index) {
    //             let row=`<tr class="text-xs">
    //                     <td>${item['product_name']}</td>
    //                     <td>${item['qty']}</td>
    //                     <td>${item['sale_price']}</td>
    //                     <td><a data-index="${index}" class="btn remove text-xxs px-2 py-1  btn-sm m-0">Remove</a></td>
    //                  </tr>`
    //             invoiceList.append(row)
    //         })

    //         CalculateGrandTotal();

    //         $('.remove').on('click', async function () {
    //             let index= $(this).data('index');
    //             removeItem(index);
    //         })

    //     }


    //     function removeItem(index) {
    //         InvoiceItemList.splice(index,1);
    //         ShowInvoiceItem()
    //     }

    //     function DiscountChange() {
    //         CalculateGrandTotal();
    //     }

    //     function CalculateGrandTotal(){
    //         let Total=0;
    //         let Vat=0;
    //         let Payable=0;
    //         let Discount=0;
    //         let discountPercentage=(parseFloat(document.getElementById('discountP').value));

    //         InvoiceItemList.forEach((item,index)=>{
    //             Total=Total+parseFloat(item['sale_price'])
    //         })

    //          if(discountPercentage===0){
    //              Vat= ((Total*5)/100).toFixed(2);
    //          }
    //          else {
    //              Discount=((Total*discountPercentage)/100).toFixed(2);
    //              Total=(Total-((Total*discountPercentage)/100)).toFixed(2);
    //              Vat= ((Total*5)/100).toFixed(2);
    //          }

    //          Payable=(parseFloat(Total)+parseFloat(Vat)).toFixed(2);


    //         document.getElementById('total').innerText=Total;
    //         document.getElementById('payable').innerText=Payable;
    //         document.getElementById('vat').innerText=Vat;
    //         document.getElementById('discount').innerText=Discount;
    //     }


    //     function add() {
    //        let PId= document.getElementById('PId').value;
    //        let PName= document.getElementById('PName').value;
    //        let PPrice=document.getElementById('PPrice').value;
    //        let PQty= document.getElementById('PQty').value;
    //        let PTotalPrice=(parseFloat(PPrice)*parseFloat(PQty)).toFixed(2);
    //        if(PId.length===0){
    //            errorToast("Product ID Required");
    //        }
    //        else if(PName.length===0){
    //            errorToast("Product Name Required");
    //        }
    //        else if(PPrice.length===0){
    //            errorToast("Product Price Required");
    //        }
    //        else if(PQty.length===0){
    //            errorToast("Product Quantity Required");
    //        }
    //        else{
    //            let item={product_name:PName,product_id:PId,qty:PQty,sale_price:PTotalPrice};
    //            InvoiceItemList.push(item);
    //            console.log(InvoiceItemList);
    //            $('#create-modal').modal('hide')
    //            ShowInvoiceItem();
    //        }
    //     }




    //     function addModal(id,name,price) {
    //         document.getElementById('PId').value=id
    //         document.getElementById('PName').value=name
    //         document.getElementById('PPrice').value=price
    //         $('#create-modal').modal('show')
    //     }


    //     async function CustomerList(){
    //         let res=await axios.get("/list-customer");
    //         let customerList=$("#customerList");
    //         let customerTable=$("#customerTable");
    //         customerTable.DataTable().destroy();
    //         customerList.empty();

    //         res.data.forEach(function (item,index) {
    //             let row=`<tr class="text-xs">
    //                     <td><i class="bi bi-person"></i> ${item['name']}</td>
    //                     <td><a data-name="${item['name']}" data-email="${item['email']}" data-id="${item['id']}" class="btn btn-outline-dark addCustomer  text-xxs px-2 py-1  btn-sm m-0">Add</a></td>
    //                  </tr>`
    //             customerList.append(row)
    //         })


    //         $('.addCustomer').on('click', async function () {

    //             let CName= $(this).data('name');
    //             let CEmail= $(this).data('email');
    //             let CId= $(this).data('id');

    //             $("#CName").text(CName)
    //             $("#CEmail").text(CEmail)
    //             $("#CId").text(CId)

    //         })

    //         new DataTable('#customerTable',{
    //             order:[[0,'desc']],
    //             scrollCollapse: false,
    //             info: false,
    //             lengthChange: false
    //         });
    //     }


    //     async function ProductList(){
    //         let res=await axios.get("/list-product");
    //         let productList=$("#productList");
    //         let productTable=$("#productTable");
    //         productTable.DataTable().destroy();
    //         productList.empty();

    //         res.data.forEach(function (item,index) {
    //             let row=`<tr class="text-xs">
    //                     <td> <img class="w-10" src="${item['img_url']}"/> ${item['name']} ($ ${item['price']})</td>
    //                     <td><a data-name="${item['name']}" data-price="${item['price']}" data-id="${item['id']}" class="btn btn-outline-dark text-xxs px-2 py-1 addProduct  btn-sm m-0">Add</a></td>
    //                  </tr>`
    //             productList.append(row)
    //         })


    //         $('.addProduct').on('click', async function () {
    //             let PName= $(this).data('name');
    //             let PPrice= $(this).data('price');
    //             let PId= $(this).data('id');
    //             addModal(PId,PName,PPrice)
    //         })


    //         new DataTable('#productTable',{
    //             order:[[0,'desc']],
    //             scrollCollapse: false,
    //             info: false,
    //             lengthChange: false
    //         });
    //     }



    //   async  function createInvoice() {
    //         let total=document.getElementById('total').innerText;
    //         let discount=document.getElementById('discount').innerText
    //         let vat=document.getElementById('vat').innerText
    //         let payable=document.getElementById('payable').innerText
    //         let CId=document.getElementById('CId').innerText;


    //         let Data={
    //             "total":total,
    //             "discount":discount,
    //             "vat":vat,
    //             "payable":payable,
    //             "customer_id":CId,
    //             "products":InvoiceItemList
    //         }


    //         if(CId.length===0){
    //             errorToast("Customer Required !")
    //         }
    //         else if(InvoiceItemList.length===0){
    //             errorToast("Product Required !")
    //         }
    //         else{

    //             showLoader();
    //             let res=await axios.post("/invoice-create",Data)
    //             hideLoader();
    //             if(res.data===1){
    //                 window.location.href='/invoicePage'
    //                 successToast("Invoice Created");
    //             }
    //             else{
    //                 errorToast("Something Went Wrong")
    //             }
    //         }

    //     }

    </script>




@endsection
