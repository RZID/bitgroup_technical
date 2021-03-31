<?php
defined("BASEPATH") or exit("No direct script access allowed");

class App extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("film");
	}
	public function index()
	{
		$data = ["title" => "Home", "currentPage" => "index"];
		$this->load->view("components/header", $data);
		$this->load->view("index");
		$this->load->view("components/modal");
		$this->load->view("components/footer");
	}
	public function detail()
	{
		if (!$this->input->get("id")) {
			return redirect("/");
		} else {
			if (
				$this->film
					->detailFilm([
						"id" => htmlspecialchars($this->input->get("id")),
					])
					->num_rows() > 0
			) {
				$data = [
					"title" => "Detail",
					"currentPage" => "detail",
					"id" => htmlspecialchars($this->input->get("id")),
				];
				$this->load->view("components/header", $data);
				$this->load->view("detail");
				$this->load->view("components/footer");
			} else {
				return redirect("/");
			}
		}
	}
	public function update()
	{
		if ($this->input->get("id")) {
			if (
				$this->film
					->detailFilm([
						"id" => htmlspecialchars($this->input->get("id")),
					])
					->num_rows() > 0
			) {
				$data = [
					"title" => "Detail",
					"currentPage" => "detail",
					"id" => htmlspecialchars($this->input->get("id")),
				];
				$this->load->view("components/header", $data);
				$this->load->view("update");
				$this->load->view("components/footer");
			} else {
				return redirect("/");
			}
		} else {
			return redirect("/");
		}
	}
}
