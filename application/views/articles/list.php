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
              <h3 class="box-title"> Articles </h3>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper">
                  <div class="row form-group">
                    <div class="col-md-12">
                      <button type="button" onclick="AddTheRow()" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                        <span class="glyphicon glyphicon-plus"></span> Add New Article
                      </button>
                      <button type="button" onclick="BulkUpload()" class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-default">
                        <span class="glyphicon glyphicon-file"></span> Import File
                      </button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-hover dataTable" id="table_articles">
                        <thead>
                          <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Source</th>
                            <th>URL</th>
                            <th>Submitted By</th>
                            <th>Designation</th>
                            <th>Video URL</th>
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
          <div class="overlay">
               <i class="fa fa-refresh fa-spin"></i>
          </div>
          </div>
        </div>
      </div>
      <!-- AddModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="addArticleModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content overlay-wrapper">
              <form id="addArticle" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Add Article</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Title : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control title" name="title">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Description : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control description" name="description">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Source  : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control source" name="source">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> URL : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control url" name="url">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Submitted By : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control submitted_by" name="submitted_by">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Designation : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control designation" name="designation">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Image Type : </label>
                              <div class="col-md-8">
                                  <select class="form-control select image_type" name='image_type'>
                                      <option value="">Select Image Type</option>
                                      <option value="1">URL</option>
                                      <option value="2">File</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row form-group image_url_div">
                              <label class="col-md-4 text-right"> Image URL : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control image_url" name="image_url">
                              </div>
                          </div>
                          <div class="row form-group image_div">
                              <label class="col-md-4 text-right"> Image : </label>
                              <div class="col-md-8">
                                  <input id="input-b1" name="image" type="file" class="file">
                              </div>
                          </div>
                           <div class="row form-group">
                              <label class="col-md-4 text-right"> Video Type : </label>
                              <div class="col-md-8">
                                  <select class="form-control select video_type" name='video_type'>
                                      <option value="">Select Video Type</option>
                                      <option value="1">URL</option>
                                      <option value="2">File</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row form-group video_url_div">
                              <label class="col-md-4 text-right"> Video URL : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control video_url" name="video_url">
                              </div>
                          </div>
                          <div class="row form-group video_div">
                              <label class="col-md-4 text-right"> Video : </label>
                              <div class="col-md-8">
                                  <input id="input-b1" name="video" type="file" class="file">
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger margin-0" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-default addArticle">Add</button>
                </div>
              </form>
              <div class="overlay">
               <i class="fa fa-refresh fa-spin"></i>
              </div>
            </div>
          </div>
      </div>
      <!-- End AddModal -->
      <!-- UpdateModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="editArticleModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content overlay-wrapper">
              <form id="editArticle" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Edit Article</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Title : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control title" name="title">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Description : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control description" name="description">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Source  : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control source" name="source">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> URL : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control url" name="url">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Submitted By : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control submitted_by" name="submitted_by">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Designation : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control designation" name="designation">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Image Type : </label>
                              <div class="col-md-8">
                                  <select class="form-control select image_type" name='image_type'>
                                      <option value="">Select Image Type</option>
                                      <option value="1">URL</option>
                                      <option value="2">File</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row form-group image_url_div">
                              <label class="col-md-4 text-right"> Image URL : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control image_url" name="image_url">
                              </div>
                          </div>
                          <div class="row form-group image_div">
                              <label class="col-md-4 text-right"> Image : </label>
                              <div class="col-md-8">
                                  <input id="input-b1" name="image" type="file" class="file">
                              </div>
                          </div>
                           <div class="row form-group">
                              <label class="col-md-4 text-right"> Video Type : </label>
                              <div class="col-md-8">
                                  <select class="form-control select video_type" name='video_type'>
                                      <option value="">Select Video Type</option>
                                      <option value="1">URL</option>
                                      <option value="2">File</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row form-group video_url_div">
                              <label class="col-md-4 text-right"> Video URL : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control video_url" name="video_url">
                              </div>
                          </div>
                          <div class="row form-group video_div">
                              <label class="col-md-4 text-right"> Video : </label>
                              <div class="col-md-8">
                                  <input id="input-b1" name="video" type="file" class="file">
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger margin-0" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-default editArticle">Update</button>
                </div>
              </form>
              <div class="overlay">
               <i class="fa fa-refresh fa-spin"></i>
              </div>
            </div>
          </div>
      </div>
      <!-- End UpdateModal -->
      <!-- DeleteModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="deleteArticleModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to delete the Article ? </h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger deleteArticle">Delete</button>
              </div>
            </div>
          </div>
      </div>
      <!-- End DeleteModal -->
      <!-- RecoverModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="recoverArticleModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to recover the Article ?</h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success recoverArticle">Recover</button>
              </div>
            </div>
          </div>
      </div>
      <!-- End RecoverModal -->
      <!-- BulkUploadModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="bulkArticleModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content overlay-wrapper">
              <form id="addBulkArticle" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Add Article</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Download : </label>
                              <div class="col-md-9">
                                <a href="<?php echo base_url('assets/excels/ArticleExampleFormat.xlsx'); ?>" class="btn btn-info">
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
                  <button type="submit" class="btn btn-default editArticle">Upload</button>
                </div>
              </form>
              <div class="overlay">
               <i class="fa fa-refresh fa-spin"></i>
              </div>
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
      var selectedIndex = -1;
      var id=0;
      $(document).ready(function(){
        $('body').addClass('sidebar-collapse');
        table = $('#table_articles').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "scrollX": true,
          "ordering": true,
          "responsive": true,
          "autoWidth": false,
          "pageLength": 10,
          "ajax": {
            "url": "<?php echo site_url('articles/get'); ?>",
            "type": "POST"
          },
          "columns": [
              { 
                "data": "title", 
                "bSortable": true
              },
              { 
                "data": "description", 
                "bSortable": true
              },
              { 
                "data": "source", 
                "bSortable": true
              },
              { 
                "data": null, 
                "bSortable": true
              },
              { 
                "data": "submitted_by", 
                "bSortable": true
              },
              { 
                "data": "designation", 
                "bSortable": true
              },
              { 
                "data": null, 
                "bSortable": true
              },
              { 
                "data": null, 
                "bSortable": true
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
                if(aData.image_type == 1){
                  base_url = "<?php echo base_url(); ?>"+aData.image_url;
                }else{
                  base_url = aData.image_url;
                }
              } else {
                base_url = "<?php echo base_url('assets/no-image.jpg'); ?>";
              }
              $('td:eq(7)',nRow).html(""
                  +"<img style='height:50px; widht:50px;' src='"+base_url+"'/>"
              +"");
              if(aData.video_url) {
                if(aData.video_type == 1){
                  base_url = "<?php echo base_url(); ?>"+aData.video_url;
                }else{
                  base_url = aData.video_url;
                }
              } else {
                base_url = "<?php echo base_url('assets/no-image.jpg'); ?>";
              }
              $('td:eq(6)',nRow).html(""
                  +"<a href='"+base_url+"'/>"
              +"");
              $('td:eq(3)',nRow).html(""
                  +"<a href='"+aData.url+"'/>"
              +"");
              if(aData.is_active==1){
                  $('td:eq(8)',nRow).html(""
                      +"<button class='btn btn-info' onclick='return EditTheRow("+iDisplayindex+","+aData.id+");'>"
                      +"<i class='fa fa-edit'></i>"
                      +"</button>"
                      +"<button class='btn btn-danger' onclick='return DeleteTheRow("+iDisplayindex+","+aData.id+");'>"
                      +"<i class='fa fa-trash-o'></i>"
                      +"</button>"
                  +"");
              }else{
                  $(nRow).addClass('danger');
                  $('td:eq(8)',nRow).html(""
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
      $("#deleteArticleModal").modal("show");
      $("#deleteArticleModal").find("[name=id]").attr("value",id);
    }
    function RecoverTheRow(index,id){
      $("#recoverArticleModal").modal("show");
      $("#recoverArticleModal").find("[name=id]").attr("value",id);
    }
    function EditTheRow(index,aid){
      selectedIndex = index;
      $("#editArticleModal").modal("show");
      $("#editArticleModal").find("[name=title]").attr("value",data[index].title);
      $("#editArticleModal").find("[name=description]").attr("value",data[index].description);
      $("#editArticleModal").find("[name=url]").attr("value",data[index].url);
      $("#editArticleModal").find("[name=source]").attr("value",data[index].source);
      $("#editArticleModal").find("[name=submitted_by]").attr("value",data[index].submitted_by);
      $("#editArticleModal").find("[name=image_type]").val(data[index].image_type);
      $("#editArticleModal").find("[name=video_type]").val(data[index].video_type);

      if(data[index].image_type == 1){
        $('.image_url_div').show();
        $('.image_div').hide();
      } else if(data[index].image_type  == 2){
        $('.image_url_div').hide();
        $('.image_div').show();
      } else {
        $('.image_url_div').hide();
        $('.image_div').hide();
      }

      if(data[index].video_type == 1){
        $('.video_url_div').show();
        $('.video_div').hide();
      } else if(data[index].video_type == 2){
        $('.video_url_div').hide();
        $('.video_div').show();
      } else {
        $('.video_url_div').hide();
        $('.video_div').hide();
      }

      $(".image_type").on('change', function () {
        if(this.value == 1){
          $('.image_url_div').show();
          $('.image_div').hide();
        } else if(this.value == 2){
          $('.image_url_div').hide();
          $('.image_div').show();
        } else {
          $('.image_url_div').hide();
          $('.image_div').hide();
        }
      });

      $(".video_type").on('change', function () {
        if(this.value == 1){
          $('.video_url_div').show();
          $('.video_div').hide();
        } else if(this.value == 2){
          $('.video_url_div').hide();
          $('.video_div').show();
        } else {
          $('.video_url_div').hide();
          $('.video_div').hide();
        }
      });
    }

    function AddTheRow(){
      $("#addArticleModal").modal("show");
      $('.image_url_div').hide();
      $('.image_div').hide();
      $('.video_url_div').hide();
      $('.video_div').hide();
      $(".image_type").on('change', function () {
        if(this.value == 1){
          $('.image_url_div').show();
          $('.image_div').hide();
        } else if(this.value == 2){
          $('.image_url_div').hide();
          $('.image_div').show();
        } else {
          $('.image_url_div').hide();
          $('.image_div').hide();
        }
      });
      $(".video_type").on('change', function () {
        if(this.value == 1){
          $('.video_url_div').show();
          $('.video_div').hide();
        } else if(this.value == 2){
          $('.video_url_div').hide();
          $('.video_div').show();
        } else {
          $('.video_url_div').hide();
          $('.video_div').hide();
        }
      });
    }

    function BulkUpload(){
      $("#bulkArticleModal").modal("show");
    }

    $(".deleteArticle").on("click",function(){
        $(".deleteArticle").prop("disabled",true);
        var id=-1;
        id=$("#deleteArticleModal").find("[name=id]").val();
        $.post("<?php echo site_url('articles/delete/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.success==true){
                table.ajax.reload();
            }
            $("#deleteArticleModal").modal("hide");
        });
        $(".deleteArticle").prop("disabled",false);
    });

    $(".recoverArticle").on("click",function(){
        $(".recoverArticle").prop("disabled",true);
        var id=-1;
        id=$("#recoverArticleModal").find("[name=id]").val();
        $.post("<?php echo site_url('articles/recover/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.success==true){
                table.ajax.reload();
            }
            $("#recoverArticleModal").modal("hide");
        });
        $(".recoverArticle").prop("disabled",false);
    });
    $("#addArticle").validate({
      rules: {
        title: {
          required: true
        },
        description: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitAddForm(form);
      }
    });
    $("#editArticle").validate({
      rules: {
        title: {
          required: true
        },
        description: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitEditForm(form);
      }
    });
    $("#addBulkArticle").validate({
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
       loadingStart();
       var formData = new FormData(form);
        $.ajax({
            url: "<?php echo site_url('articles/add'); ?>",
            type: 'POST',
            data: formData,
            success: function (data) {
              loadingStop();
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#addArticleModal").modal("hide");
                  table.ajax.reload();
              }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    function submitEditForm(form) {
      loadingStart();
      var formData = new FormData(form);
        $.ajax({
            url: "<?php echo site_url('articles/update/');?>"+data[selectedIndex].id,
            type: 'POST',
            data: formData,
            success: function (data) {
              loadingStop();
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#editArticleModal").modal("hide");
                  table.ajax.reload();
              }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    function submitBulkForm(form) {
        loadingStart();
        var formData = new FormData(form);
        $.ajax({
            url: "<?php echo site_url('articles/import');?>",
            type: 'POST',
            data: formData,
            success: function (data) {
              loadingStop();
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#bulkArticleModal").modal("hide");
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
