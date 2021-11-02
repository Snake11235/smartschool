<style type="text/css">
	.attachment-block .text-green{color:#3498db !important} 
</style>

<?php 
        $my_role  = $this->customlib->getStaffRole();
        $role     = json_decode($my_role);
        if($role->id==7){
        	$staff_id=$_POST['staff_id'];
        }else{
        	$staff_id=$staff_id;
        }
        $next_date = date_create($this_week_end);                                                
	    date_add($next_date, date_interval_create_from_date_string('+1 days'));
		$next_weekstartdate= date_format($next_date, $this->customlib->getSchoolDateFormat());
		$pre_date = date_create($this_week_start);                                                
	    date_add($pre_date, date_interval_create_from_date_string('-1 days'));
		$pre_weekstartdate= date_format($pre_date, $this->customlib->getSchoolDateFormat());
?>
		<div class="box-header text-center">
				<i class="fa fa-angle-left datearrow" onclick="get_weekdates('pre_week','<?php echo $pre_weekstartdate; ?>','<?php echo $staff_id; ?>')"></i><h3 class="box-title bmedium"> <?php echo $this_week_start." ".$this->lang->line('to')." ".$this_week_end; ?></h3> <i class="fa fa-angle-right datearrow" onclick="get_weekdates('next_week','<?php echo $next_weekstartdate; ?>','<?php echo $staff_id; ?>')"></i>

		</div> 
		<div class="table-responsive">
			<?php if (!empty($timetable)) {  

				?>
			<table class="table table-stripped">
				<thead>
					<tr>
						<?php $this_week_start1=$this_week_start; $counter1=0; foreach ($timetable as $tm_key => $tm_value) {
							if($counter1!=0){
							$date1 = date_create($this_week_start1);                                                
							date_add($date1, date_interval_create_from_date_string('+1 days'));
							$today1= date_format($date1, 'Y-m-d');
							$this_week_start1=$today1;
							$new_date1= date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($today1));
						}else{
							$new_date1= $this_week_start;
						}$counter1++;
						 ?>
						<th class="text text-center"><?php echo $this->lang->line(strtolower($tm_key)); ?><BR><span class="bmedium"><?php echo $new_date1; ?></span></th>
						<?php  } ?>
					</tr>
				</thead>
				<tbody> 
					<tr>
					<?php
						$counter=0;
						foreach ($timetable as $tm_key => $tm_value) {
							if($counter!=0){
							$date = date_create($this_week_start);                                                
							date_add($date, date_interval_create_from_date_string('+1 days'));
							$today= date_format($date, 'Y-m-d');
							$this_week_start=$today;
							$new_date= date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($today));
						}else{
							$new_date= $this_week_start;
						}$counter++;
						
					?>
						<td class="text text-center" width="14%">
							
							<?php if (!$timetable[$tm_key]) { ?>
							<div class="attachment-block clearfix">
								<b class="text text-center"><?php echo $this->lang->line('not'); ?> <br><?php echo $this->lang->line('scheduled'); ?></b><br>
							</div> 
							<?php } else {
							foreach ($timetable[$tm_key] as $tm_k => $tm_kue) {
								
								 $subject_group_subject_class_section=$this->lessonplan_model->getsubject_group_class_sectionsId($tm_kue->class_id,$tm_kue->section_id,$tm_kue->subject_group_id);
							
								 $subject_syllabus=$this->syllabus_model->get_subject_syllabusdata($tm_kue->subject_group_subject_id,date('Y-m-d', strtotime($new_date)),$role->id,$staff_id,$tm_kue->time_from,$tm_kue->time_to,$subject_group_subject_class_section['id']);

       
       if($subject_syllabus[0]['total']>0){
            $action= $subject_syllabus[0]['id'];
       }else{
            $action= 0;
       }
       if($action!=0){

       	?>
       	 
		<a data-placement="left" class="btn btn-default btn-xs pull-left"  data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('view')?>" onclick="get_subject_syllabus(<?php echo $action; ?>)"><i class="fa fa-reorder"></i></a>

		<?php if($this->rbac->hasPrivilege('manage_lesson_plan','can_edit')){ ?>
		<a data-placement="left" class="btn btn-default btn-xs pull-left"  data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('edit')?>" onclick="subject_syllabusedit(<?php echo $action; ?>)"><i class="fa fa-pencil"></i></a>
		<?php }
       }else{
       	?>
       	<?php if($this->rbac->hasPrivilege('manage_lesson_plan','can_add')){ ?>
       	<a data-placement="left" class="btn btn-default btn-xs pull-left"  data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('add')?>" onclick="add_syllabus('<?php echo $tm_kue->subject_group_subject_id;?>','<?php echo $tm_kue->time_from ?>','<?php echo $tm_kue->time_to; ?>','<?php echo $new_date; ?>','<?php echo $subject_group_subject_class_section['id']; ?>')"><i class="fa fa-plus"></i></a>
       	<?php
       } }
							?>
							<div class="attachment-block clearfix">
								<b class="text-green"><?php echo $this->lang->line('subject') ?>: <?php echo $tm_kue->subject_name; if($tm_kue->subject_code!=''){ echo " (" . $tm_kue->subject_code . ")";}  ?></b><br>
								<strong class="text-green"><?php echo $this->lang->line('class') ?>: <?php echo $tm_kue->class . "(" . $tm_kue->section . ")"; ?></strong><br>
								<strong class="text-green"><?php echo $tm_kue->time_from ?></strong>
								<b class="text text-center">-</b>
								<strong class="text-green"><?php echo $tm_kue->time_to; ?></strong><br>
								<strong class="text-green"><?php echo $this->lang->line('room_no'); ?>: <?php echo $tm_kue->room_no; ?></strong><br>
							</div>
							<?php
							}
							}
							?>
						</td>
					<?php
						}
					?>
					</tr>
				</tbody>
			</table>
		<?php
			} else {
		?>
		<div class="alert alert-info">
		<?php echo $this->lang->line('no_record_found'); ?>
		</div>
		<?php
		}
		?>
		</div>
	