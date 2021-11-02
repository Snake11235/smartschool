<link rel="stylesheet" href="<?php echo base_url(); ?>backend/calender/zabuto_calendar.min.css">
<script type="text/javascript" src="<?php echo base_url(); ?>backend/calender/zabuto_calendar.min.js"></script>
<style>
    .grade-1 {
        background-color: #337ab7;
    }
    .grade-2 {
        background-color: #FA8A00;
    }
    .grade-3 {
        background-color: #FFEB00;
    }
    .grade-4 {
        background-color: #27AB00;
    }
    .grade-5 {
        background-color: #a7a7a7;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('attendance'); ?></small>        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    </div>
                    <div class="box-body">
                        <div id="my-calendar"></div>
                    </div>
                </div>
            </div>
             <div class="col-md-8">
                <div class="box box-primary">
                    
                        <div class="box-header ptbnull">
                            <h3 class="box-title"> <?php echo $this->lang->line('event_list');?></h3>
                            <div class="box-tools pull-right">
                                
                                    <button class="btn btn-primary btn-sm pull-right" onclick="add_event()"><i class="fa fa-plus"></i></button>
                                                            </div>


                        </div>
                 
                    <div class="box-body">
                         <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                
                                            <th><?php echo $this->lang->line('event')." ".$this->lang->line('title')?></th>
                                    
                                            <th><?php echo $this->lang->line('from'); ?></th>
                                            <th><?php echo $this->lang->line('to'); ?></th>
                                            <th><?php echo $this->lang->line('visibilty_on_CMS');?></th>
                                            <th><?php echo $this->lang->line('action'); ?></th>
                                            
                                        </tr> 
                                    </thead>
                                    <tbody>
                                       <?php 
                                       foreach ($eventlist as $key => $value) {
                                          ?>
                                          <tr>
                                            <td><?php echo $value['title']; ?></td>
                                            <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['from_date']));?></td>
                                            <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['to_date']));?></td>
                                           
                                            <td> <?php if($value['show_onwebsite']=='0'){ echo $this->lang->line("no_need_to_show"); }else{ echo $this->lang->line("show"); }?></td>
                                            <td><a class="btn btn-default btn-xs" onclick="edit('<?php echo $value['id']; ?>')" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $this->lang->line('edit');?>"><i class="fa fa-pencil"></i>
                                                                            </a>
                                            <a onclick="return confirm('Delete Confirm?')" href="<?php echo base_url();?>admin/alumni/delete_event/<?php echo $value['id']; ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-remove"></i></a></td>
                                          </tr>
                                          <?php
                                       }
                                       ?>
                                     
                                    </tbody>
                                </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
 <div id="newevent" class="modal fade " role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modal-title" ></h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <form role="form"  id="addevent_form11" method="post" enctype="multipart/form-data" action="">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('event')." ".$this->lang->line('title'); ?></label><small class="req"> *</small>
                            <input type="hidden" name="id" id="id">
                            <input class="form-control" id="event_title" name="event_title"  > 
                            <span class="text-danger"><?php echo form_error('title'); ?></span>

                        </div>


                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line("event_starting_date"); ?></label><small class="req"> *</small>
                            <input class="form-control date" id="event_starting_date" type="text" autocomplete="off"  name="event_starting_date" placeholder="<?php echo $this->lang->line("event_starting_date"); ?>" >
                           
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line("event_ending_date"); ?></label><small class="req"> *</small>
                            <input class="form-control date" id="event_end_date" type="text" autocomplete="off"  name="event_end_date" placeholder="<?php echo $this->lang->line("event_ending_date"); ?>" >
                           
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line("visibilty_on_CMS"); ?></label>
                           
                           <select class="form-control" id="Visibilty"  name="Visibilty" ><option value="1"><?php echo $this->lang->line('show') ?></option> <option value="0"><?php  echo $this->lang->line('no_need_to_show'); ?></option></select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('event')." ".$this->lang->line('photo'); ?></label>
                           
                           <input type="file" name="file" class="form-control filestyle">
                        </div>

						<div class="form-group col-md-12">
                            <input type="checkbox" name="email" value="1" > <?php echo $this->lang->line('email'); ?>
                            <input type="checkbox" name="sms" value="1" > <?php echo $this->lang->line('sms'); ?>
                        </div>

						<div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line("email").' & '.$this->lang->line("sms").' '.$this->lang->line("body"); ?></label>
                            <textarea class="form-control" id="email_sms_body" type="text" autocomplete="off"  name="email_sms_body" placeholder="" ></textarea>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <input type="submit" class="btn btn-primary  pull-right" value="<?php echo $this->lang->line('save'); ?>"></div> </form>
                </div>

            </div>
        </div>
    </div>
</div> 
<script type="application/javascript">
 
    function edit(id){
        $('#modal-title').html('<?php echo $this->lang->line('edit')." ".$this->lang->line('event')?>');
        $.ajax({
            url: "<?php echo site_url("admin/alumni/get_event") ?>/"+id,
            type: "POST",
           
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            
            success: function (res)
            { 
			
                $('#event_title').val(res.title);
                 $('#event_starting_date').val(res.from_date);
                  $('#event_end_date').val(res.to_date);
                  $('#Visibilty').val(res.show_onwebsite);
                  $('#id').val(res.id);
                 $('#newevent').modal('show');
            },
            error: function (xhr) { // if error occured
                alert("Error occured.please try again");
               
            },
            complete: function () {
                
            }

        });
    }

    $(document).ready(function () {
    var  base_url = '<?php echo base_url() ?>';
    $("#my-calendar").zabuto_calendar({
         action: function () {
            console.log(this);
                return myDateFunction(this.id, false);
            },
            action_nav: function () {
                return myNavFunction(this.id);
            },
    legend: [
    {type: "block", label: "<?php echo $this->lang->line('event') ?>", classname: 'grade-2'},
   
    ],
    ajax: {
    url: base_url+"admin/alumni/getevent?grade=1",
    modal: true, 
    
    }
    });
    });

    function myNavFunction(id) {
 
}
 
     function myDateFunction(id, fromModal) {
       var date = $("#" + id).data("date");
       
    }

    function add_event(){
        $('#modal-title').html('<?php echo $this->lang->line('add')." ".$this->lang->line('event')?>');
    $('#newevent').modal('show');
    }


    $("#addevent_form11").on('submit', (function (e) {
        e.preventDefault();

        var $this = $(this).find("button[type=submit]:focus");

        $.ajax({
            url: "<?php echo site_url("admin/alumni/add_event") ?>",
            type: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $this.button('loading');

            },
            success: function (res)
            {

                if (res.status == "fail") {

                    var message = "";
                    $.each(res.error, function (index, value) {

                        message += value;
                    });
                    errorMsg(message);

                } else {

                    successMsg(res.message);

                    window.location.reload(true);
                }
            },
            error: function (xhr) { // if error occured
                alert("Error occured.please try again");
                $this.button('reset');
            },
            complete: function () {
                $this.button('reset');
            }

        });
    }));
</script>