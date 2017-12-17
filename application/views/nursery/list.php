<?php $this->load->view('include/template/common_header') ?>
<style type="text/css">
/*.table > tbody > tr > td {
     vertical-align: middle;
     text-align: center;
}*/
</style>
<link rel="stylesheet"
      href="<?php echo base_url('assets/theme/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>">
      <!-- Main row -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> Nursery </h3>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper">
                  <div class="row form-group">
                    <div class="col-md-12">
                      <button type="button" onclick="AddTheRow()" class="btn btn-info" data-toggle="modal" data-target="#modal-default" >
                        <span class="glyphicon glyphicon-plus"></span> Add New Nursery
                      </button>
                      <button type="button" onclick="BulkUpload()" class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-default">
                        <span class="glyphicon glyphicon-file"></span> Import File
                      </button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-hover dataTable" id="table_nursery">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Contact No.</th>
                            <th>Address</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Image</th>
                            <th>Action</th>
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
        </div>
      </div>
      <!-- AddModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="addNurseryModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="addNursery" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Add Nursery</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Name : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control name" name="name">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Contact No  : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control contact_no" name="contact_no">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Address : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control address" name="address">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Latitude : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control latitude" name="latitude">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Longitude : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control longitude" name="address">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Image : </label>
                              <div class="col-md-9">
                                  <input id="input-b1" name="image" type="file" class="file">
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger margin-0" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-default addNursery">Add</button>
                </div>
            </form>
            </div>
          </div>
      </div>
      <!-- End AddModal -->
      <!-- UpdateModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="editNurseryModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="editNursery" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Edit Nursery</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Name : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control name" name="name">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Contact No  : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control contact_no" name="contact_no">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Address : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control address" name="address">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Latitude : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control latitude" name="latitude">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Longitude : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control longitude" name="longitude">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Image : </label>
                              <div class="col-md-9">
                                  <input id="input-b1" name="image" type="file" class="file" accept=".jpg, .jpeg, .png">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"></label>
                              <div class="col-md-9">
                                  <img style='height:50px; widht:50px;' name='eimage' />
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger margin-0" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-default editNursery">Update</button>
                </div>
            </form>
            </div>
          </div>
      </div>
      <!-- End UpdateModal -->
      <!-- DeleteModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="deleteNurseryModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to delete the Nursery ? </h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger deleteNursery">Delete</button>
              </div>
            </div>
          </div>
      </div>
      <!-- End DeleteModal -->
      <!-- RecoverModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="recoverNurseryModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to recover the Nursery ?</h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success recoverNursery">Recover</button>
              </div>
            </div>
          </div>
      </div>
      <!-- End RecoverModal -->
      <!-- BulkUploadModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="bulkNurseryModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="addBulkNursery" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Add Nursery</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Download : </label>
                              <div class="col-md-9">
                                <a href="<?php echo base_url('assets/excels/NurseryExampleSheet.xlsx'); ?>" class="btn btn-info">
                                  Example File
                                </a>
                            </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Excel File : </label>
                              <div class="col-md-9">
                                  <input id="input-b1" name="excelFile" type="file" class="file">
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger margin-0" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-default editNursery">Upload</button>
                </div>
            </form>
            </div>
          </div>
      </div>
      <!-- End BulkUploadModal -->
