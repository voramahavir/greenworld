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
              <h3 class="box-title"> Bills </h3>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper">
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-hover dataTable" id="table_bills">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Amount</th>
                            <th>Nursery Name</th>
                            <th>Status</th>
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
      <!-- UpdateModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="fullImageModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content overlay-wrapper">
              <form id="editNursery" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-offset-2 col-md-9">
                          <div class="row form-group">
                              <div class=" col-md-8">
                                  <img style='height:300px; width:350px;' name='image' />
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-offset-2 col-md-2"> Amount : </label>
                        <div class="col-md-5">
                            <p class="amount" name='amount'>0</p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-offset-2 col-md-2"> Nursery : </label>
                        <div class="col-md-5">
                            <select class="form-control select nurname" name='nurname'>
                                <option value="0">Select Nursery</option>
                            </select>
                        </div>
                    </div>
                <input type="hidden" name="id" value="">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger margin-0" name="confirm" onclick="message()">Cancel</button>
                  <button type="button" class="btn btn-success" name="cancel" onclick="ajaxCall(2)">Confirm</button>
                </div>
              </form>
              <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
              </div>
            </div>
          </div>
      </div>
      <!-- End UpdateModal -->
      <!-- MessageModel -->
      <div class="modal fade modal-3d-flip-horizontal" id="messageModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                    <div class="row form-group">
                        <label class="col-md-3 text-right"> Message : </label>
                        <div class="col-md-9">
                            <select class="form-control select message" name='message'>
                                <option value="0">Select Message</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group customMessage">
                        <label class="col-md-3 text-right"> Write Message : </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control custom" name="custom">
                        </div>
                    </div>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger margin-0" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success" onclick="sendMessage()">Yes</button>
              </div>
            </div>
          </div>
      </div>
      <!-- End MessageModel -->
