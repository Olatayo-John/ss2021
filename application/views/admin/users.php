<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/users.css'); ?>">
<div class="container-fluid pt-3">

	<div class="modal addusermodal" style="padding: auto;" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header d-flex justify-content-center mb-0">
					<h5 class="font-weight-bolder">New User</h5>
				</div>
				<div class="mb-0 mb-1 alert-danger chkboxerr container" style="display: none;">
					<i class="fas fa-exclamation-circle"></i>
					<strong>Pick a method to send login credentials to user</strong>
				</div>
				<form action="<?php echo base_url('add-user'); ?>" method="post" class="mt-0">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf-token">
					<div class="modal-body">
						<div class="form-group mt-0">
							<label><span class="text-danger font-weight-bolder">* </span>Username</label>
							<input type="text" name="full_name" class="form-control full_name" placeholder="Pick a Username">
						</div>
						<div class="form-group">
							<label><span class="text-danger font-weight-bolder">* </span>E-mail</label>
							<input type="email" name="email" class="form-control email" placeholder="E-mail">
							<input type="checkbox" name="mail_chkbox" class="mr-2 ml-2 mail_chkbox"><span class="text-danger mail_chkbox_span">Send Login Credentails via E-mail?</span>
						</div>
						<div class="form-group">
							<label><span class="text-danger font-weight-bolder">* </span>Mobile</label>
							<input type="number" name="mobile" class="form-control mobile" placeholder="Mobile">
							<div class="text-dark text-right font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
							<input type="checkbox" name="mobile_chkbox" class="mr-2 ml-2 mobile_chkbox"><span class="text-danger mobile_chkbox_span">Send Login Credentails via SMS?</span>
						</div>
						<div class="form-group">
							<label>Employee ID</label>
							<input type="text" name="eid" class="form-control eid" placeholder="Employee ID">
						</div>
						<div class="form-group">
							<label>Department</label>
							<select class="form-control dept" name="dept">
								<option value="Staff">Staff</option>
								<option value="Admin">Admin</option>
							</select>
						</div>
						<div class="modalbtngrp justify-content-between d-flex mt-0">
							<button class="btn btn-secondary closemodalbtn bradius" type="button">Close</button>
							<button class="btn btn-success adduserbtn bradius" type="submit">Add</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal updateusermodal" style="padding: auto;" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<div class="form-group mt-2">
						<label><span class="text-danger font-weight-bolder">* </span>Username</label>
						<input type="u_fname" name="u_fname" class="form-control u_fname">
					</div>
					<div class="form-group">
						<label><span class="text-danger font-weight-bolder">* </span>E-mail</label>
						<input type="email" name="u_email" class="form-control u_email">
					</div>
					<div class="form-group">
						<label><span class="text-danger font-weight-bolder">* </span>Mobile</label>
						<input type="number" name="u_mobile" class="form-control u_mobile">
					</div>
					<div class="form-group">
						<label>User Link</label>
						<i class="fas fa-copy" onclick="copyfunc('#u_link')"></i>
						<span class="linkcopyalert text-dark text-right" style="display: none;"><strong>Link copied!</strong></span>
						<input type="text" class="form-control u_link" name="u_link" id="u_link" readonly>
					</div>
					<div class="form-group row">
						<div class="col-md-6">
							<label>Employee ID</label>
							<input type="text" name="u_eid" class="form-control u_eid">
						</div>
						<div class="col-md-6 deptcol">
							<label>Department</label>
							<select class="form-control deptselect" for="u_dept" name="deptselect">
								<option class="u_dept"></option>
								<option class="u_dept_two"></option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label>Password</label>
						<div class="input-group">
							<input type="text" name="u_pwd" class="form-control u_pwd">
							<div class="input-group-prepend genpwdbtn">
								<div class="input-group-text"><i class="fas fa-sync-alt"></i></div>
							</div>
						</div>
						<div class="text-danger font-weight-bolder pwderr">Password will be changed on this user</div>
					</div>

				</div>
				<div class="updatebtngrp d-flex justify-content-between mb-2">
					<button class="btn btn-dark closeupdatebtn bradius ml-2">Close</button>
					<input type="hidden" name="ser_id" class="form-control user_id">
					<button class="btn btn-success updatebtn bradius mr-2">Update</button>
				</div>
			</div>
		</div>
	</div>


	<table id="UserTable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="left" data-pagination="true" data-sticky-header="true" data-sticky-header-offset-y="60" tablename="Users" data-buttons=buttons style="white-space:nowrap;">
		<thead class="text-light" style="background:#223b55;">
			<tr>
				<th data-field="Username" data-sortable="true">Username</th>

				<th data-field="Mobile" data-sortable="true">Mobile</th>

				<th data-field="UserLink" data-sortable="true">User Link</th>

				<th data-field="EmployeeID" data-sortable="true">Employee ID</th>

				<th data-field="Department" data-sortable="true">Department</th>

				<th data-field="Action" data-sortable="true">Action</th>
			</tr>
		</thead>
		<tbody class="bg-light">
			<?php foreach ($users->result_array() as $info) : ?>
				<tr>
					<td class="text-uppercase"><?php echo $info['full_name'] ?></td>
					<td><?php echo $info['mobile'] ?></td>
					<td><?php echo base_url() . 'user/rate/' . $info['form_key'] ?></td>
					<td class="text-uppercase"><?php echo $info['eid'] ?></td>
					<td class="text-uppercase"><?php echo $info['dept'] ?></td>
					<td>
						<div class="d-flex justify-content-between">
							<i class="fas fa-user-edit text-success" id="<?php echo $info['id'] ?>" style="padding: 5px;"></i>
							<i class="fas fa-trash-alt text-danger" id="<?php echo $info['id'] ?>" form_key="<?php echo $info['form_key'] ?>" style="padding: 5px;"></i>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>



	<script type="text/javascript" src="<?php echo base_url('assets/js/users.js'); ?>"></script>
	<script type="text/javascript">
		$(function() {
			var buttonsOrder = ['export', 'btnAdd'];

			$('#UserTable').bootstrapTable('refreshOptions', {
				buttonsOrder: buttonsOrder
			})

		});

		function buttons() {
			return {
				btnAdd: {
					icon: 'fa-user-plus',
					'event': {
						'click': () => {
							$('.addusermodal').modal('show');
						}
					}
				}
			}
		}

		$(document).ready(function() {

			$(document).on('click', 'i.fa-user-edit', function() {
				var user_id = $(this).attr("id");
				var csrfName = $('.csrf-token').attr('name');
				var csrfHash = $('.csrf-token').val();

				$.ajax({
					url: "<?php echo base_url('get-user') ?>",
					method: "POST",
					data: {
						user_id: user_id,
						[csrfName]: csrfHash
					},
					dataType: "json",
					success: function(data) {
						$('.user_id').val(data.id);
						$('.csrf-token').val(data.token);
						$('.updateusermodal').modal('show');
						$('.u_fname').val(data.u_fname);
						$('.u_email').val(data.u_email);
						$('.u_mobile').val(data.u_mobile);
						$('.u_link').val(data.u_link);
						$('.u_eid').val(data.u_eid);
						$('.u_dept').html(data.u_dept).val(data.u_dept);
						if (data.u_dept == "Admin") {
							$('.u_dept_two').html("Staff").val("Staff");
						} else {
							$('.u_dept_two').html("Admin").val("Admin");
						}
					}
				});
			});

			$(document).on('click', '.updatebtn', function() {
				var user_id = $('.user_id').val();
				var u_fname = $('.u_fname').val();
				var u_email = $('.u_email').val();
				var u_mobile = $('.u_mobile').val();
				var u_link = $('.u_link').val();
				var u_eid = $('.u_eid').val();
				var u_dept = $('.u_dept').val();
				var deptselect = $('.deptselect').val();
				var u_pwd = $('.u_pwd').val();
				var csrfName = $('.csrf-token').attr('name');
				var csrfHash = $('.csrf-token').val();

				if (u_fname == "" || u_fname == null) {
					$('.u_fname').css('border', ' 1px solid red');
					return false;
				} else {
					$('.u_fname').css('border', '1px solid #ced4da');
				}
				if (u_email == "" || u_email == null) {
					$('.u_email').css('border', ' 1px solid red');
					return false;
				} else {
					$('.u_email').css('border', '1px solid #ced4da');
				}
				if (u_mobile == "" || u_mobile == null) {
					$('.u_mobile').css('border', ' 1px solid red');
					return false;
				}
				if (u_mobile.length < 10 || u_mobile.length > 10) {
					$('.u_mobile').css('border', '1px solid red');
					$('.u_mobileerr').show();
					return false;
				} else {
					$('.u_mobile').css('border', '1px solid #ced4da');
					$('.u_mobileerr').hide();
				}

				$.ajax({
						url: "<?php echo base_url('update-user') ?>",
						method: "POST",
						data: {
							user_id: user_id,
							u_fname: u_fname,
							u_email: u_email,
							u_mobile: u_mobile,
							u_link: u_link,
							u_eid: u_eid,
							deptselect: deptselect,
							u_pwd: u_pwd,
							[csrfName]: csrfHash
						},
						beforeSend: function() {
							$('.updatebtn').removeClass("btn-success").addClass("btn-danger");
							$('.updatebtn').html("Updating...");
							$('.updatebtn').attr("disabled", "disabled");
							$('.updatebtn').css("cursor", "not-allowed");
						},
						error: function(data) {
							alert("Error updating");
						}
					})
					.done(function() {
						window.location.reload();
					});
			});

			$(document).on('click', 'i.fa-trash-alt', function() {
				var user_id = $(this).attr('id');
				var form_key = $(this).attr('form_key');
				var csrfHash = $('.csrf-token').val();
				var csrfName = $('.csrf-token').attr('name');
				var con = confirm("Are you sure you want to delete this user and all of its data?");
				if (con == false) {
					return false;
				} else if (con == true) {
					$.ajax({
							url: "<?php echo base_url('/delete-user'); ?>",
							method: "post",
							data: {
								user_id: user_id,
								form_key: form_key,
								[csrfName]: csrfHash
							},
							error: function(data) {
								alert('Failed to delete. Please refresh page');
							}
						})
						.done(function() {
							window.location.reload();
						});
				}
			});

		});
	</script>