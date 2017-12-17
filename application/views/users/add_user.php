<?php $this->load->view('include/template/common_header'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <form id="addUser" method="post" enctype="multipart/form-data">
            <div class="box-header with-border">
                <h3 class="box-title"> Add User</h3>
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
                                          <input type="text" class="form-control first_name" name="first_name" >
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Last Name : </label>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control last_name" name="last_name" >
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> User Name : </label>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control user_name" name="user_name" >
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Email : </label>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control email" name="email" >
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Phone No : </label>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control phone_no" name="phone_no" >
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Bio : </label>
                                      <div class="col-md-5">
                                          <textarea type="text" class="form-control bio" name="bio" ></textarea>
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> City : </label>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control city" name="city" >
                                      </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-md-2">D.O.B. :</label>
                                    <div class="col-md-5">
                                        <input id="birth_date" type="text" class="birth_date form-control"
                               value="<?php echo date('Y-m-d', strtotime('today', time())); ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Gender : </label>
                                      <div class="col-md-5">
                                          <select class="form-control select sex" name='sex' >
                                              <option value="">Select</option>
                                              <option value="1">Male</option>
                                              <option value="2">Female</option>
                                          </select>
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> User Type : </label>
                                      <div class="col-md-5">
                                          <select class="form-control select user_type" name='user_type' >
                                              <option value="">Select</option>
                                              <option value="1">General</option>
                                              <option value="2">Expert User</option>
                                          </select>
                                      </div>
                                </div>
                                <div class="row form-group">
                                      <label class="col-md-2"> Password : </label>
                                      <div class="col-md-5">
                                          <input type="password" class="form-control password" name="password" >
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
                <div class="row form-group">
            </div>
        </div>
    </div>
    </form>
</div>
<?php $this->load->view('include/template/common_footer'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.birth_date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });

    });
    $("#addUser").validate({
      rules: {
        first_name: {
          required: true
        },
        last_name: {
          required: true
        },
        email: {
          required: true,
          email: true
        },
        bio: {
          required: true
        },
        phone_no: {
          required: true,
          digits: true,
          minlength: 10,
          maxlength: 10
        },
        password: {
          required: true
        },
        sex: {
          required: true
        },
        birth_date: {
          required: true
        },
        user_type: {
          required: true
        },
        city: {
          required: true
        },
        user_name: {
          required: true
        }
      },
      submitHandler: function(form) {
        submitForm(form);
      }
    });
    function submitForm(form){
        var formData = new FormData(form);
        $.ajax({
            url: "<?php echo site_url('users/register');?>",
            type: 'POST',
            data: formData,
            success: function (data) {
              data = JSON.parse(data);
              alert(data.msg);
              if(data.success == true){
                resetData();
              }
            },
            cache: false,
            contentType: false,
            processData: false
        });
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
