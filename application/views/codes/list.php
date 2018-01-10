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
              <h3 class="box-title"> Codes </h3>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper">
                  <div class="row form-group">
                    <div class="col-md-12">
                      <button type="button" onclick="AddTheRow()" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                        <span class="glyphicon glyphicon-plus"></span> Add New Code
                      </button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-hover dataTable" id="table_codes">
                        <thead>
                          <tr>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Reusability</th>
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
      <div class="modal fade modal-3d-flip-horizontal" id="addCodeModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="addCode" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Add Code</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Code : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control code" name="code">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Type : </label>
                              <div class="col-md-9">
                                  <select class="form-control select type" name='type'>
                                      <option value="">Select Type</option>
                                      <option value="1">Amount</option>
                                      <option value="2">Percentage</option>
                                      <option value="3">Gift</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Discount  : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control discount" name="discount">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Reusability : </label>
                              <div class="col-md-9">
                                  <select class="form-control select reusability" name='reusability'>
                                      <option value="">Select Reusability</option>
                                      <option value="1">One Time</option>
                                      <option value="2">More than one time</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger margin-0" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-default addCode">Add</button>
                </div>
            </form>
            </div>
          </div>
      </div>
      <!-- End AddModal -->
      <!-- UpdateModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="editCodeModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="editCode" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Edit Code</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Name : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control code" name="code">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Type : </label>
                              <div class="col-md-9">
                                  <select class="form-control select type" name='type'>
                                      <option value="">Select Type</option>
                                      <option value="1">Amount</option>
                                      <option value="2">Percentage</option>
                                      <option value="3">Gift</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Discount  : </label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control discount" name="discount">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Reusability : </label>
                              <div class="col-md-9">
                                  <select class="form-control select reusability" name='reusability'>
                                      <option value="">Select Reusability</option>
                                      <option value="1">One Time</option>
                                      <option value="2">More than one time</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger margin-0" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-default editCode">Update</button>
                </div>
            </form>
            </div>
          </div>
      </div>
      <!-- End UpdateModal -->
      <!-- DeleteModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="deleteCodeModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to delete the Code ? </h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger deleteCode">Delete</button>
              </div>
            </div>
          </div>
      </div>
      <!-- End DeleteModal -->
      <!-- RecoverModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="recoverCodeModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to recover the Code ?</h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success recoverCode">Recover</button>
              </div>
            </div>
          </div>
      </div>
      <!-- End RecoverModal -->
<?php $this->load->view('include/template/common_footer'); ?>
<!-- Bootstrap-notify -->
<script src="<?php echo base_url('assets/theme/bower_components/datatables.net/js/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/theme/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
    <script type="text/javascript">
      var table = null;
      var data = [];
      var id=0;
      $(document).ready(function(){
        table = $('#table_codes').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "responsive": true,
          "autoWidth": false,
          "pageLength": 10,
          "ajax": {
            "url": "<?php echo site_url('codes/get'); ?>",
            "type": "POST"
          },
          "columns": [
              { 
                "data": "code", 
                "bSortable": true
              },
              { 
                "data": "type", 
                "bSortable": true
              },
              {
                "data": "discount", 
                "bSortable": false
              },
              {
                "data": "reusability", 
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
              if(aData.type == "1") {
                $('td:eq(1)',nRow).html("Amount");
              } else if(aData.type == "2") {
                $('td:eq(1)',nRow).html("Discount");
              } else {
                $('td:eq(1)',nRow).html("Gift");
              }
              if(aData.reusability == "1") {
                $('td:eq(3)',nRow).html("One Time");
              } else {
                $('td:eq(3)',nRow).html("More than one time");
              }
              if(aData.is_active==1){
                  $('td:eq(4)',nRow).html(""
                      +"<button class='btn btn-info' onclick='return EditTheRow("+iDisplayindex+","+aData.id+");'>"
                      +"<i class='fa fa-edit'></i>"
                      +"</button>"
                      +"<button class='btn btn-danger' onclick='return DeleteTheRow("+iDisplayindex+","+aData.id+");'>"
                      +"<i class='fa fa-trash-o'></i>"
                      +"</button>"
                  +"");
              }else{
                  $(nRow).addClass('danger');
                  $('td:eq(4)',nRow).html(""
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
      $("#deleteCodeModal").modal("show");
      $("#deleteCodeModal").find("[name=id]").attr("value",id);
    }
    function RecoverTheRow(index,id){
      $("#recoverCodeModal").modal("show");
      $("#recoverCodeModal").find("[name=id]").attr("value",id);
    }
    function EditTheRow(index,aid){
      id = aid;
      $("#editCodeModal").modal("show");
      $("#editCodeModal").find("[name=code]").attr("value",data[index].code);
      $("#editCodeModal").find("[name=type]").val(data[index].type);
      $("#editCodeModal").find("[name=discount]").attr("value",data[index].discount);
      $("#editCodeModal").find("[name=reusability]").val(data[index].reusability);
    }
    function AddTheRow(){
      $("#addCodeModal").modal("show");
      $("#addCodeModal").find("[name=code]").attr("value","");
      $("#addCodeModal").find("[name=type]").val("0");
      $("#addCodeModal").find("[name=discount]").attr("value","");
      $("#addCodeModal").find("[name=reusability]").attr("value","");
    }
    $(".deleteCode").on("click",function(){
        $(".deleteCode").prop("disabled",true);
        var id=-1;
        id=$("#deleteCodeModal").find("[name=id]").val();
        $.post("<?php echo site_url('codes/delete/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.success==true){
                table.ajax.reload();
            }
            $("#deleteCodeModal").modal("hide");
        });
        $(".deleteCode").prop("disabled",false);
    });
    $(".recoverCode").on("click",function(){
        $(".recoverCode").prop("disabled",true);
        var id=-1;
        id=$("#recoverCodeModal").find("[name=id]").val();
        $.post("<?php echo site_url('codes/recover/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.success==true){
                table.ajax.reload();
            }
            $("#recoverCodeModal").modal("hide");
        });
        $(".recoverCode").prop("disabled",false);
    });
    $("#addCode").validate({
      rules: {
        code: {
          required: true
        },
        type: {
          required: true
        },
        discount: {
          required: true
        },
        reusability: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitAddForm(form);
      }
    });
    $("#editCode").validate({
      rules: {
        code: {
          required: true
        },
        type: {
          required: true
        },
        discount: {
          required: true
        },
        reusability: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitEditForm(form);
      }
    });
    function submitAddForm(form) {
       var formData = new FormData(form);
        $.ajax({
            url: "<?php echo site_url('codes/add'); ?>",
            type: 'POST',
            data: formData,
            success: function (data) {
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#addCodeModal").modal("hide");
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
            url: "<?php echo site_url('codes/update/');?>"+id,
            type: 'POST',
            data: formData,
            success: function (data) {
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#editCodeModal").modal("hide");
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
