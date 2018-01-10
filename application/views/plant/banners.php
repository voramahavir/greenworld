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
              <h3 class="box-title"> Plant Banners </h3>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper">
                  <div class="row form-group">
                    <div class="col-md-12">
                      <button type="button" onclick="AddTheRow()" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                        <span class="glyphicon glyphicon-plus"></span> Add New Banner
                      </button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-hover dataTable" id="table_plantbanners">
                        <thead>
                          <tr>
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
      <div class="modal fade modal-3d-flip-horizontal" id="addBannerModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="addBanner" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Add Banner</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Image : </label>
                              <div class="col-md-8">
                                  <input id="input-b1" name="image" type="file" class="file">
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger margin-0" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-default addBanner">Add</button>
                </div>
            </form>
            </div>
          </div>
      </div>
      <!-- End AddModal -->
      <!-- UpdateModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="editBannerModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="editBanner" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Edit Banner</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                           <div class="row form-group">
                              <label class="col-md-4 text-right"> Image : </label>
                              <div class="col-md-8">
                                  <input id="input-b1" name="image" type="file" class="file">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"></label>
                              <div class="col-md-8">
                                  <img style='height:50px; widht:50px;' name='eimage' />
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger margin-0" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-default editBanner">Update</button>
                </div>
            </form>
            </div>
          </div>
      </div>
      <!-- End UpdateModal -->
      <!-- DeleteModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="deleteBannerModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to delete the Banner ? </h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger deleteBanner">Delete</button>
              </div>
            </div>
          </div>
      </div>
      <!-- End DeleteModal -->
      <!-- RecoverModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="recoverBannerModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to recover the Category ?</h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success recoverBanner">Recover</button>
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
        table = $('#table_plantbanners').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": false,
          "ordering": true,
          "responsive": true,
          "autoWidth": false,
          "pageLength": 10,
          "ajax": {
            "url": "<?php echo site_url('plantbanners/get'); ?>",
            "type": "POST"
          },
          "columns": [
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
              if(aData.image_url) {
                base_url = "<?php echo base_url(); ?>"+aData.image_url;
              } else {
                base_url = "<?php echo base_url('assets/no-image.jpg'); ?>";
              }
              $('td:eq(0)',nRow).html(""
                  +"<img style='height:50px; widht:50px;' src='"+base_url+"'/>"
              +"");
              if(aData.is_active==1){
                  $('td:eq(1)',nRow).html(""
                      +"<button class='btn btn-info' onclick='return EditTheRow("+iDisplayindex+","+aData.id+");'>"
                      +"<i class='fa fa-edit'></i>"
                      +"</button>"
                      +"<button class='btn btn-danger' onclick='return DeleteTheRow("+iDisplayindex+","+aData.id+");'>"
                      +"<i class='fa fa-trash-o'></i>"
                      +"</button>"
                  +"");
              }else{
                  $(nRow).addClass('danger');
                  $('td:eq(1)',nRow).html(""
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
      $("#deleteBannerModal").modal("show");
      $("#deleteBannerModal").find("[name=id]").attr("value",id);
    }
    function RecoverTheRow(index,id){
      $("#recoverBannerModal").modal("show");
      $("#recoverBannerModal").find("[name=id]").attr("value",id);
    }
    function EditTheRow(index,aid){
      $("#editBannerModal").modal("show");
      if(data[index].image_url) {
        base_url = "<?php echo base_url(); ?>"+data[index].image_url;
      } else {
        base_url = "<?php echo base_url('assets/no-image.jpg'); ?>";
      }
      $("#editPlantModal").find("[name=eimage]").attr("src",base_url);
      id = aid;
    }
    function AddTheRow(){
      $("#addBannerModal").modal("show");
    }
    $(".deleteBanner").on("click",function(){
        $(".deleteBanner").prop("disabled",true);
        var id=-1;
        id=$("#deleteBannerModal").find("[name=id]").val();
        $.post("<?php echo site_url('plantbanners/delete/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.success==true){
                table.ajax.reload();
            }
            $("#deleteBannerModal").modal("hide");
        });
        $(".deleteBanner").prop("disabled",false);
    });
    $(".recoverBanner").on("click",function(){
        $(".recoverBanner").prop("disabled",true);
        var id=-1;
        id=$("#recoverBannerModal").find("[name=id]").val();
        $.post("<?php echo site_url('plantbanners/recover/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.success==true){
                table.ajax.reload();
            }
            $("#recoverBannerModal").modal("hide");
        });
        $(".recoverBanner").prop("disabled",false);
    });
    $("#addBanner").validate({
      rules: {
        image: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitAddForm(form);
      }
    });
    $("#editBanner").validate({
      rules: {
        image: {
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
            url: "<?php echo site_url('plantbanners/add'); ?>",
            type: 'POST',
            data: formData,
            success: function (data) {
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#addBannerModal").modal("hide");
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
            url: "<?php echo site_url('plantbanners/edit/');?>"+id,
            type: 'POST',
            data: formData,
            success: function (data) {
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#editBannerModal").modal("hide");
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
