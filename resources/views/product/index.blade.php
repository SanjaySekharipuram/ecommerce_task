@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    
<div class="container">
  
      <div class="row">
          <div class="col-md-8 offset-md-2">
              <div class="row">
                  <div class="col-md-12 text-center">
                      <h4>Product List</h4>
                  </div>
                  <div class="col-md-12 text-right mb-5">
                      <a class="btn btn-success" href="javascript:void(0)" id="addNewProduct"> Add New Product</a>
                  </div>
                  <div class="col-md-12">
                      <table class="table table-bordered data-table">
                          <thead>
                              <tr>
                                  <th>Id</th>
                                  <th>Name</th>
                                  <th>Price</th>
                                  <th width="280px">Action</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
     
  <div class="modal fade" id="ajaxModel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modelHeading"></h4>
              </div>
              <div class="modal-body">
                  <form id="productForm" name="productForm" class="form-horizontal">
                      <input type="hidden" name="product_id" id="product_id">
                      <div class="form-group">
                          <label for="name" class="col-sm-3 control-label">Product Name</label>
                          <div class="col-sm-12">
                              <input type="text" class="form-control" id="name" name="name" placeholder="Enter Product Name" value="" maxlength="50" required="">
                          </div>
                      </div>
       
                      <div class="form-group">
                          <label class="col-sm-2 control-label">Product Price</label>
                          <div class="col-sm-12">
                              <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="" required="">
                          </div>
                      </div>
       
                      
        
                      <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  
    
      
</div>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
  
  <script type="text/javascript">
      $(function () {
       
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('product.get') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'price', name: 'price'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          initComplete: function() {
              this.api().columns().every(function(columnIndex) {
                  var column = this;
                  var header = $(column.header());
  
                      if (columnIndex === 1 || columnIndex === 2) {
                          var searchInput = $('<input type="text" class="column-search" placeholder="Search...">')
                              .appendTo(header)
                              .on('keyup change', function() {
                                  if (column.search() !== this.value) {
                                      column.search(this.value).draw();
                                  }
                              });
  
                      }
              });
          }
      });
       
  
      
      $('#addNewProduct').click(function () {
          $('#saveBtn').val("create-product");
          $('#product_id').val('');
          $('#productForm').trigger("reset");
          $('#modelHeading').html("Add New Product");
          $('#ajaxModel').modal('show');
      });
      
      $('body').on('click', '.editProduct', function () {
          var product_id = $(this).data('id');
          $.get("{{ route('product.edit') }}" +'/' + product_id , success => {
              const { id, name, price,phone,gender } = success.data;
  
              $('#modelHeading').html("Edit Product");
              $('#saveBtn').val("edit-user");
              $('#ajaxModel').modal('show');
              $('#product_id').val(id);
              $('#name').val(name);
              $('#price').val(price);
          })
      });
  
      $('#saveBtn').click(function (e) {
          e.preventDefault();
          $(this).html('Sending..');
      
          $.ajax({
              data: $('#productForm').serialize(),
              url: "{{ route('product.store') }}",
              type: "POST",
              dataType: 'json',
              success: function (response) {
                  if (response.success === true) {
                      Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: 'Product saved successfully!',
                      showCancelButton: false,
                      confirmButtonText: 'OK',
                      customClass: {
                          confirmButton: 'btn btn-primary'
                      },
                      iconHtml: '<i class="fas fa-check-circle"></i>'
                      });
  
                      $('#productForm').trigger("reset");
                      $('#ajaxModel').modal('hide');
                      table.draw();
                      $('#saveBtn').html('Save Changes');
                  } else {
                      Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: response.errorMessage,
                      confirmButtonText: 'OK',
                      customClass: {
                          confirmButton: 'btn btn-primary'
                      },
                      iconHtml: '<i class="fas fa-exclamation-circle"></i>'
                      });
                      
                      $('#saveBtn').html('Save Changes');
                  }
              },
                  error: function (xhr, status, error) {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Something went wrong.Please try again.',
                          confirmButtonText: 'Ok',
                          customClass: {
                          confirmButton: 'btn btn-primary'
                          },
                          iconHtml: '<i class="fas fa-exclamation-circle"></i>'
                      });
  
                      console.log('Error:', xhr.status, xhr.responseText);
                      $('#saveBtn').html('Save Changes');
                  }
          });
      });
  
      $('body').on('click', '.deleteProduct', function () {
          var product_id = $(this).data("id");
          new swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this product!",
              icon: "warning",   
          
              showCancelButton: true,
              confirmButtonText: "Yes",
              cancelButtonText: "No",
              dangerMode: true,
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      type: "DELETE",
                      url: "{{ route('product.delete') }}" + '/' + product_id,
                      success: function (data) {
                          table.draw();
                      },
                      error: function (data) {
                          console.log('Error:', data);
                      }
                  });
              } 
          });
      });
  });
  </script>

{{-- </html> --}}
{{-- @endsection --}}