<?php $this->load->view('include/template/common_footer'); ?>
<!-- Bootstrap-notify -->
<script src="<?php echo base_url('assets/theme/bower_components/datatables.net/js/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/theme/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
    <script type="text/javascript">
      var table = null;
      var data = [];
      var id=0;
      $(document).ready(function(){
        table = $('#table_nursery').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "responsive": true,
          "autoWidth": false,
          "pageLength": 10,
          "ajax": {
            "url": "<?php echo site_url('nursery/get'); ?>",
            "type": "POST"
          },
          "columns": [
              { 
                "data": "name", 
                "bSortable": true
              },
              { 
                "data": "contact_no", 
                "bSortable": true
              },
              {
                "data": "address", 
                "bSortable": false
              },
              {
                "data": "latitude", 
                "bSortable": false
              },
              {
                "data": "longitude", 
                "bSortable": false
              },
              {
                "data": null, 
                "bSortable": false
              },
              {
                "data": null, 
                "bSortable": false
              }
          ],
          "rowCallback":function(nRow,aData,iDisplayindex){
              if(iDisplayindex==0 && data.length > 0){
                  data = [];
              }
              data.push(aData);
              userid = 1;
              base_url = "<?php echo base_url(); ?>"+aData.image_url;
              $('td:eq(5)',nRow).html(""
                  +"<img style='height:50px; widht:50px;' src='"+base_url+"'/>"
              +"");
              if(aData.is_active==1){
                  // if(aData.id==userid){
                  //     $('td:eq(5)',nRow).html(""
                  //         +"<button class='btn btn-info' onclick='return EditTheRow("+iDisplayindex+","+aData.id+");'>"
                  //         +"<i class='fa fa-edit'></i>"
                  //         +"</button>"
                  //         +"<button class='btn btn-danger' disabled>"
                  //         +"<i class='fa fa-trash-o'></i>"
                  //         +"</button>"
                  //     +"");
                  // }
                  // else{
                      $('td:eq(6)',nRow).html(""
                          +"<button class='btn btn-info' onclick='return EditTheRow("+iDisplayindex+","+aData.id+");'>"
                          +"<i class='fa fa-edit'></i>"
                          +"</button>"
                          +"<button class='btn btn-danger' onclick='return DeleteTheRow("+iDisplayindex+","+aData.id+");'>"
                          +"<i class='fa fa-trash-o'></i>"
                          +"</button>"
                      +"");
                  // }

              }else{
                  $(nRow).addClass('danger');
                  $('td:eq(6)',nRow).html(""
                      +"<button class='btn btn-info' disabled onclick='return EditTheRow("+iDisplayindex+","+aData.id+");'>"
                      +"<i class='fa fa-edit'></i>"
                      +"</button>"
                      +"<button class='btn btn-success' onclick='return RecoverTheRow("+iDisplayindex+","+aData.id+");'>"
                      +"<i class='fa fa-check'></i>"
                      +"</button>"
                  +"");
              }
          },
        });
    });
    function DeleteTheRow(index,id){
      $("#deleteNurseryModal").modal("show");
      $("#deleteNurseryModal").find("[name=id]").attr("value",id);
    }
    function RecoverTheRow(index,id){
      $("#recoverNurseryModal").modal("show");
      $("#recoverNurseryModal").find("[name=id]").attr("value",id);
    }
    function EditTheRow(index,aid){
      $("#editNurseryModal").modal("show");
      $("#editNurseryModal").find("[name=name]").attr("value",data[index].name);
      $("#editNurseryModal").find("[name=contact_no]").attr("value",data[index].contact_no);
      $("#editNurseryModal").find("[name=address]").attr("value",data[index].address);
      $("#editNurseryModal").find("[name=longitude]").attr("value",data[index].longitude);
      $("#editNurseryModal").find("[name=latitude]").attr("value",data[index].latitude);
      base_url = "<?php echo base_url(); ?>"+data[index].image_url;
      $("#editNurseryModal").find("[name=eimage]").attr("src",base_url);
      id = aid;
    }
    function AddTheRow(){
      $("#addNurseryModal").modal("show");
    }
    function BulkUpload(){
      $("#bulkNurseryModal").modal("show");
    }
    $(".deleteNursery").on("click",function(){
        $(".deleteNursery").prop("disabled",true);
        var id=-1;
        id=$("#deleteNurseryModal").find("[name=id]").val();
        $.post("<?php echo site_url('nursery/delete/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.code==1){
                table.ajax.reload();
            }
            $("#deleteNurseryModal").modal("hide");
        });
        $(".deleteNursery").prop("disabled",false);
    });
    $(".recoverNursery").on("click",function(){
        $(".recoverNursery").prop("disabled",true);
        var id=-1;
        id=$("#recoverNurseryModal").find("[name=id]").val();
        $.post("<?php echo site_url('nursery/recover/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.code==1){
                table.ajax.reload();
            }
            $("#recoverNurseryModal").modal("hide");
        });
        $(".recoverNursery").prop("disabled",false);
    });
    $("#addNursery").validate({
      rules: {
        name: {
          required: true
        },
        contact_no: {
          required: true,
          digits: true,
          minlength: 10,
          maxlength: 10
        },
        latitude: {
          required: true,
          digits: true
        },
        longitude: {
          required: true,
          digits: true
        },
        address: {
          required: true,
          email: true
        },
        image: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitAddForm(form);
      }
    });
    $("#editNursery").validate({
      rules: {
        name: {
          required: true
        },
        contact_no: {
          required: true,
          digits: true,
          minlength: 10,
          maxlength: 10
        },
        address: {
          required: true,
          email: true
        },
        latitude: {
          required: true,
          digits: true
        },
        longitude: {
          required: true,
          digits: true
        },
        image: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitEditForm(form);
      }
    });
    $("#addBulkNursery").validate({
      rules: {
        excelFile: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitBulkForm(form);
      }
    });
    function submitAddForm(form) {
        var formData = new FormData(form);
        $.ajax({
            url: "<?php echo site_url('nursery/add'); ?>",
            type: 'POST',
            data: formData,
            success: function (data) {
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#addNurseryModal").modal("hide");
                  table.ajax.reload();
              }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    function submitEditForm(form) {
        var formData = new FormData(form);
        $.ajax({
            url: "<?php echo site_url('nursery/edit/');?>"+id,
            type: 'POST',
            data: formData,
            success: function (data) {
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#editNurseryModal").modal("hide");
                  table.ajax.reload();
              }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    function submitBulkForm(form) {
        var formData = new FormData(form);
        $.ajax({
            url: "<?php echo site_url('nursery/import');?>",
            type: 'POST',
            data: formData,
            success: function (data) {
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#bulkNurseryModal").modal("hide");
                  table.ajax.reload();
              }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    </script>
<?php $this->load->view('include/page_footer.php'); ?>