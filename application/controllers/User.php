<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function index()
	{
		if ($this->session->userdata('rr_logged_in')) {
			redirect('rating');
		}
		$this->load->view('templates/header');
		$this->load->view('users/login');
		$this->load->view('templates/footer');
	}

	public function login()
	{
		if ($this->session->userdata('rr_logged_in')) {
			redirect('rating');
		}
		$this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape');
		$this->form_validation->set_rules('pwd', 'Password', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->index();
		} else {
			$validate = $this->Usermodel->login();
			if ($validate == FALSE) {
				$this->session->set_flashdata('err', 'Username/Password is wrong');
				redirect('user');
				exit();
			}
			if ($validate) {
				$rr_id = $validate->id;
				$rr_admin = $validate->admin;
				$rr_s_admin = $validate->s_admin;
				$rr_fname = $validate->full_name;
				$rr_email = $validate->email;
				$rr_mobile = $validate->mobile;
				$rr_form_key = $validate->form_key;

				$rr_user_sess = array(
					'rr_id' => $rr_id,
					'rr_admin' => $rr_admin,
					'rr_s_admin' => $rr_s_admin,
					'rr_fname' => $rr_fname,
					'rr_email' => $rr_email,
					'rr_mobile' => $rr_mobile,
					'rr_form_key' => $rr_form_key,
					'rr_sub' => '0',
					'rr_logged_in' => TRUE,
				);
				$this->session->set_userdata($rr_user_sess);
				$this->session->set_flashdata('succ', 'Welcome ' . $this->session->userdata('rr_fname') . "!");
				redirect('rating');
			}
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('rr_id');
		$this->session->unset_userdata('rr_admin');
		$this->session->unset_userdata('rr_s_admin');
		$this->session->unset_userdata('rr_fname');
		$this->session->unset_userdata('rr_email');
		$this->session->unset_userdata('rr_mobile');
		$this->session->unset_userdata('rr_form_key');
		$this->session->unset_userdata('rr_sub');
		$this->session->unset_userdata('rr_logged_in');
		//$this->session->sess_destroy();

		$this->session->set_flashdata('log_out', 'Logged out');
		redirect('login');
	}

	public function register()
	{
		if ($this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Log out first.');
			redirect($_SERVER['HTTP_REFERER']);
		}
		$this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|html_escape');
		$this->form_validation->set_rules('eid', 'Employee ID', 'trim|html_escape');
		$this->form_validation->set_rules('dept', 'Department', 'trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('users/register');
			$this->load->view('templates/footer');
		} else {
			$form_key =  mt_rand(0, 10000) . substr($this->input->post('mobile'), -4);
			$randpwd =  mt_rand(0, 10000000);

			$fname = htmlentities($this->input->post('full_name'));
			$email = htmlentities($this->input->post('email'));
			$mobile = htmlentities($this->input->post('mobile'));
			$link = base_url() . "rate/" . $form_key;
			$login_link = base_url();

			//send sms
			$bdy = "Hello " . $fname . "\n\nBelow are your login details :\nUsername: " . $fname . "\nPassword: " . $randpwd . "\nLink: " . $link . "\nShare the above link to collect Feedbacks.\r\nNIPL";
			$url = "http://savshka.in/api/pushsms?user=502893&authkey=926pJyyVe2aK&sender=SSURVE&mobile=" . $mobile . "&text=";
			$req = curl_init();
			$complete_url = $url . curl_escape($req, $bdy) . "&entityid=1001715674475461342&templateid=1007838850146399750&rpt=1";
			curl_setopt($req, CURLOPT_URL, $complete_url);
			curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($req);

			//send email
			$res = $this->send_succ($fname, $randpwd, $email, $link, $login_link);

			if ($res !== true) {
				$this->session->set_flashdata('err', 'Failed to send Login credentials' . $res);
				redirect('register');
				exit();
			} else {
				$pwd = password_hash($randpwd, PASSWORD_DEFAULT);

				$res = $this->Usermodel->register($form_key, $pwd);
				if ($res !== TRUE) {
					$this->session->set_flashdata('err', 'Registration Failed');
					redirect('register');
					exit();
				} else {
					$this->session->set_flashdata('succ', 'Login credentials sent to your mail.');
					redirect('login');
					exit();
				}
			}
		}
	}

	public function edit()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Login first.');
			redirect('login');
		}

		$this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|html_escape');
		$this->form_validation->set_rules('eid', 'Employee ID', 'trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$data['info'] = $this->Usermodel->get_info();
			$data['user'] = $this->Usermodel->user_total_ratings(); //all user rating
		$data['userToday'] = $this->Usermodel->user_total_ratings_today(); //all user rating

			$this->load->view('templates/header');
			$this->load->view('users/edit', $data);
			$this->load->view('templates/footer');
		} else {
			$res = $this->Usermodel->edit();
			if ($res !== TRUE) {
				$this->session->set_flashdata('err', 'Update Failed');
			} else {
				$this->session->set_flashdata('succ', 'Profile Updated');
			}

			redirect('edit');
		}
	}

	public function send_succ($fname, $randpwd, $email, $link, $login_link)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'mail.swachhsurvekshan.org';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'swachh22@swachhsurvekshan.org';
		$config['smtp_pass']    = 'C9aidcT&G=TJ';
		$config['charset']    = 'utf-8';
		$config['mailtype'] = 'html';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$body = "Hello " . ucfirst($fname) . ". Below are your login credentails:<br><br>Username: " . $fname . "<br>Password: " . $randpwd . "<br>Share this <a style='text-decoration: none' href='" . $link . "'>link</a> to get reviews.<br><br>You can login <a style='text-decoration: none' href='" . $login_link . "'>here</a> <br>If you have any questions, send us an email at info@nktech.in.<br><br>Best Regards,<br><a style='text-decoration: none' href='https://nktech.in'>NKTECH</a>";

		$this->email->from('swachh22@swachhsurvekshan.org', 'Swachh Survekshan');
		$this->email->to($email);
		$this->email->subject("Login Credentials");
		$this->email->message($body);
		$this->email->set_mailtype('html');

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function rating()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Login first.');
			redirect('login');
		} else {
			$this->load->view('templates/header');
			$this->load->view('users/index');
			$this->load->view('templates/footer');
		}
	}

	public function get_link()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('user');
		}
		$cq_res = $this->Adminmodel->check_quota_expire();
		if ($cq_res !== false) {
			$db_email = $cq_res->email;
			if ($this->session->userdata('rr_admin') == "0") {
				$this->session->set_flashdata('err', 'Quota has expired. Request has been sent to admin for renewal');
				$this->quota_send_mail_expire($db_email);
			} else if ($this->session->userdata('rr_admin') == "1") {
				$this->session->set_flashdata('err', 'Quota has expired');
			}
		} else {
			$res = $this->Usermodel->get_link($_POST['id']);
			if (!$res) {
				return FALSE;
				exit();
			}
			if ($res) {
				$output[] = array();
				$output['id'] = $res->id;
				$output['full_name'] = $res->full_name;
				$output['mobile'] = $res->mobile;
				$output['email'] = $res->email;
				$output['eid'] = $res->eid;
				$output['dept'] = $res->dept;
				$output['form_key'] = $res->form_key;
				$output['token'] = $this->security->get_csrf_hash();
				// echo json_encode($output);

				//votingFile
				$myfile = fopen("body.txt", "w") or die("Unable to open file!");
				$txt = "Make Bulandshahar No.1\r\n";
				fwrite($myfile, $txt);
				$txt = "Vote your feedback\r\n";
				fwrite($myfile, $txt);
				$txt = base_url() . "rate/" . $output['form_key'] . "\n\n";
				fwrite($myfile, $txt);
				$txt = "Best Regards\r\n";
				fwrite($myfile, $txt);
				$txt = "NIPL";
				fwrite($myfile, $txt);
				fclose($myfile);

				//appFile
				$myfile = fopen("Appbody.txt", "w") or die("Unable to open file!");
				$txt = "Download Swachhta App\n";
				fwrite($myfile, $txt);
				$txt = base_url() . "download-swachhta-app\n\n";
				fwrite($myfile, $txt);
				$txt = "Best Regards\n";
				fwrite($myfile, $txt);
				$txt = "NIPL";
				fwrite($myfile, $txt);
				fclose($myfile);

				//BothFile
				$myfile = fopen("Bothbody.txt", "w") or die("Unable to open file!");
				$txt = "Make Bulandshahar No.1\r\n";
				fwrite($myfile, $txt);
				$txt = "Vote your feedback\r\n";
				fwrite($myfile, $txt);
				$txt = base_url() . "rate/" . $output['form_key'] . "\n\n";
				fwrite($myfile, $txt);
				$txt = "Download Swachhta App\n";
				fwrite($myfile, $txt);
				$txt = base_url() . "download-swachhta-app\n\n";
				fwrite($myfile, $txt);
				$txt = "Best Regards\n";
				fwrite($myfile, $txt);
				$txt = "NIPL";
				fwrite($myfile, $txt);
				fclose($myfile);

				echo json_encode($output);
			}
		}
	}

	public function changeLink()
	{
		if ($_POST['val'] && $_POST['val'] === 'dlink') {

			//votingFile
			$myfile = fopen("body.txt", "w") or die("Unable to open file!");
			$txt = "Direct Link to vote\n";
			fwrite($myfile, $txt);
			$txt = "https://ss-cf.sbmurban.org/#/feedback\n\n";
			fwrite($myfile, $txt);
			$txt = "Best Regards\n";
			fwrite($myfile, $txt);
			$txt = "Nagar Nigam Ghaziabad";
			fwrite($myfile, $txt);
			fclose($myfile);

			//BothFile
			$myfile = fopen("Bothbody.txt", "w") or die("Unable to open file!");
			$txt = "Direct Link to vote\n";
			fwrite($myfile, $txt);
			$txt = "https://ss-cf.sbmurban.org/#/feedback\n\n";
			fwrite($myfile, $txt);
			$txt = "Download Swachhta App\n";
			fwrite($myfile, $txt);
			$txt = base_url() . "download-swachhta-app\n\n";
			fwrite($myfile, $txt);
			$txt = "Best Regards\n";
			fwrite($myfile, $txt);
			$txt = "Nagar Nigam Ghaziabad";
			fwrite($myfile, $txt);
			fclose($myfile);
		} else if ($_POST['val'] && $_POST['val'] === 'ow') {
			//votingFile
			$myfile = fopen("body.txt", "w") or die("Unable to open file!");
			$txt = "Make Bulandshahar No.1\r\n";
			fwrite($myfile, $txt);
			$txt = "Vote your feedback\r\n";
			fwrite($myfile, $txt);
			$txt = base_url() . "rate/" . $_SESSION['rr_form_key'] . "\n\n";
			fwrite($myfile, $txt);
			$txt = "Best Regards\r\n";
			fwrite($myfile, $txt);
			$txt = "NIPL";
			fwrite($myfile, $txt);
			fclose($myfile);

			//appFile
			$myfile = fopen("Appbody.txt", "w") or die("Unable to open file!");
			$txt = "Download Swachhta App\n";
			fwrite($myfile, $txt);
			$txt = base_url() . "download-swachhta-app\n\n";
			fwrite($myfile, $txt);
			$txt = "Best Regards\n";
			fwrite($myfile, $txt);
			$txt = "NIPL";
			fwrite($myfile, $txt);
			fclose($myfile);

			//BothFile
			$txt = "Make Bulandshahar No.1\r\n";
			fwrite($myfile, $txt);
			$txt = "Vote your feedback\r\n";
			fwrite($myfile, $txt);
			$txt = base_url() . "rate/" . $_SESSION['rr_form_key'] . "\n\n";
			fwrite($myfile, $txt);
			$txt = "Download Swachhta App\n";
			fwrite($myfile, $txt);
			$txt = base_url() . "download-swachhta-app\n\n";
			fwrite($myfile, $txt);
			$txt = "Best Regards\n";
			fwrite($myfile, $txt);
			$txt = "NIPL";
			fwrite($myfile, $txt);
			fclose($myfile);
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function downloadApp()
	{
		$Appres = $this->Usermodel->downloadApp();
		if ($Appres === true) {
			header('Location: https://play.google.com/store/apps/details?id=com.ichangemycity.swachhbharat&hl=en_AU&gl=US');
		}
	}

	public function quota_send_mail_expire($db_email)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'mail.swachhsurvekshan.org';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'swachh22@swachhsurvekshan.org';
		$config['smtp_pass']    = 'C9aidcT&G=TJ';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$body = "Hello.\n\nThis email is to inform you that your Quota has expired.SMS, Emails and Future ratings woun't be recorded\nClick here to login to your account to renew for a new plan " . base_url('pick-plan') . "\nIf you have any questions, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

		$this->email->from('swachh22@swachhsurvekshan.org', 'Swachh Survekshan');
		$this->email->to($db_email);
		$this->email->subject('Quota Limit');
		$this->email->message($body);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function send_link()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('user');
		}
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('subj', 'Subject', 'required|trim|html_escape');
		$this->form_validation->set_rules('bdy', 'Body', 'required|trim|html_escape');

		if ($this->form_validation->run() == FALSE) {
			$this->rating();
		} else {
			$cq_res = $this->Adminmodel->check_quota_expire();
			if ($cq_res !== false) {
				$db_email = $cq_res->email;
				if ($this->session->userdata('rr_admin') == "0") {
					$this->quota_send_mail_expire($db_email);
					$this->session->set_flashdata('err', 'Quota has expired. Request has been sent to admin for renewal');
					redirect('rating');
				} else if ($this->session->userdata('rr_admin') == "1") {
					$this->session->set_flashdata('err', 'Quota has expired');
					redirect('pick-plan');
				}
			} else {
				$email = $this->input->post('email');
				$subj = $this->input->post('subj');
				$bdy = $this->input->post('bdy');
				$mail_res = $this->link_send_mail($email, $subj, $bdy);
				if ($mail_res !== true) {
					$this->session->set_flashdata('err', $mail_res);
					redirect('rating');
					exit();
				} else {
					$res = $this->Usermodel->save_info();
					if ($res !== true) {
						$this->session->set_flashdata('err', 'Error saving contacts to DATABASE.');
						redirect('rating');
						exit();
					} else {
						$length = '1';
						$cq_res = $this->Adminmodel->quota_update($length);
						if ($cq_res !== false) {
							$db_email = $cq_res->email;
							$this->quota_send_mail_expire($db_email);
							$this->session->set_flashdata('succ', 'Link sent successfully');
							redirect('rating');
						} else {
							$this->session->set_flashdata('succ', 'Link sent successfully');
							redirect('rating');
						}
					}
				}
			}
		}
	}

	public function link_send_mail($email, $subj, $bdy)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'mail.swachhsurvekshan.org';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'swachh22@swachhsurvekshan.org';
		$config['smtp_pass']    = 'C9aidcT&G=TJ';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");


		$this->email->from('swachh22@swachhsurvekshan.org', 'Swachh Survekshan');
		$this->email->to($email);
		$this->email->subject($subj);
		$this->email->message($bdy);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function importcsv()
	{
		$file_data = fopen($_FILES['csv_file']['tmp_name'], 'r');
		fgetcsv($file_data);
		while ($row = fgetcsv($file_data)) {
			$data[] = array(
				'Email' => $row[0],
			);
		}
		echo json_encode($data);
	}

	public function email_sample_csv()
	{
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=email_csv_sample.csv");
		$output = fopen("php://output", "w");
		fputcsv($output, array('Email'));
		$data['email'] = array(
			'email' => "example@domain-name.com",
		);
		foreach ($data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
	}

	public function sms_sample_csv()
	{
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=sms_csv_sample.csv");
		$output = fopen("php://output", "w");
		fputcsv($output, array('Phonenumber'));
		$data['Phonenumber'] = array(
			'Phonenumber' => "0123456789",
		);
		foreach ($data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
	}

	public function send_multiple_link()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('user');
		}
		$cq_res = $this->Adminmodel->check_quota_expire();
		if ($cq_res !== false) {
			$db_email = $cq_res->email;
			if ($this->session->userdata('rr_admin') == "0") {
				$this->quota_send_mail_expire($db_email);
				$this->session->set_flashdata('err', 'Quota has expired. Request has been sent to admin for renewal');
			} else if ($this->session->userdata('rr_admin') == "1") {
				$this->session->set_flashdata('err', 'Quota has expired');
			}
		} else {
			$emaildata = $_POST['emaildata'];
			$subj = $_POST['subj'];
			$bdy = $_POST['bdy'];
			$num = count($emaildata);
			$qbl_res = $this->Adminmodel->quota_bal_length();
			if ($qbl_res->bal < $num) {
				$this->session->set_flashdata('err', 'Number of emails to be sent exceeds your remaining quota point of ' . $qbl_res->bal . ' .');
			} else {
				$mail_res = $this->send_multiple_link_email($emaildata, $subj, $bdy);
				if ($mail_res !== true) {
					$this->session->set_flashdata('err', $mail_res);
				} else {
					$res = $this->Usermodel->multiplemail_save_info($_POST['emaildata'], $_POST['subj'], $_POST['bdy'], $_POST['link_for']);
					if ($res !== true) {
						$this->session->set_flashdata('err', 'Error saving contacts to DATABASE.');
					} else {
						$length = count($emaildata);
						$cq_res = $this->Adminmodel->quota_update($length);
						if ($cq_res !== false) {
							$db_email = $cq_res->email;
							$this->quota_send_mail_expire($db_email);
							$this->session->set_flashdata('succ', 'Link sent successfully');
						} else {
							$this->session->set_flashdata('succ', 'Link sent successfully');
						}
					}
				}
			}
		}
	}

	public function send_multiple_link_email($emaildata, $subj, $bdy)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'mail.swachhsurvekshan.org';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'swachh22@swachhsurvekshan.org';
		$config['smtp_pass']    = 'C9aidcT&G=TJ';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$this->email->from('swachh22@swachhsurvekshan.org', 'Swachh Survekshan');
		$this->email->to(implode(",", $emaildata));
		$this->email->subject($subj);
		$this->email->message($bdy);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function sms_send_link()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('user');
		}
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|html_escape');
		$this->form_validation->set_rules('smsbdy', 'Body', 'required|trim|html_escape');
		$this->form_validation->set_rules('templateID', 'TemplateID', 'required|trim|html_escape');

		if ($this->form_validation->run() == FALSE) {
			$this->rating();
		} else {
			$cq_res = $this->Adminmodel->check_quota_expire();
			if ($cq_res !== false) {
				$db_email = $cq_res->email;
				if ($this->session->userdata('rr_admin') == "0") {
					$this->quota_send_mail_expire($db_email);
					$this->session->set_flashdata('err', 'Quota has expired. Request has been sent to admin for renewal');
					redirect('account');
				} else if ($this->session->userdata('rr_admin') == "1") {
					$this->session->set_flashdata('err', 'Quota has expired');
					redirect('account');
				}
			} else {
				$mobile = $this->input->post('mobile');
				$bdy = $this->input->post('smsbdy');
				$templateID = $this->input->post('templateID');

				$url = "http://savshka.in/api/pushsms?user=502893&authkey=926pJyyVe2aK&sender=SSURVE&mobile=" . $mobile . "&text=";
				$req = curl_init();
				$complete_url = $url . curl_escape($req, $bdy) . "&entityid=1001715674475461342&templateid=" . $templateID . "&rpt=1";
				curl_setopt($req, CURLOPT_URL, $complete_url);
				curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
				$result = curl_exec($req);

				$httpCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
				$Jresult = json_decode($result, true);
				// $httpCode = 44;

				if ($httpCode !== 200) {
					$this->session->set_flashdata('err', 'Error sending SMS. Error code ' . $httpCode);
					redirect('rating');
				} else {
					if ($Jresult['STATUS'] == "ERROR") {
						$this->session->set_flashdata('err', 'Error. ' . $Jresult['RESPONSE']['INFO']);
						redirect('rating');
					} else if ($Jresult['STATUS'] == "OK") {
						$res = $this->Usermodel->sms_save_info();
						if ($res === true) {
							$length = '1';
							$cq_res = $this->Adminmodel->quota_update($length);
							$this->session->set_flashdata('succ', $Jresult['RESPONSE']['INFO']);
							redirect('rating');
						}
					}
				}

				curl_close($req);
			}
		}
	}

	public function sms_importcsv()
	{
		$file_data = fopen($_FILES['sms_csv_file']['tmp_name'], 'r');
		fgetcsv($file_data);
		while ($row = fgetcsv($file_data)) {
			$data[] = array(
				'Phonenumber' => $row[0],
			);
		}
		echo json_encode($data);
	}

	public function multiple_sms_send_link()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('user');
		}

		$cq_res = $this->Adminmodel->check_quota_expire();
		if ($cq_res !== false) {
			$db_email = $cq_res->email;
			if ($this->session->userdata('rr_admin') == "0") {
				$this->quota_send_mail_expire($db_email);
				$this->session->set_flashdata('err', 'Quota has expired. Request has been sent to admin for renewal');
			} else if ($this->session->userdata('rr_admin') == "1") {
				$this->session->set_flashdata('err', 'Quota has expired');
			}
		} else {
			$mobiledata = $_POST['mobiledata'];
			$smsbdy = $_POST['smsbdy'];
			$templateid = $_POST['templateID'];
			$num = count($mobiledata);

			$qbl_res = $this->Adminmodel->quota_bal_length();
			if ($qbl_res->bal < $num) {
				$this->session->set_flashdata('err', 'Number of sms to be sent exceeds your remaining quota point of ' . $qbl_res->bal . ' .');
			} else {
				$notsentArr = array();
				$notsentstring = "<br>";
				$notsentFlag = null;

				foreach ($mobiledata as $mobile) {
					//API send to multiple No.
					$url = "http://savshka.in/api/pushsms?user=502893&authkey=926pJyyVe2aK&sender=SSURVE&mobile=" . $mobile . "&text=";
					$req = curl_init();
					$complete_url = $url . curl_escape($req, $smsbdy) . "&entityid=1001715674475461342&templateid=" . $templateid . "&rpt=1";
					curl_setopt($req, CURLOPT_URL, $complete_url);
					curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
					$result = curl_exec($req);

					$httpCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
					$Jresult = json_decode($result, true);
					// $httpCode = 44;

					if ($httpCode !== 200) {
						array_push($notsentArr, array("error" => $httpCode . " SERVER ERROR", "mobile" => $mobile));
						$notsentstring .= "Error- " . $httpCode . " SERVER ERROR, mobile- " . $mobile;
						$notsentFlag = true;
					} else {
						if ($Jresult['STATUS'] == "ERROR") {
							array_push($notsentArr, array("error" => $Jresult['RESPONSE']['CODE'] . " - " . $Jresult['RESPONSE']['INFO'], "mobile" => $mobile));
							$notsentstring .= "Error- " . $Jresult['RESPONSE']['CODE'] . " - " . $Jresult['RESPONSE']['INFO'] . ", Mobile- " . $mobile . "<br>";
							$notsentFlag = true;
						} else if ($Jresult['STATUS'] == "OK") {
							$res = $this->Usermodel->multiplsms_save_info($mobile, $smsbdy);
							if ($res === true) {
								$length = '1';
								$cq_res = $this->Adminmodel->quota_update($length);
							}
						}
					}

					curl_close($req);
				}

				if (count($notsentArr) < 0 || $notsentFlag !== null) {
					$this->session->set_flashdata('err', $notsentstring);
				} else {
					$this->session->set_flashdata('succ', 'SUBMITTED');
				}
				die;

				redirect('rating');
			}
		}
	}

	public function account()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('user');
		}
		$data['user'] = $this->Usermodel->user_total_ratings(); //all user total rating
		$data['userRating'] = $this->Usermodel->get_user_ratings(); //get all user rating
		$data['userToday'] = $this->Usermodel->user_total_ratings_today(); //all user rating
		$data['tr'] = $this->Usermodel->total_ratings(); //all rating
		$data['balance'] = $this->Usermodel->user_balance(); //quota detail
		$data['all_sms'] = $this->Usermodel->all_user_sms();
		$data['all_email'] = $this->Usermodel->all_user_email();
		$data['sent_links'] = $this->Usermodel->all_sent_links();
		//die(print_r($data['sent_links']));
		$this->load->view('templates/header');
		$this->load->view('users/account', $data);
		$this->load->view('templates/footer');
	}

	public function bar_data()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('user');
			exit();
		}
		$data['tl'] = $this->Usermodel->total_ratings();
		$data['links'] = $this->Usermodel->all_sent_links();
		// $data['tl1'] = $this->Usermodel->total_1();
		// $data['tl2'] = $this->Usermodel->total_2();
		// $data['tl3'] = $this->Usermodel->total_3();
		// $data['tl4'] = $this->Usermodel->total_4();
		// $data['tl5'] = $this->Usermodel->total_5();
		$data['tapp'] = $this->Usermodel->totalApp();
		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function user_bar_data()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('user');
			exit();
		}
		$data = $this->Usermodel->user_total_ratings();
		$data->token = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function get_key($key)
	{
		$form_key = $this->Usermodel->get_key($key);
		if (!$form_key) {
			return false;
		} else {
			return $form_key;
		}
	}

	public function rp($key)
	{
		if (!$key) {
			redirect($_SERVER['HTTP_REFERER']);
			exit();
		} else {
			$form_key = $this->get_key($key);
			if ($form_key !== $key) {
				//redirect($_SERVER['HTTP_REFERER']);
				exit();
			} elseif ($form_key == $key) {
				$data['form_key'] = $form_key;
				$this->load->view('users/rate_option', $data);
			}
		}
	}

	public function rate($key)
	{
		if (!$key) {
			redirect($_SERVER['HTTP_REFERER']);
			exit();
		} else {
			$form_key = $this->get_key($key);
			if ($form_key !== $key) {
				//redirect($_SERVER['HTTP_REFERER']);
				echo "Invalid Link";
				die;
			} elseif ($form_key == $key) {
				$data['form_key'] = $form_key;
				// $this->load->view('users/star_rate', $data);
				// $this->load->view('users/rate', $data);
				$this->load->view('users/swacch_rate', $data);
				$this->load->view('templates/footer');
			}
		}
	}

	public function question($key)
	{
		if (!$key) {
			redirect($_SERVER['HTTP_REFERER']);
			exit();
		} else {
			$form_key = $this->get_key($key);
			if ($form_key !== $key) {
				//redirect($_SERVER['HTTP_REFERER']);
				exit();
			} elseif ($form_key == $key) {
				$data['form_key'] = $form_key;
				$this->load->view('users/question_rate', $data);
				$this->load->view('templates/footer');
			}
		}
	}

	public function save_questions($key)
	{
		if (!$key) {
			redirect($_SERVER['HTTP_REFERER']);
			exit;
		} else {
			$cq_res = $this->Usermodel->save_questions($key);
			// $cq_res = true;
			if ($cq_res !== true) {
				$this->session->set_flashdata('ques_r_err', 'Error collecting your data');
				redirect($_SERVER['HTTP_REFERER']);
				exit;
			} else {
				$this->session->set_flashdata('ques_r_succ', 'Thanks for your feedback');
				redirect($_SERVER['HTTP_REFERER']);
				exit;
			}
		}
	}

	public function rating_store_review()
	{
		$cq_res = $this->Adminmodel->check_quota_expire();
		if ($cq_res !== false) {
			$db_email = $cq_res->email;
			$this->quota_send_mail_expire($db_email);
			return false;
		} else {
			$res = $this->Usermodel->rating_store_review($_POST['starv'], $_POST['msg'], $_POST['name'], $_POST['mobile'], $_POST['tbl_name'], $_POST['form_key']);
		}
	}

	public function support()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|html_escape');
		$this->form_validation->set_rules('msg', 'Message', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('users/contactus');
			$this->load->view('templates/footer');
		} else {
			$name = $this->input->post('name');
			$user_mail = $this->input->post('email');
			$bdy = $this->input->post('msg');
			$mail_res = $this->support_mail($name, $user_mail, $bdy);
			if ($mail_res !== true) {
				$this->session->set_flashdata('err', 'Error sending your message');
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				$this->session->set_flashdata('succ', 'Your message has been sent. We will get back to you as soon as possible');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

	public function support_mail($name, $user_mail, $bdy)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'mail.swachhsurvekshan.org';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'swachh22@swachhsurvekshan.org';
		$config['smtp_pass']    = 'C9aidcT&G=TJ';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		if ($user_mail) {
			$subj = "Support mail from " . $user_mail;
		} else if (!$user_mail) {
			$subj = "Support mail";
		}

		$this->email->from('swachh22@swachhsurvekshan.org', 'Swachh Survekshan');
		$this->email->to('olatayoefficient@gmail.com');
		$this->email->subject($subj);
		$this->email->message($bdy);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	//generate OTP for mobile entered
	public function gen_otp()
	{
		$res = $this->Usermodel->mobileExist($_POST['mobile']);
		if ($res === false) {
			if ($_POST['mobile'] && !empty($_POST['mobile'] && isset($_POST['mobile']))) {

				$url = "https://ss-cf-api.sbmurban.org/ss/api/cf/otp/" . htmlentities($_POST['mobile']);
				$req = curl_init();
				curl_setopt($req, CURLOPT_URL, $url);
				curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
				$cres = curl_exec($req);
				$httpCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
				$j_cres = json_decode($cres, true);

				if ($httpCode == 500) {
					$data['status'] = false;
					$data['msg'] = "Internal Server Error";
				} else if ($httpCode !== 200) {
					$data['status'] = false;
					$data['msg'] = "Check for OTP or Resend";
				} else {
					if ($j_cres['data'] == 'true' && $j_cres['status'] == 1) {
						$data['status'] = true;
						$data['msg'] = "OTP Sent";
					} else {
						$data['status'] = false;
						$data['msg'] = "Unable to send OTP";
					}
				}

				$data['j_cres'] = $j_cres;
				$data['httpCode'] = $httpCode;

				curl_close($req);
			} else {
				$data['msg'] = "Mobile number required";
				$data['status'] = false;
			}
		} else {
			$data['msg'] = "Mobile already associated with a submitted form";
			$data['status'] = false;
			$data['res'] = $res;
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}


	//send and save form
	public function save()
	{
		if (count($_POST) > 0) {
			$formData = array(
				"cf_date" => date("Y-m-d H:i:s"),
				"cf_response" => array(
					[
						"FQ1" => "Y",
						"FQ2" => "Y",
						"FQ3" => "Y",
						"FQ4" => "Y",
						"FQ5" => "Y",
						"FQ6" => "Y",
						"FQ7" => "Y",
						"FQ8" => "Y"
					]
				),
				"is_resident" => "Yes",
				"location_name" => $_POST['locationName'],
				"m_ulb_id" => $_POST['cityNameID'],
				"otp" => $_POST['otp'],
				"res_age" => $_POST['age'],
				"res_gender" => $_POST['sex'],
				"res_name" => $_POST['name'],
				"res_phone" => $_POST['mobile'],
				"res_title" => $_POST['nameTitle'],
				"ss_period" => date("Y"),
			);

			$formData_string = json_encode($formData);

			$req = curl_init();
			curl_setopt($req, CURLOPT_URL, "https://ss-cf-api.sbmurban.org/ss/api/cf/web/save");
			curl_setopt($req, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($req, CURLOPT_POSTFIELDS, $formData_string);
			curl_setopt(
				$req,
				CURLOPT_HTTPHEADER,
				array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($formData_string)
				)
			);
			$cres = curl_exec($req);
			$httpCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
			$j_cres = json_decode($cres, true);

			if ($httpCode == 500) {
				$data['status'] = false;
				$data['msg'] = "Internal Server Error";
			} else if ($httpCode !== 200) {
				$data['status'] = false;
				$data['msg'] = ($j_cres['message']) ? $j_cres['message'] : "";
			} else {
				if ($j_cres['status'] == 0) {
					$data['status'] = false;
					$data['msg'] = ($j_cres['message']) ? $j_cres['message'] : "";
				} else if ($j_cres['status'] == 1) {
					$store_res = $this->Usermodel->swacch_rating_store($_POST['starv'], $_POST['name'], $_POST['mobile'], $_POST['form_key']);

					$data['status'] = true;
					$data['msg'] = ($j_cres['message']) ? $j_cres['message'] : "";
				}
			}

			$data['j_cres'] = $j_cres;
			$data['httpCode'] = $httpCode;
			// $data['url_getinfo'] = curl_getinfo($req);

			curl_close($req);
		} else {
			$data['msg'] = "No data";
			$data['status'] = false;
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}
}
