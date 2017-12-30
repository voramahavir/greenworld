<?php $this->load->view('include/template/common_header') ?>
<style type="text/css">

</style>
<link rel="stylesheet"
      href="<?php echo base_url('assets/theme/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>">
      <!-- Main row -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> Users </h3>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper">
                  <div class="row form-group">
                    <div class="col-md-12">
                      <a href="<?php echo site_url('users/addUser'); ?>" class="btn btn-info">
                        <span class="glyphicon glyphicon-plus"></span> Add New User
                      </a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-hover dataTable" id="table_users">
                        <thead>
                          <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone No</th>
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
      <!-- DeleteModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="deleteUserModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to delete the User ? </h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger deleteUser">Delete</button>
              </div>
            </div>
          </div>
      </div>
      <!-- End DeleteModal -->
      <!-- RecoverModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="recoverUserModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to recover the User ?</h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success recoverUser">Recover</button>
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
      $(document).ready(function(){
        table = $('#table_users').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "responsive": true,
          "autoWidth": false,
          "pageLength": 10,
          "ajax": {
            "url": "<?php echo site_url('users/get'); ?>",
            "type": "POST"
          },
          "columns": [
              { 
                "data": "first_name", 
                "bSortable": true
              },
              { 
                "data": "last_name", 
                "bSortable": true
              },
              {
                "data": "user_name", 
                "bSortable": true
              },
              {
                "data": "email", 
                "bSortable": true
              },
              {
                "data": "phone_no", 
                "bSortable": true
              },
              {
                "data":null,
                'bSortable': false
              } ,             
              { 
                "data": null,
                "bSortable": false
              }
          ],
          "rowCallback":function(nRow,aData,iDisplayindex){
              userid = 1;
              if(aData.profile_pic) {
                base_url = "<?php echo base_url(); ?>"+aData.profile_pic;
              } else {
                base_url = "<?php echo base_url('assets/no-image.jpg'); ?>";
              }
              $('td:eq(5)',nRow).html(""
                  +"<img style='height:50px; widht:50px;' src='"+base_url+"'/>"
              +"");
              if(aData.is_active==1){
                  // if(aData.user_id==userid){
                  //     $('td:eq(5)',nRow).html(""
                  //         +"<button class='btn btn-info' onclick='return EditTheRow("+iDisplayindex+","+aData.user_id+");'>"
                  //         +"<i class='fa fa-edit'></i>"
                  //         +"</button>"
                  //         +"<button class='btn btn-danger' disabled>"
                  //         +"<i class='fa fa-trash-o'></i>"
                  //         +"</button>"
                  //     +"");
                  // }
                  // else{
                      $('td:eq(6)',nRow).html(""
                          +"<button class='btn btn-info' onclick='return EditTheRow("+iDisplayindex+","+aData.user_id+");'>"
                          +"<i class='fa fa-edit'></i>"
                          +"</button>"
                          +"<button class='btn btn-danger' onclick='return DeleteTheRow("+iDisplayindex+","+aData.user_id+");'>"
                          +"<i class='fa fa-trash-o'></i>"
                          +"</button>"
                      +"");
                  // }

              }else{
                  $(nRow).addClass('danger');
                  $('td:eq(6)',nRow).html(""
                      +"<button class='btn btn-info' disabled onclick='return EditTheRow("+iDisplayindex+","+aData.user_id+");'>"
                      +"<i class='fa fa-edit'></i>"
                      +"</button>"
                      +"<button class='btn btn-success' onclick='return RecoverTheRow("+iDisplayindex+","+aData.user_id+");'>"
                      +"<i class='fa fa-check'></i>"
                      +"</button>"
                  +"");
              }
          },
        });
    });
    function DeleteTheRow(index,id){
      $("#deleteUserModal").modal("show");
      $("#deleteUserModal").find("[name=id]").attr("value",id);
    }
    function RecoverTheRow(index,id){
      $("#recoverUserModal").modal("show");
      $("#recoverUserModal").find("[name=id]").attr("value",id);
    }
    function EditTheRow(index,id){
      window.location.href = "<?php echo site_url('users/editUser/'); ?>"+id;
    }
    $(".deleteUser").on("click",function(){
        $(".deleteUser").prop("disabled",true);
        var id=-1;
        id=$("#deleteUserModal").find("[name=id]").val();
        $.post("<?php echo site_url('users/delete/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.success==true){
                table.ajax.reload();
            }
            $("#deleteUserModal").modal("hide");
        });
        $(".deleteUser").prop("disabled",false);
    });
    $(".recoverUser").on("click",function(){
        $(".recoverUser").prop("disabled",true);
        var id=-1;
        id=$("#recoverUserModal").find("[name=id]").val();
        $.post("<?php echo site_url('users/recover/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.success==true){
                table.ajax.reload();
            }
            $("#recoverUserModal").modal("hide");
        });
        $(".recoverUser").prop("disabled",false);
    });
    </script>
<?php $this->load->view('include/page_footer.php'); ?>
