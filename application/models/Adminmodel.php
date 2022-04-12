<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adminmodel extends CI_Model
{
	public function get_user_details($limit = false, $offset = false)
	{
		// $this->db->limit($limit, $offset);
		$query = $this->db->get('users');
		return $query;
	}

	public function get_user_votes($limit = false, $offset = false)
	{
		// $this->db->limit($limit, $offset);
		$query = $this->db->get('user_details');
		return $query;
	}

	public function get_ratings($key)
	{
		$this->db->order_by('id', 'desc');
		$this->db->where('c_id', $key);
		$query = $this->db->get('mainweb_rating');
		return $query->result_array();
	}

	public function get_user($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('users');
		return $query->result();
	}

	public function votes_get_user($id)
	{
		$this->db->where('user_id', $id);
		$query = $this->db->get('user_details');
		return $query->result_array();
	}

	public function upate_password($fname, $randpwd, $email, $link, $login_link, $mobile)
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

		$body = "Hello " . $fname . "\n\nBelow are your new login credentails:\nUsername: " . $fname . "\nPassword: " . $randpwd . "\nLink: " . $link . "\nShare the above link to get reviews.\nYou can login here " . $login_link . "\n\nIf you have any questions, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

		$this->email->from('swachh22@swachhsurvekshan.org','Swachh Survekshan');
		$this->email->to($email);
		$this->email->subject("New credentails");
		$this->email->message($body);

		$this->email->send();

		// $url = "http://onextelbulksms.in/shn/api/pushsms.php?usr=621665&key=010BrbJ20v1c2eCc8LGih6RlTIGqKN&sndr=KARUNJ&ph=+91" . $mobile . "&text=";

		// $req = curl_init();
		// $complete_url = $url . curl_escape($req, $body) . "&rpt=1";
		// curl_setopt($req, CURLOPT_URL, $complete_url);
		// $result = curl_exec($req);
	}

	public function update_user($id)
	{
		if ($this->input->post('u_pwd')) {
			$fname = htmlentities($this->input->post('u_fname'));
			$email = htmlentities($this->input->post('u_email'));
			$mobile = htmlentities($this->input->post('u_mobile'));
			$randpwd = $this->input->post('u_pwd');
			$link = base_url() . "user/rate/" . htmlentities($this->input->post('u_link'));

			$login_link = base_url();
			$this->upate_password($fname, $randpwd, $email, $link, $login_link, $mobile);
			
			if ($this->input->post('deptselect') == "Admin") {
				$data = array(
					'admin' => "1",
					'email' => htmlentities($this->input->post('u_email')),
					'mobile' => htmlentities($this->input->post('u_mobile')),
					'eid' => htmlentities($this->input->post('u_eid')),
					'dept' => htmlentities($this->input->post('deptselect')),
					'password' => password_hash($this->input->post('u_pwd'), PASSWORD_DEFAULT)
				);
				$this->db->where('id', $id);
				$this->db->update('users', $data);
				return TRUE;
				exit;
			} elseif ($this->input->post('deptselect') == "Staff") {
				$data = array(
					'admin' => "0",
					'email' => htmlentities($this->input->post('u_email')),
					'mobile' => htmlentities($this->input->post('u_mobile')),
					'eid' => htmlentities($this->input->post('u_eid')),
					'dept' => htmlentities($this->input->post('deptselect')),
					'password' => password_hash($this->input->post('u_pwd'), PASSWORD_DEFAULT)
				);
				$this->db->where('id', $id);
				$this->db->update('users', $data);
				return TRUE;
				exit();
			}
		} else {
			if ($this->input->post('deptselect') == "Admin") {
				$data = array(
					'admin' => "1",
					'email' => htmlentities($this->input->post('u_email')),
					'mobile' => htmlentities($this->input->post('u_mobile')),
					'eid' => htmlentities($this->input->post('u_eid')),
					'dept' => htmlentities($this->input->post('deptselect')),
				);
				$this->db->where('id', $id);
				$this->db->update('users', $data);
				return TRUE;
				exit;
			} elseif ($this->input->post('deptselect') == "Staff") {
				$data = array(
					'admin' => "0",
					'email' => htmlentities($this->input->post('u_email')),
					'mobile' => htmlentities($this->input->post('u_mobile')),
					'eid' => htmlentities($this->input->post('u_eid')),
					'dept' => htmlentities($this->input->post('deptselect')),
				);
				$this->db->where('id', $id);
				$this->db->update('users', $data);
				return TRUE;
				exit();
			}
		}
	}

	public function update_user_admin($id, $name)
	{
		$data = array(
			'name' => $name
		);
		$this->db->where('user_id', $id);
		$this->db->update('user_details', $data);
		return true;
	}

	public function delete_user($id, $form_key)
	{
		$this->db->where('id', $id);
		$this->db->delete('users');
		$this->delete_user_admin($id);
		$this->delete_user_ratings($form_key);
		return true;
	}

	public function delete_user_admin($id)
	{
		$this->db->where('user_id', $id);
		$this->db->delete('user_details');
		return true;
	}

	public function delete_user_ratings($form_key)
	{
		$this->db->where('c_id', $form_key);
		$this->db->delete('mainweb_rating');
		return true;
	}

	public function save_payment($userData)
	{
		$this->db->insert('payment', $userData);
		$quota_amount = round($userData['quota_bought']);
		$this->save_plan($quota_amount);
		$this->session->set_userdata('rr_sub', '1');
		return true;
	}

	public function save_plan($quota_amount)
	{
		$this->db->set('bought', 'bought+' . $quota_amount, FALSE);
		$this->db->set('bal', 'bal+' . $quota_amount, FALSE);
		$this->db->set('by_form_key', $this->session->userdata('rr_form_key'));
		$this->db->set('by_user_id', $this->session->userdata('rr_id'));
		$this->db->set('sub', '1', FALSE);
		$this->db->where('id', '0');
		$this->db->update("quota");
		return true;
	}

	public function quota_update($length)
	{
		$this->db->set('used', 'used+' . $length, FALSE);
		$this->db->set('bal', 'bal-' . $length, FALSE);
		$this->db->where('id', '0');
		$this->db->update('quota');
		$data = $this->check_quota_expire();
		return $data;
		exit;
	}

	public function sub_update()
	{
		$this->db->set('sub', '0');
		$this->db->set('bal', '0');
		$this->db->where('id', '0');
		$this->db->update('quota');
		$this->session->set_userdata('rr_sub', '0');
		return true;
	}

	public function check_quota_expire()
	{
		$query = $this->db->get_where('quota', array('id' => '0'))->row();
		if ($query->bal == '0' || $query->bal < '0') {
			$this->sub_update();
			$all_admin = $this->db->get_where('users', array('s_admin' => '1'))->row();
			return $all_admin;
			exit;
		} else {
			return false;
		}
	}

	public function quota_bal_length()
	{
		$query = $this->db->get_where('quota', array('id' => '0'))->row();
		if ($query) {
			return $query;
			exit;
		} else {
			return false;
			exit;
		}
	}

	public function emailsms_export_csv()
	{
		$this->db->order_by('id', 'desc');
		$this->db->select('id,mobile,email,subj,body,link_for,user_id,sent_at');
		$query = $this->db->get('sent_links');
		return $query->result_array();
	}

	public function r_feedback_reviews(){
		$query= $this->db->get('mainweb_rating');
		return $query;
	}

	public function q_feedback_reviews(){
		$query= $this->db->get('question_rating');
		return $query;
	}
}
