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
              <h3 class="box-title"> Plants </h3>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper">
                  <div class="row form-group">
                    <div class="col-md-12">
                      <button type="button" onclick="AddTheRow()" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                        <span class="glyphicon glyphicon-plus"></span> Add New Plant
                      </button><a href="<?php echo site_url('plantbanners/list'); ?>">
                      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                         Banners
                      </button></a>
                      <button type="button" onclick="BulkUpload()" class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-default">
                        <span class="glyphicon glyphicon-file"></span> Import File
                      </button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-hover dataTable" id="table_plant">
                        <thead>
                          <tr>
                            <th>Local Name</th>
                            <th>English Name</th>
                            <th>Botanical Name</th>
                            <th>Habit</th>
                            <th>Family</th>
                            <th>Watering</th>
                            <th>Location</th>
                            <th>Use</th>
                            <th>Extra Comment</th>
                            <th>Category</th>
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
      <div class="modal fade modal-3d-flip-horizontal" id="addPlantModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content overlay-wrapper">
              <form id="addPlant" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Add Plant</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Local Name : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control local_name" name="local_name">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Category : </label>
                              <div class="col-md-8">
                                  <select class="form-control select category_id" name='category_id'>
                                      <option value="0">Select Category</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> English Name  : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control english_name" name="english_name">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Botanical Name : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control botanical_name" name="botanical_name">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Habit : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control habit" name="habit">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Family : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control family" name="family">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Watering : </label>
                              <div class="col-md-8">
                                  <select class="form-control select watering" name='watering'>
                                      <option value="">Select Watering Type</option>
                                      <option value="High">High</option>
                                      <option value="Modrate">Modrate</option>
                                      <option value="Less">Less</option>
                                  </select>
                              </div>
                          </div>
                           <div class="row form-group">
                              <label class="col-md-4 text-right"> Location : </label>
                              <div class="col-md-8">
                                  <select class="form-control select location" name='location'>
                                      <option value="">Select Location</option>
                                      <option value="Outdoor">Outdoor</option>
                                      <option value="Indoor">Indoor</option>
                                      <option value="Indoor as well as outdoor">Indoor as well as outdoor</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Use : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control plant_use" name="plant_use">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Extra Comment : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control extra_comment" name="extra_comment">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Nursery : </label>
                              <div class="col-md-8">
                                  <select class="form-control nurserys col-md-8" name='nurserys' multiple="multiple">
                                  </select>
                              </div>
                          </div>
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
                  <button type="submit" class="btn btn-default addPlant">Add</button>
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
      <div class="modal fade modal-3d-flip-horizontal" id="editPlantModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content overlay-wrapper">
              <form id="editPlant" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Edit Plant</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Local Name : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control local_name" name="local_name">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Category : </label>
                              <div class="col-md-8">
                                  <select class="form-control select category_id" name='category_id'>
                                      <option value="0">Select Category</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> English Name  : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control english_name" name="english_name">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Botanical Name : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control botanical_name" name="botanical_name">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Habit : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control habit" name="habit">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Family : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control family" name="family">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Watering : </label>
                              <div class="col-md-8">
                                  <select class="form-control select watering" name='watering'>
                                      <option value="">Select Watering Type</option>
                                      <option value="High">High</option>
                                      <option value="Modrate">Modrate</option>
                                      <option value="Less">Less</option>
                                  </select>
                              </div>
                          </div>
                           <div class="row form-group">
                              <label class="col-md-4 text-right"> Location : </label>
                              <div class="col-md-8">
                                  <select class="form-control select location" name='location'>
                                      <option value="">Select Location</option>
                                      <option value="Outdoor">Outdoor</option>
                                      <option value="Indoor">Indoor</option>
                                      <option value="Indoor as well as outdoor">Indoor as well as outdoor</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Use : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control plant_use" name="plant_use">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Extra Comment : </label>
                              <div class="col-md-8">
                                  <input type="text" class="form-control extra_comment" name="extra_comment">
                              </div>
                          </div>
                          <div class="row form-group">
                              <label class="col-md-4 text-right"> Nursery : </label>
                              <div class="col-md-8">
                                  <select class="form-control nurserys col-md-8" name='nurserys' multiple="multiple">
                                  </select>
                              </div>
                          </div>
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
                  <button type="submit" class="btn btn-default editPlant">Update</button>
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
      <div class="modal fade modal-3d-flip-horizontal" id="deletePlantModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to delete the Plant ? </h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger deletePlant">Delete</button>
              </div>
            </div>
          </div>
      </div>
      <!-- End DeleteModal -->
      <!-- RecoverModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="recoverPlantModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you sure you want to recover the Plant ?</h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success recoverPlant">Recover</button>
              </div>
            </div>
          </div>
      </div>
      <!-- End RecoverModal -->
      <!-- BulkUploadModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="bulkPlantModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content overlay-wrapper">
              <form id="addBulkPlant" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Add Plant</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-9">
                          <div class="row form-group">
                              <label class="col-md-3 text-right"> Download : </label>
                              <div class="col-md-9">
                                <a href="<?php echo base_url('assets/excels/PlantExcelSheet.xlsx'); ?>" class="btn btn-info">
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
                  <button type="submit" class="btn btn-default editPlant">Upload</button>
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
      var nurserys = [];
      var categories =[];
      var selectedIndex = -1;
      var id=0;
      $(document).ready(function(){
        $('body').addClass('sidebar-collapse');
        $.fn.select2.defaults.set("theme", "bootstrap");
        $(".nurserys").select2({
            closeOnSelect: false,
            placeholder: 'Select Nursery'
        });
        getNursery();
        $.ajax({
            url: "<?php echo site_url('plant_category/get'); ?>",
            type: 'POST',
            success: function (data) {
              categoryHtml = '';
              data = JSON.parse(data);
              categories = data.data;
            },
            cache: false,
            contentType: false,
            processData: false
        });
        table = $('#table_plant').DataTable({
          "paging": true,
          "lengthChange": true,
          "scrollX": true,
          "searching": true,
          "ordering": true,
          "responsive": true,
          "autoWidth": false,
          "pageLength": 10,
          "ajax": {
            "url": "<?php echo site_url('plant/get'); ?>",
            "type": "POST"
          },
          "columns": [
              { 
                "data": "local_name", 
                "bSortable": true
              },
              { 
                "data": "english_name", 
                "bSortable": true
              },
              { 
                "data": "botanical_name", 
                "bSortable": true
              },
              { 
                "data": "habit", 
                "bSortable": true
              },
              { 
                "data": "family", 
                "bSortable": true
              },
              { 
                "data": "watering", 
                "bSortable": true
              },
              { 
                "data": "location", 
                "bSortable": true
              },
              { 
                "data": "plant_use", 
                "bSortable": true
              },
              { 
                "data": "extra_comment", 
                "bSortable": true
              },
              {
                "data": "category", 
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
              if(aData.image_url) {
                base_url = "<?php echo base_url(); ?>"+aData.image_url;
              } else {
                base_url = "<?php echo base_url('assets/no-image.jpg'); ?>";
              }
              $('td:eq(10)',nRow).html(""
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
                      $('td:eq(11)',nRow).html(""
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
                  $('td:eq(11)',nRow).html(""
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
      $("#deletePlantModal").modal("show");
      $("#deletePlantModal").find("[name=id]").attr("value",id);
    }
    function RecoverTheRow(index,id){
      $("#recoverPlantModal").modal("show");
      $("#recoverPlantModal").find("[name=id]").attr("value",id);
    }
    function EditTheRow(index,aid){
      selectedIndex = index;
      $("#editPlantModal").modal("show");
      $(".nurserys").select2("val", "");
      $("#editPlantModal").find("[name=local_name]").attr("value",data[index].local_name);
      $("#editPlantModal").find("[name=english_name]").attr("value",data[index].english_name);
      $("#editPlantModal").find("[name=botanical_name]").attr("value",data[index].botanical_name);
      $("#editPlantModal").find("[name=habit]").attr("value",data[index].habit);
      $("#editPlantModal").find("[name=family]").attr("value",data[index].family);
      $("#editPlantModal").find("[name=plant_use]").attr("value",data[index].plant_use);
      $("#editPlantModal").find("[name=extra_comment]").attr("value",data[index].extra_comment);
      $("#editPlantModal").find("[name=watering]").val(data[index].watering);
      $("#editPlantModal").find("[name=location]").val(data[index].location);
      if(data[index].image_url) {
        base_url = "<?php echo base_url(); ?>"+data[index].image_url;
      } else {
        base_url = "<?php echo base_url('assets/no-image.jpg'); ?>";
      }
      $("#editPlantModal").find("[name=eimage]").attr("src",base_url);
      categoryHtml = '';
      categoryHtml='<option value>Select Category</option>';
      $.each(categories,function(i,e){
          categoryHtml+='<option value="'+e.id+'">'+e.name+'</option>';
      });
      $("#editPlantModal").find("[name=category_id]").html(categoryHtml);
      $("#editPlantModal").find("[name=category_id]").val(data[index].categoryid);
      id = aid;
      $('.nurserys').html('');
      $.each(nurserys.data, function (i, item) {
        if(item.is_active == 1){
          $('.nurserys').append($('<option>', { 
              value: item.id,
              text : item.name 
          }));
        }
      });
      $(".select2").css("width", "100%");
      $(".select2-search__field").css("width", "100%");
      if(data[index].nurserys != null){
        var array = JSON.parse("[" + data[index].nurserys + "]");
        $('.nurserys').val(array).change();
      }
      $('.nurserys').on("select2:selecting", function(e) { 
          var array = $('.nurserys').val();
          var index = array.indexOf(e.params.args.data.id);
          if(index <= -1){
            array.push(e.params.args.data.id);
          }
          $('.nurserys').val('').change();
          $('.nurserys').val(array).change();
      });
      $(".nurserys").on("select2:unselecting", function(e) {
          var array = $('.nurserys').val();
          var index = array.indexOf(e.params.args.data.id);
          if(index > -1){
            array.splice(index, 1);
          }
          $('.nurserys').val('').change();
          $('.nurserys').val(array).change();
      });
    }
    function AddTheRow(){
      $("#addPlantModal").modal("show");
      $('.nurserys').html('');
      $(".nurserys").select2("val", "");
      categoryHtml = '';
      categoryHtml='<option value>Select Category</option>';
      $.each(categories,function(i,e){
          categoryHtml+='<option value="'+e.id+'">'+e.name+'</option>';
      });
      $("#addPlantModal").find("[name=category_id]").html(categoryHtml);
      $.each(nurserys.data, function (i, item) {
        if(item.is_active == 1){
          $('.nurserys').append($('<option>', { 
              value: item.id,
              text : item.name 
          }));
        }
      });
      $(".select2").css("width", "100%");
      $(".select2-search__field").css("width", "100%");
    }
    function BulkUpload(){
      $("#bulkPlantModal").modal("show");
    }
    $(".deletePlant").on("click",function(){
        $(".deletePlant").prop("disabled",true);
        var id=-1;
        id=$("#deletePlantModal").find("[name=id]").val();
        $.post("<?php echo site_url('plant/delete/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.success==true){
                table.ajax.reload();
            }
            $("#deletePlantModal").modal("hide");
        });
        $(".deletePlant").prop("disabled",false);
    });

    $(".recoverPlant").on("click",function(){
        $(".recoverPlant").prop("disabled",true);
        var id=-1;
        id=$("#recoverPlantModal").find("[name=id]").val();
        $.post("<?php echo site_url('plant/recover/'); ?>"+id,{})
        .done(function(result){
            result=JSON.parse(result);
            if(result.success==true){
                table.ajax.reload();
            }
            $("#recoverPlantModal").modal("hide");
        });
        $(".recoverPlant").prop("disabled",false);
    });
    $("#addPlant").validate({
      rules: {
        local_name: {
          required: true
        },
        category_id: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitAddForm(form);
      }
    });
    $("#editPlant").validate({
      rules: {
        name: {
          required: true
        },
        category_id: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitEditForm(form);
      }
    });
    $("#addBulkPlant").validate({
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
            url: "<?php echo site_url('plant/add?nurserys='); ?>"+$('.nurserys').val(),
            type: 'POST',
            data: formData,
            success: function (data) {
              loadingStop();
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#addPlantModal").modal("hide");
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
            url: "<?php echo site_url('plant/edit/');?>"+id+"?nurserys="+$('.nurserys').val(),
            type: 'POST',
            data: formData,
            success: function (data) {
              loadingStop();
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#editPlantModal").modal("hide");
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
            url: "<?php echo site_url('plant/import');?>",
            type: 'POST',
            data: formData,
            success: function (data) {
              loadingStop();
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                  $("#bulkPlantModal").modal("hide");
                  table.ajax.reload();
              }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    function getNursery() {
        $.ajax({
            url: "<?php echo site_url('nursery/get'); ?>",
            type: 'POST',
            success: function (data) {
              data = JSON.parse(data);
              nurserys = data;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    </script>
<?php $this->load->view('include/page_footer.php'); ?>
