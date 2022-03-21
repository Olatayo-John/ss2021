<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usermodel extends CI_Model
{
	public function login()
	{
		$uname = $this->input->post('uname');
		$pwd = $this->input->post('pwd');

		$user = $this->db->get_where('users', array('full_name' => $uname))->row();
		if (!$user) {
			return false;
			exit();
		}
		if ($user) {
			$verifypwd = password_verify($pwd, $user->password);
			if ($verifypwd == 0) {
				return false;
				exit();
			} elseif ($verifypwd == 1) {
				return $user;
			}
		}
	}

	public function get_admin_sub()
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

	public function register($form_key, $pwd)
	{
		if ($this->input->post('dept') == "Staff") {
			$data = array(
				'admin' => '0',
				's_admin' => '0',
				'full_name' => htmlentities($this->input->post('full_name')),
				'email' => htmlentities($this->input->post('email')),
				'mobile' => htmlentities($this->input->post('mobile')),
				'eid' => htmlentities($this->input->post('eid')),
				'dept' => htmlentities($this->input->post('dept')),
				'form_key' => $form_key,
				'password' => $pwd,
			);
			$this->db->insert('users', $data);
			$lastid = $this->db->insert_id();
			$this->insert_user_details($lastid, $form_key);
			return TRUE;
		} else {
			$data = array(
				'admin' => '1',
				'full_name' => htmlentities($this->input->post('full_name')),
				'email' => htmlentities($this->input->post('email')),
				'mobile' => htmlentities($this->input->post('mobile')),
				'eid' => htmlentities($this->input->post('eid')),
				'dept' => htmlentities($this->input->post('dept')),
				'form_key' => $form_key,
				'password' => $pwd,
			);
			$this->db->insert('users', $data);
			$lastid = $this->db->insert_id();
			$this->insert_user_details($lastid, $form_key);
			return TRUE;
		}
	}

	public function insert_user_details($lastid, $form_key)
	{
		$data = array(
			'user_id' => $lastid,
			'form_key' => $form_key,
			'name' => $this->input->post('full_name'),
			'total_links' => '0',
			'sms' => '0',
			'email' => '0',
			'5_star' => '0',
			'4_star' => '0',
			'3_star' => '0',
			'2_star' => '0',
			'1_star' => '0',
		);
		$this->db->insert('user_details', $data);
		return true;
	}

	public function get_info()
	{
		$query = $this->db->get_where('users', array('id' => $this->session->userdata('rr_id')))->row();
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
	}

	public function edit()
	{
		$data = array(
			'email' => $this->input->post('email'),
			'mobile' => $this->input->post('mobile'),
			'eid' => $this->input->post('eid'),
		);
		$this->db->where('id', $this->session->userdata('rr_id'));
		$this->db->update('users', $data);
		$name = htmlentities($this->input->post('full_name'));
		$this->update_user_details($name);
		return TRUE;
	}

	public function update_user_details($name)
	{
		$data = array(
			'name' => $name
		);
		$this->db->where('user_id', $this->session->userdata('rr_id'));
		$this->db->update('user_details', $data);
		return true;
	}

	public function get_link($id)
	{
		$query = $this->db->get_where('users', array('id' => $id))->row();
		if (!$query) {
			return false;
			exit();
		}
		if ($query) {
			return $query;
			exit();
		}
	}

	public function downloadApp()
	{
		$data = array(
			'ip' => $_SERVER['REMOTE_ADDR'],
		);
		$this->db->insert('apphit', $data);
		return true;
	}

	public function save_info()
	{
		$data = array(
			'link_for' => htmlentities($this->input->post('link_for')),
			'email' => htmlentities($this->input->post('email')),
			'subj' => htmlentities($this->input->post('subj')),
			'body' => htmlentities($this->input->post('bdy')),
			'user_id' => $this->session->userdata('rr_id'),
		);
		$this->db->insert('sent_links', $data);
		$this->email_update();
		return true;
	}

	public function email_update()
	{
		$this->db->set('email', 'email+1', FALSE);
		$this->db->where('form_key', $this->session->userdata('rr_form_key'));
		$this->db->update('user_details');
		return true;
	}

	public function multiplemail_save_info($emaildata, $subj, $bdy, $link_for)
	{
		$data = array(
			'link_for' => htmlentities($link_for),
			'email' => htmlentities(implode(",", $emaildata)),
			'subj' => htmlentities($subj),
			'body' => htmlentities($bdy),
			'user_id' => $this->session->userdata('rr_id'),
		);
		$num = count($emaildata);
		$this->db->insert('sent_links', $data);
		$this->multiple_email_update($num);
		return true;
	}

	public function multiple_email_update($num)
	{
		$this->db->set('email', 'email+' . $num, FALSE);
		$this->db->where('form_key', $this->session->userdata('rr_form_key'));
		$this->db->update('user_details');
		return true;
	}

	public function sms_save_info()
	{
		$data = array(
			'link_for' => htmlentities($this->input->post('link_for')),
			'mobile' => htmlentities($this->input->post('mobile')),
			'body' => htmlentities($this->input->post('smsbdy')),
			'user_id' => $this->session->userdata('rr_id'),
		);
		$this->db->insert('sent_links', $data);
		$this->sms_update();
		return true;
	}

	public function sms_update()
	{
		$this->db->set('sms', 'sms+1', FALSE);
		$this->db->where('form_key', $this->session->userdata('rr_form_key'));
		$this->db->update('user_details');
		return true;
	}

	public function multiplsms_save_info($mobiledata, $smsbdy, $link_for)
	{
		$data = array(
			'link_for' => htmlentities($link_for),
			'mobile' => htmlentities(implode(",", $mobiledata)),
			'body' => htmlentities($smsbdy),
			'user_id' => $this->session->userdata('rr_id'),
		);
		$num = count($mobiledata);
		$this->db->insert('sent_links', $data);
		$this->multiple_sms_update($num);
		return true;
	}

	public function multiple_sms_update($num)
	{
		$this->db->set('sms', 'sms+' . $num, FALSE);
		$this->db->where('form_key', $this->session->userdata('rr_form_key'));
		$this->db->update('user_details');
		return true;
	}

	public function update_total_links()
	{
		$this->db->set('total_links', 'total_links+1', FALSE);
		$this->db->where('user_id', $this->session->userdata('rr_id'));
		$this->db->update('user_details');
		return true;
	}

	public function totalApp()
	{
		$query = $this->db->get('apphit');
		return $query->num_rows();
	}
	public function total_ratings()
	{
		$query = $this->db->get('mainweb_rating');
		return $query->num_rows();
	}
	public function total_5()
	{
		$query = $this->db->get_where('mainweb_rating', array("star" => "5"));
		return $query->num_rows();
	}
	public function total_4()
	{
		$query = $this->db->get_where('mainweb_rating', array("star" => "4"));
		return $query->num_rows();
	}
	public function total_3()
	{
		$query = $this->db->get_where('mainweb_rating', array("star" => "3"));
		return $query->num_rows();
	}
	public function total_2()
	{
		$query = $this->db->get_where('mainweb_rating', array("star" => "2"));
		return $query->num_rows();
	}
	public function total_1()
	{
		$query = $this->db->get_where('mainweb_rating', array("star" => "1"));
		return $query->num_rows();
	}

	public function user_total_ratings()
	{
		$query = $this->db->get_where('user_details', array('form_key' => $this->session->userdata('rr_form_key')));
		return $query->result_array();
	}

	public function all_user_sms()
	{
		$this->db->select_sum('sms');
		$query = $this->db->get('user_details');
		return $query->result();
	}

	public function all_user_email()
	{
		$this->db->select_sum('email');
		$query = $this->db->get('user_details');
		return $query->result();
	}

	public function user_balance()
	{
		$query = $this->db->get_where('quota', array('id' => '0'))->row();
		return $query;
	}

	public function all_sent_links()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get_where('sent_links');
		return $query->result();
	}

	public function get_key($key)
	{
		$query = $this->db->get_where('users', array("form_key" => $key))->row();
		if ($query) {
			return $query->form_key;
		}
	}

	public function save_questions($key)
	{
		$data = array(
			'form_key' => $key,
			'q_one' => htmlentities($this->input->post('ques_one')),
			'q_two' => htmlentities($this->input->post('ques_two')),
			'q_three' => htmlentities($this->input->post('ques_three')),
			'q_four' => htmlentities($this->input->post('ques_four')),
			'q_five' => htmlentities($this->input->post('ques_five')),
			'q_six' => htmlentities($this->input->post('ques_six')),
			'q_seven' => htmlentities($this->input->post('ques_seven')),
			'user_ip' => $_SERVER['REMOTE_ADDR'],
		);
		$this->db->insert('question_rating', $data);
		// $this->save_rating($starv, $form_key);
		// $this->quota_update();
		return TRUE;
	}

	public function mobileExist($mobile)
	{
		$query = $this->db->get_where("mainweb_rating", array('mobile' => $mobile));
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function rating_store_review($starv, $msg, $name, $mobile, $tbl_name, $form_key)
	{
		$data = array(
			'user_ip' => $_SERVER['REMOTE_ADDR'],
			'star' => $starv,
			'review_msg' => $msg,
			'name' => $name,
			'mobile' => $mobile,
			'c_id' => $form_key,
		);
		$this->db->insert($tbl_name, $data);
		$this->save_rating($starv, $form_key);
		$this->quota_update();
		return TRUE;
	}

	public function save_rating($starv, $form_key)
	{
		if ($starv == "5") {
			$this->db->set('5_star', '5_star+1', FALSE);
			$this->db->set('total_links', 'total_links+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "4") {
			$this->db->set('4_star', '4_star+1', FALSE);
			$this->db->set('total_links', 'total_links+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "3") {
			$this->db->set('3_star', '3_star+1', FALSE);
			$this->db->set('total_links', 'total_links+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "2") {
			$this->db->set('2_star', '2_star+1', FALSE);
			$this->db->set('total_links', 'total_links+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "1") {
			$this->db->set('1_star', '1_star+1', FALSE);
			$this->db->set('total_links', 'total_links+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
	}

	public function quota_update()
	{
		$this->db->set('used', 'used+1', FALSE);
		$this->db->set('bal', 'bal-1', FALSE);
		$this->db->where('id', '0');
		$this->db->update('quota');
		return true;
		exit;
	}

	//swacch rating 
	public function swacch_rating_store($starv, $name, $mobile, $form_key)
	{
		$data = array(
			'user_ip' => $_SERVER['REMOTE_ADDR'],
			'star' => htmlentities($starv),
			'review_msg' => "",
			'name' => htmlentities($name),
			'mobile' => htmlentities($mobile),
			'c_id' => htmlentities($form_key),
		);
		$this->db->insert("mainweb_rating", $data);
		$this->rating_store_UD($form_key);
		$this->quota_update();
		return TRUE;
	}

	public function rating_store_UD($form_key)
	{
		$this->db->set('total_links', 'total_links+1', FALSE);
		$this->db->where('form_key', $form_key);
		$this->db->update('user_details');
		return true;
		exit;
	}
}
