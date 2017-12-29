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
                            <th>Status</th>
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
      <!-- RecoverModal -->
      <div class="modal fade modal-3d-flip-horizontal" id="confirmModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Do you want to confirm or cancel ?</h4>
                <input type="hidden" name="id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger margin-0" onclick="ajaxCall(1)">Cancel</button>
                <button type="button" class="btn btn-success" onclick="ajaxCall(2)">Confirm</button>
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
        table = $('#table_bills').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
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
              $('td:eq(1)',nRow).html(""
                  +"<img style='height:50px; widht:50px;' src='"+base_url+"'/>"
              +"");
              if(aData.is_confirm==1){
                  $('td:eq(3)',nRow).html("Cancelled");
              } else if (aData.is_confirm==2){
                  $('td:eq(3)',nRow).html("Confirmed");
              }else{
                  $('td:eq(3)',nRow).html(""
                      +"<button class='btn btn-success' onclick='return ConfirmBill("+iDisplayindex+","+aData.id+");'>"
                      +"<i class='fa fa-check'></i>"
                      +"</button>"
                  +"");
              }
          },
        });
    });
    function ConfirmBill(index,id){
      $("#confirmModal").modal("show");
      $("#confirmModal").find("[name=id]").attr("value",id);
    }
    function ajaxCall(value=0) {
      var id=-1;
      id=$("#confirmModal").find("[name=id]").val();
      $.post("<?php echo site_url('bills/confirm/'); ?>"+id,{
          is_confirm : value
      })
      .done(function(result){
          result=JSON.parse(result);
          if(result.success==true){
              table.ajax.reload();
          }
          $("#confirmModal").modal("hide");
      });
    }
    
    </script>
<?php $this->load->view('include/page_footer.php'); ?>
