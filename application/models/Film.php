<?php

class Film extends CI_Model
{
	function addFilm($arr_of_data)
	{
		return $this->db->insert("films", $arr_of_data);
	}
	function addCategory($arr_of_data)
	{
		return $this->db->insert("categories", $arr_of_data);
	}
	function addActor($arr_of_data)
	{
		return $this->db->insert("actors", $arr_of_data);
	}
	function getWhereCategory($arr_of_data)
	{
		return $this->db->get_where("categories", $arr_of_data);
	}
	function getWhereActor($arr_of_data)
	{
		return $this->db->get_where("actors", $arr_of_data);
	}
	function batchInsertActor($arr_of_data)
	{
		foreach ($arr_of_data as $row) {
			if ($this->db->get_where("film_actor", $row)->num_rows() == 0) {
				$this->db->insert("film_actor", $row);
			}
		}
	}
	function batchInsertCategory($arr_of_data)
	{
		foreach ($arr_of_data as $row) {
			if ($this->db->get_where("film_category", $row)->num_rows() == 0) {
				$this->db->insert("film_category", $row);
			}
		}
	}
	function detailFilm($arr_of_data)
	{
		return $this->db->get_where("films", $arr_of_data);
	}
	function detailActor($arr_of_data)
	{
		return $this->db->get_where("actors", $arr_of_data);
	}
	function detailCategory($arr_of_data)
	{
		return $this->db->get_where("categories", $arr_of_data);
	}
	function deleteFilm($arr_of_data)
	{
		return $this->db->delete("films", $arr_of_data);
	}
	function deleteHookedActors($arr_of_data)
	{
		return $this->db->delete("film_actor", $arr_of_data);
	}
	function deleteHookedCategories($arr_of_data)
	{
		return $this->db->delete("film_category", $arr_of_data);
	}
	function getFilm()
	{
		return $this->db->get("films")->result_array();
	}
	function getFilmActors($arr_of_data)
	{
		return $this->db
			->join("actors", "actors.id = film_actor.actor_id", "left")
			->get_where("film_actor", $arr_of_data)
			->result_array();
	}
	function getFilmActorName($arr_of_data)
	{
		return $this->db
			->select("name")
			->join("actors", "actors.id = film_actor.actor_id", "left")
			->get_where("film_actor", $arr_of_data)
			->result_array();
	}
	function getFilmCategories($arr_of_data)
	{
		return $this->db
			->join(
				"categories",
				"categories.id = film_category.category_id",
				"left"
			)
			->get_where("film_category", $arr_of_data)
			->result_array();
	}
	function getFilmDetail($id)
	{
		return $this->db->get_where("films", $id)->result_array();
	}
	function getAllCategories()
	{
		return $this->db->get("categories");
	}
	function getAllActors()
	{
		return $this->db->get("actors");
	}
	function updateFilm($arr_of_data, $id)
	{
		$this->db->set($arr_of_data);
		$this->db->where($id);
		return $this->db->update("films");
	}
	function top_5_category()
	{
		return $this->db
			->join(
				"categories",
				"categories.id = film_category.category_id",
				"left"
			)
			->select(
				"categories.name as category_name, count(category_id) AS total_film"
			)
			->group_by("category_id")
			->order_by("total_film", "DESC")
			->limit(5)
			->get_where("film_category");
	}
	function top_5_favorite_film()
	{
		return $this->db
			->order_by("rental_rate", "DESC")
			->limit(5)
			->get("films");
	}
	function top_3_favorite_film()
	{
		return $this->db
			->order_by("rental_rate", "DESC")
			->limit(3)
			->get("films");
	}
}