<?php $this->load->view('include/template/common_footer'); ?>
<!-- Bootstrap-notify -->
<script src="<?php echo base_url('assets/theme/bower_components/datatables.net/js/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/theme/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
    <script type="text/javascript">
      var table = null;
      var data = [];
      var nurserys =[];
      var messages = [];
      var id=0;
      var status = 0;
      var messageId = 0;
      $(document).ready(function(){
        getNursery();
        getMessages();
        table = $('#table_bills').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "scrollX": true,
          "ordering": true,
          "responsive": true,
          "autoWidth": false,
          "pageLength": 10,
          "ajax": {
            "url": "<?php echo site_url('bills/get'); ?>",
            "type": "POST"
          },
          "columns": [
              { 
                "data": "user_fullname", 
                "bSortable": true
              },
              { 
                "data": null, 
                "bSortable": true
              },
              {
                "data": "amount", 
                "bSortable": false
              },
              {
                "data": "nurname", 
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
              $('td:eq(1)',nRow).html(""
                  +"<img style='height:50px; widht:50px;' src='"+base_url+"' onclick='return fullImage("+iDisplayindex+","+aData.id+");'>"
              +"");
              if(aData.is_confirm==1){
                  $('td:eq(4)',nRow).html("Cancelled");
                  $('td:eq(5)',nRow).html(""
                      +"<button class='btn btn-success' onclick='return fullImage("+iDisplayindex+","+aData.id+",2);'>"
                      +"<i class='fa fa-check'></i>"
                      +"</button>"
                      +"<button class='btn btn-danger' disabled onclick='return fullImage("+iDisplayindex+","+aData.id+",1);'>"
                      +"<i class='fa fa-close'></i>"
                      +"</button>"
                  +"");
              } else if (aData.is_confirm==2){
                  $('td:eq(4)',nRow).html("Confirmed");
                  $('td:eq(5)',nRow).html(""
                      +"<button class='btn btn-success' disabled onclick='return fullImage("+iDisplayindex+","+aData.id+",2);'>"
                      +"<i class='fa fa-check'></i>"
                      +"</button>"
                      +"<button class='btn btn-danger' onclick='return fullImage("+iDisplayindex+","+aData.id+",1);'>"
                      +"<i class='fa fa-close'></i>"
                      +"</button>"
                  +"");
              }else{
                  $('td:eq(4)',nRow).html("Pending");
                  $('td:eq(5)',nRow).html(""
                      +"<button class='btn btn-success' onclick='return fullImage("+iDisplayindex+","+aData.id+",2);'>"
                      +"<i class='fa fa-check'></i>"
                      +"</button>"
                      +"<button class='btn btn-danger' onclick='return fullImage("+iDisplayindex+","+aData.id+",1);'>"
                      +"<i class='fa fa-close'></i>"
                      +"</button>"
                  +"");
              }
          },
        });
    });
    function fullImage(index,aid,stat) {
      id = aid;
      status = stat;
      if(data[index].image_url) {
        base_url = "<?php echo base_url(); ?>"+data[index].image_url;
      } else {
        base_url = "<?php echo base_url('assets/no-image.jpg'); ?>";
      }
      $("#fullImageModal").modal("show");
      $("#fullImageModal").find("[name=id]").attr("value",aid);
      $("#fullImageModal").find("[name=image]").attr("src",base_url);
      categoryHtml = '';
      categoryHtml='<option value>Select Nursery</option>';
      $.each(nurserys,function(i,e){
          if(e.is_active == 1){
            categoryHtml+='<option value="'+e.name+'">'+e.name+'</option>';
          }
      });
      $("#fullImageModal").find("[name=nurname]").html(categoryHtml);
      $("#fullImageModal").find("[name=nurname]").val(data[index].nurname);
      $("#fullImageModal").find("[name=amount]").html(data[index].amount);
    }
    function message(){
      $("#messageModal").modal("show");
      $(".customMessage").hide();
      messageHtml = '';
      messageHtml = '<option value="">Select Message</option>';
      messageHtml += '<option value="0">Custom Message</option>';
      $.each(messages,function(i,e){
          messageHtml +='<option value="'+e.message_id+'">'+e.message+'</option>';
      });
      $("#messageModal").find("[name=message]").html(messageHtml);
      $("#messageModal").find("[name=message]").on('change', function () {
          if(this.value == 0 && this.value != ''){
              $(".customMessage").show();
          } else {
              $(".customMessage").hide();
              customMessage = $("#messageModal").find("[name=message]").find("option:selected").text();
          }
          messageId = this.value;
      });
    }
    function ajaxCall(status) {
      nurname = $("#fullImageModal").find("[name=nurname]").val();
      $.post("<?php echo site_url('bills/confirm/'); ?>"+id,{
          is_confirm : status,
          nurname : nurname
      })
      .done(function(result){
          result=JSON.parse(result);
          if(result.success==true){
              table.ajax.reload();
          }
          $("#fullImageModal").modal("hide");
      });
    }
    function getNursery() {
        $.ajax({
            url: "<?php echo site_url('nursery/get'); ?>",
            type: 'POST',
            success: function (data) {
              data = JSON.parse(data);
              nurserys = data.data;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    function getMessages() {
        $.ajax({
            url: "<?php echo site_url('bills/getMessages'); ?>",
            type: 'POST',
            success: function (data) {
              data = JSON.parse(data);
              messages = data.data;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    function sendMessage(){
        if(messageId == ''){
            alert('Please select any message to send.');
            return false;
        } else if(messageId == '0'){
            customMessage = $("#messageModal").find("[name=custom]").val()
            if(customMessage == ''){
                alert('Message cannot be blank.');
                return false;
            }
        }
        var data = {
          messageId : messageId,
          message : customMessage
        };
        $.post("<?php echo site_url('bills/sendMessage/'); ?>"+id,data)
        .done(function(result){
            data = JSON.parse(result);
            alert(data.msg);
            if(data.success){
                $("#messageModal").modal("hide");
                ajaxCall(1);
            }
        });
    }
    </script>
<?php $this->load->view('include/page_footer.php'); ?>