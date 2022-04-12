<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
require_once(APPPATH . "libraries/paytm/config_paytm.php");
require_once(APPPATH . "libraries/paytm/encdec_paytm.php");

class Admin extends CI_Controller
{
	public function index()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('login');
			exit;
		}
		if ($this->session->userdata('rr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('login');
		}
		if ($this->session->userdata('rr_admin') == "1") {
			$this->votes();
		}
	}

	public function users($offset = 0)
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('login');
		}
		if ($this->session->userdata('rr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('login');
		}
		$config['base_url'] = base_url() . "admin/users/";
		$config['total_rows'] = $this->db->count_all('users');
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		$config['attributes'] = array('class' => 'page-link');
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();

		$data['users'] = $this->Adminmodel->get_user_details($config["per_page"], $offset);
		$this->load->view('templates/header');
		$this->load->view('admin/users', $data);
		$this->load->view('templates/footer');
	}

	public function votes($offset = 0)
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('login');
		}
		if ($this->session->userdata('rr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('login');
		}
		$config['base_url'] = base_url() . "admin/votes/";
		$config['total_rows'] = $this->db->count_all('user_details');
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		$config['attributes'] = array('class' => 'page-link');
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();

		$data['details'] = $this->Adminmodel->get_user_votes($config["per_page"], $offset);
		$this->load->view('templates/header');
		$this->load->view('admin/votes', $data);
		$this->load->view('templates/footer');
	}

	public function add_user()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('login');
		}
		if ($this->session->userdata('rr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('login');
		}
		$this->form_validation->set_rules('full_name', 'Username', 'required|trim|html_escape|is_unique[users.full_name]');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|html_escape');
		$this->form_validation->set_rules('eid', 'Employee ID', 'trim|html_escape');
		$this->form_validation->set_rules('dept', 'Department', 'trim|html_escape');
		$this->form_validation->set_rules('password', 'Password', 'trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$data['details'] = $this->Adminmodel->get_user_details();
			$data['users'] = $this->Adminmodel->get_user_details(false, false);

			$this->load->view('templates/header');
			$this->load->view('admin/users', $data);
			$this->load->view('templates/footer');
		} else {
			$form_key =  mt_rand(0, 10000) . substr($this->input->post('mobile'), -4);
			$randpwd = ($this->input->post('password') ? $this->input->post('password') : mt_rand(0, 10000000));
			$pwd = password_hash($randpwd, PASSWORD_DEFAULT);

			$fname = htmlentities($this->input->post('full_name'));
			$email = htmlentities($this->input->post('email'));
			$mobile = $this->input->post('mobile');
			$link = base_url() . "rate/" . $form_key;
			$login_link = base_url();

			$mailRes = $mobileRes = null; //default values

			if (isset($_POST['mail_chkbox'])) {
				//send mail
				$mailRes = $this->send_succ($fname, $randpwd, $email, $link, $login_link);
				// $mailRes = true;
			}
			if (isset($_POST['mobile_chkbox'])) {
				$bdy = "Hello " . $fname . "\n\nBelow are your login details :\nUsername: " . $fname . "\nPassword: " . $randpwd . "\nLink: " . $link . "\nShare the above link to collect Feedbacks.\r\nNIPL";
				$url = "http://savshka.in/api/pushsms?user=502893&authkey=926pJyyVe2aK&sender=SSURVE&mobile=" . $mobile . "&text=";
				$req = curl_init();
				$complete_url = $url . curl_escape($req, $bdy) . "&entityid=1001715674475461342&templateid=1007838850146399750&rpt=1";
				curl_setopt($req, CURLOPT_URL, $complete_url);
				curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
				$result = curl_exec($req);

				$httpCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
				$Jresult = json_decode($result, true);

				if ($httpCode !== 200) {
					$mobileRes = 'Error sending SMS. Error code ' . $httpCode;
				} else {
					if ($Jresult['STATUS'] == "ERROR") {
						$mobileRes = 'Error sending SMS. ' . $Jresult['RESPONSE']['INFO'];
					} else if ($Jresult['STATUS'] == "OK") {
						$mobileRes = true;
					}
				}

				curl_close($req);
				$mailRes = true;
			}

			//handle Error
			if ($mailRes !== true) {
				$this->session->set_flashdata('err', $mailRes);
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				$regRes = $this->Usermodel->register($form_key, $pwd);

				if ($regRes === true) {
					$this->session->set_flashdata('succ', 'User Added');
					redirect($_SERVER['HTTP_REFERER']);
				} else {
					$this->session->set_flashdata('err', 'Registration Failed');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
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
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$data = array(
			'fname' => $fname,
			'randpwd' => $randpwd,
			'link' => $link,
			'login_link' => $login_link,
		);
		$body = "Hello " . $fname . "\n\nBelow are your login credentails:\nUsername: " . $fname . "\nPassword: " . $randpwd . "\nLink: " . $link . "\nShare the above link to get reviews.\nYou can login here " . $login_link . "\n\nIf you have any questions, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

		$this->email->from('swachh22@swachhsurvekshan.org', 'Swachh Survekshan');
		$this->email->to($email);
		$this->email->subject("Login Credentials");
		$this->email->message($body);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		};
	}

	public function get_user()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect($_SERVER['HTTP_REFERER']);
		}
		if ($this->session->userdata('rr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$output = array();
			$data = $this->Adminmodel->get_user($_POST['user_id']);
			foreach ($data as $row) {
				$output['id'] = $row->id;
				$output['u_fname'] = $row->full_name;
				$output['u_email'] = $row->email;
				$output['u_mobile'] = $row->mobile;
				$output['u_link'] =  base_url() . "rate/" . $row->form_key;
				$output['form_key'] =  $row->form_key;
				$output['u_eid'] = $row->eid;
				$output['u_dept'] = $row->dept;
				$output['token'] = $this->security->get_csrf_hash();
			}
			echo json_encode($output);
		}
	}

	public function votes_get_user()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('login');
		}
		if ($this->session->userdata('rr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('login');
		} else {
			$data['users'] = $this->Adminmodel->get_ratings($_POST['key']);
			$data['token'] = $this->security->get_csrf_hash();
			echo json_encode($data);
		}
	}

	public function update_user()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('login');
		}
		if ($this->session->userdata('rr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('login');
		} else {
			$data = $this->Adminmodel->update_user($_POST['user_id']);
			$this->session->set_flashdata('succ', 'User details updated');
		}
	}

	public function delete_user()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('login');
		}
		if ($this->session->userdata('rr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('login');
		} else {
			$res = $this->Adminmodel->delete_user($_POST['user_id'], $_POST['form_key']);
			$this->session->set_flashdata('succ', 'User deleted');
		}
	}

	public function pick_plan()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('login');
		}
		if ($this->session->userdata('rr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			//redirect('login');
			redirect($_SERVER['HTTP_REFERER']);
		}
		$this->load->view('templates/header');
		$this->load->view('admin/pick_plan');
		$this->load->view('templates/footer');
	}

	public function save_plan()
	{
		$checkSum = "";
		$data = array();

		$data["MID"] = PAYTM_MERCHANT_MID;
		$data["CUST_ID"] = $this->session->userdata('rr_id');
		$data["ORDER_ID"] = mt_rand(0, 10000000);
		$data["INDUSTRY_TYPE_ID"] = "Retail";
		$data["CHANNEL_ID"] = "WEB";
		$data["TXN_AMOUNT"] = $this->input->post('plan_amount');
		$data["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
		$data["CALLBACK_URL"] = base_url("admin/pgResponses");

		$checkSum = getChecksumFromArray($data, PAYTM_MERCHANT_KEY);
		$this->load->view('templates/header');
		$this->load->view('admin/pgresponse', ['paytm_info' => $data, 'checkSum' => $checkSum]);
		$this->load->view('templates/footer');
	}

	public function pgResponses()
	{
		$paytmChecksum = "";
		$paramList = array();
		$isValidChecksum = "FALSE";
		$paramList = $_POST;
		$user_id = $this->session->userdata('rr_id');
		$form_key = $this->session->userdata('rr_form_key');

		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : "";
		$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum);
		$userData = array(
			'm_id' => $_POST['MID'],
			'txn_id' => "",
			'order_id' => $_POST['ORDERID'],
			'currency' => $_POST['CURRENCY'],
			'paid_amt' => $_POST['TXNAMOUNT'],
			'payment_mode' => "",
			'gateway_name' => "",
			'bank_txn_id' => "",
			'bank_name' => "",
			'status' => $_POST['STATUS'],
		);
		if ($isValidChecksum == "TRUE") {
			if ($_POST["STATUS"] == "TXN_SUCCESS") {
				if (isset($_POST) && count($_POST) > 0) {
					if ($_POST['TXNAMOUNT'] == "25000") {
						$quota_amount = "25000";
					} elseif ($_POST['TXNAMOUNT'] == "50000") {
						$quota_amount = "75000";
					} elseif ($_POST['TXNAMOUNT'] == "100000") {
						$quota_amount = "200000";
					} elseif ($_POST['TXNAMOUNT'] == "500000") {
						$quota_amount = "1250000";
					}
					$userData = array(
						'quota_bought' => $quota_amount,
						'm_id' => $_POST['MID'],
						'txn_id' => $_POST['TXNID'],
						'order_id' => $_POST['ORDERID'],
						'currency' => $_POST['CURRENCY'],
						'paid_amt' => $_POST['TXNAMOUNT'],
						'payment_mode' => $_POST['PAYMENTMODE'],
						'gateway_name' => $_POST['GATEWAYNAME'],
						'bank_txn_id' => $_POST['BANKTXNID'],
						'bank_name' => $_POST['BANKNAME'],
						'check_sum_hash' => $_POST['CHECKSUMHASH'],
						'status' => $_POST['STATUS'],
					);
					$res = $this->Adminmodel->save_payment($userData);
					// $res = true;
					if ($res == true) {
						$this->session->set_flashdata('succ', 'Payment Done.');
						//$this->payment_status($userData);
						$this->load->view('templates/header');
						$this->load->view('admin/pay_status', ['userData' => $userData]);
						$this->load->view('templates/footer');
					} else {
						$this->session->set_flashdata('err', 'Error saving contacts to DATABASE.');
						$this->load->view('templates/header');
						$this->load->view('admin/pay_status', ['userData' => $userData]);
						$this->load->view('templates/footer');
					}
				} else {
					$this->session->set_flashdata('err', 'Payment Failed.');
					$this->load->view('templates/header');
					$this->load->view('admin/pay_status', ['userData' => $userData]);
					$this->load->view('templates/footer');
				}
			} else {
				$this->session->set_flashdata('err', 'Payment Failed.');
				$this->load->view('templates/header');
				$this->load->view('admin/pay_status', ['userData' => $userData]);
				$this->load->view('templates/footer');
			}
		} else {
			$this->session->set_flashdata('err', 'Payment Failed.');
			$this->load->view('templates/header');
			$this->load->view('admin/pay_status', ['userData' => $userData]);
			$this->load->view('templates/footer');
		}
	}

	public function feedbacks()
	{
		if (!$this->session->userdata('rr_logged_in')) {
			$this->session->set_flashdata('err', 'Please login first');
			redirect('login');
		}
		if ($this->session->userdata('rr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('login');
		}
		$data['r_reviews'] = $this->Adminmodel->r_feedback_reviews();
		$data['q_reviews'] = $this->Adminmodel->q_feedback_reviews();
		$this->load->view('templates/header');
		$this->load->view('admin/feedbacks', $data);
		$this->load->view('templates/footer');
	}
}
