<?php $this->load->view('include/template/common_header');?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <form id="editUser" method="post" enctype="multipart/form-data">
            <div class="box-header with-border">
                <h3 class="box-title"> Edit User</h3>
                <!-- <button type="button" id="searchItem" class="btn btn-info pull-right"><i class="fa fa-search"></i>
                     Search Item
                 </button>-->
            </div>
            <div class="box-body">
                    <div class="col-md-11">
                        <div class="panel panel-info">
                            <div class="panel-header">

                            </div>
                            <div class="panel-body">
                                <div class="row form-group">
                                      <label class="col-md-2"> First Name : </label>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control first_name" name="first_name">
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Last Name : </label>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control last_name" name="last_name">
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> User Name : </label>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control user_name" name="user_name">
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Email : </label>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control email" name="email">
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Phone No : </label>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control phone_no" name="phone_no">
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Bio : </label>
                                      <div class="col-md-5">
                                          <textarea type="text" class="form-control bio" name="bio"></textarea>
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> City : </label>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control city" name="city">
                                      </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-md-2">D.O.B. :</label>
                                    <div class="col-md-5">
                                        <input type="text" value="" class="form-control birth_date" name="birth_date">
                                    </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Gender : </label>
                                      <div class="col-md-5">
                                          <select class="form-control select sex" name='sex'>
                                              <option value="1">Male</option>
                                              <option value="2">Female</option>
                                          </select>
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> User Type : </label>
                                      <div class="col-md-5">
                                          <select class="form-control select user_type" name='user_type'>
                                              <option value="1">General</option>
                                              <option value="2">Expert User</option>
                                          </select>
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Password : </label>
                                      <div class="col-md-5">
                                          <input type="password" class="form-control password" name="password">
                                      </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-md-2"> Image : </label>
                                    <div class="col-md-5">
                                        <input id="input-b1" name="image" type="file" class="file">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-md-2 text-right"></label>
                                    <div class="col-md-5">
                                        <img style='height:50px; widht:50px;' name='eimage' />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="box-footer">
                <div class="row form-group col-md-offset-5">
                    <input type="submit" value="Save" class="btn btn-success save">
                    <a href="<?php echo site_url('users/list'); ?>" class="btn btn-danger">
                        Cancel
                    </a>
        </div>
    </div>
    </form>
    <div class="overlay">
      <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>
</div>
</div>
<?php $this->load->view('include/template/common_footer'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.birth_date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            endDate: "today",
            maxDate: "today"
        });
        $.ajax({
            url: "<?php echo site_url('users/getUserData/');echo $id;?>",
            type: 'POST',
            success: function (data) {
              data = JSON.parse(data);
              if(data.success == true){
                setData(data.response);
              } else {
                alert(data.msg);
              }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    $("#editUser").validate({
      rules: {
        first_name: {
          required: true
        },
        email: {
          required: true,
          email: true
        },
        phone_no: {
          required: true,
          digits: true,
          minlength: 10,
          maxlength: 10
        },
        sex: {
          required: true
        },
        birth_date: {
          required: true,
        },
        user_type: {
          required: true
        },
        city: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitForm(form);
      }
    });
    function submitForm(form){
        loadingStart();
        var formData = new FormData(form);
        $.ajax({
            url: "<?php echo site_url('users/update/');echo $id?>",
            type: 'POST',
            data: formData,
            success: function (data) {
              loadingStop();
              data = JSON.parse(data);
              alert(data.msg);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    function setData(data){
        $('.first_name').val(data.first_name);
        $('.last_name').val(data.last_name);
        $('.email').val(data.email);
        $('.bio').val(data.bio);
        $('.phone_no').val(data.phone_no);
        $('.password').val(data.password);
        $('.sex').val(data.sex);
        $(".birth_date").datepicker("update", new Date(data.birth_date));
        $('.user_type').val(data.user_type);
        $('.city').val(data.city);
        $('.user_name').val(data.user_name);
        base_url = "<?php echo base_url(); ?>"+data.profile_pic;
        $("#editUser").find("[name=eimage]").attr("src",base_url);
    }
    function resetData(){
        $('.first_name').val("");
        $('.last_name').val("");
        $('.email').val("");
        $('.bio').val("");
        $('.phone_no').val("");
        $('.password').val("");
        $('.sex').val("1");
        $('.birth_date').val("");
        $('.user_type').val("1");
        $('.city').val("");
        $('.user_name').val("");
    }
</script>
