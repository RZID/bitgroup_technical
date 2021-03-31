<?php
use chriskacerguis\RestServer\RestController;

defined("BASEPATH") or exit("No direct script access allowed");

class Api extends RestController
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("film");
	}
	public function film_post()
	{
		if (
			$this->input->post("title") &&
			strlen($this->input->post("release")) == 4 &&
			is_numeric($this->input->post("release")) &&
			$this->input->post("description") &&
			is_numeric($this->input->post("rental_rate"))
		) {
			$arr_of_data = [
				"title" => htmlspecialchars($this->input->post("title")),
				"release_year" => htmlspecialchars(
					$this->input->post("release")
				),
				"description" => htmlspecialchars(
					$this->input->post("description")
				),
				"rental_rate" => htmlspecialchars(
					$this->input->post("rental_rate")
				),
			];
			if ($this->film->addFilm($arr_of_data)) {
				return $this->response(
					[
						"message" => "Success!",
					],
					201
				);
			} else {
				$this->response(
					[
						"message" => "Oops, we had trouble : ",
						"trace_error" => $this->db->error(),
					],
					500
				);
			}
		} else {
			$this->response(
				[
					"message" =>
						"Please fill all of input and give a valid value! There are required!",
				],
				422
			);
		}
	}
	public function genre_post()
	{
		if (is_numeric($this->input->post("genre"))) {
			$arr_of_data = [
				"name" => htmlspecialchars($this->input->post("genre")),
			];

			if ($this->film->getWhereCategory($arr_of_data)->num_rows() > 0) {
				$this->response(
					["message" => "That category already exist!"],
					409
				);
			} else {
				if ($this->film->addCategory($arr_of_data)) {
					$this->response(
						[
							"message" => "Success!",
						],
						201
					);
				} else {
					$this->response(
						[
							"message" => "Oops, we had trouble : ",
							"trace_error" => $this->db->error(),
						],
						500
					);
				}
			}
		} else {
			return $this->response(
				[
					"message" =>
						"Please fill all of input and give a valid value! There are required!",
				],
				422
			);
		}
	}
	public function actor_post()
	{
		if (is_numeric($this->input->post("actor"))) {
			$arr_of_data = [
				"name" => htmlspecialchars($this->input->post("actor")),
			];
			if ($this->film->getWhereActor($arr_of_data)->num_rows() > 0) {
				$this->response(
					["message" => "That actor already exist!"],
					409
				);
			} else {
				if ($this->film->addActor($arr_of_data)) {
					$this->response(
						[
							"message" => "Success!",
						],
						201
					);
				} else {
					$this->response(
						[
							"message" => "Oops, we had trouble : ",
							"trace_error" => $this->db->error(),
						],
						500
					);
				}
			}
		} else {
			$this->response(
				[
					"message" =>
						"Please fill all of input and give a valid value! There are required!",
				],
				422
			);
		}
	}
	public function tag_film_category_post()
	{
		$raw = file_get_contents("php://input");
		if (is_array(json_decode($raw)) && $this->input->get("id")) {
			$id = ["id" => htmlspecialchars($this->input->get("id"))];
			if ($this->film->detailFilm($id)->num_rows() > 0) {
				$arr_of_data = json_decode($raw);
				$error = false;
				foreach ($arr_of_data as $row) {
					if (!is_numeric($row)) {
						return $this->response(
							[
								"message" =>
									"Please fill all of input and give a valid value! There are required!",
							],
							422
						);
					}
					if (
						$this->film
							->detailCategory(["id" => $row])
							->num_rows() < 1
					) {
						$error = true;
					}
				}
				if (!$error) {
					$arr = [];
					foreach ($arr_of_data as $key => $row) {
						$arr[$key]["film_id"] = $id["id"];
						$arr[$key]["category_id"] = $row;
					}
					// Go Insert Category
					$this->film->batchInsertCategory($arr);
					return $this->response(["message" => "Success!"], 200);
				} else {
					return $this->response(
						[
							"message" =>
								"Oops, your requested category doesn't exist in our database!",
						],
						404
					);
				}
			} else {
				return $this->response(
					[
						"message" =>
							"Oops, your requested film doesn't exist in our database!",
					],
					404
				);
			}
		} else {
			$this->response(
				[
					"message" =>
						"Please fill all of input and give a valid value! There are required!",
				],
				422
			);
		}
	}
	public function tag_film_actor_post()
	{
		$raw = file_get_contents("php://input");
		if (is_array(json_decode($raw)) && $this->input->get("id")) {
			$id = ["id" => htmlspecialchars($this->input->get("id"))];
			if ($this->film->detailFilm($id)->num_rows() > 0) {
				$arr_of_data = json_decode($raw);
				$error = false;
				foreach ($arr_of_data as $row) {
					if (!is_numeric($row)) {
						return $this->response(
							[
								"message" =>
									"Please fill all of input and give a valid value! There are required!",
							],
							422
						);
					}
					if (
						$this->film->detailActor(["id" => $row])->num_rows() < 1
					) {
						$error = true;
					}
				}
				if (!$error) {
					$arr = [];
					foreach ($arr_of_data as $key => $row) {
						$arr[$key]["film_id"] = $id["id"];
						$arr[$key]["actor_id"] = $row;
					}
					// Go Insert Actor
					$this->film->batchInsertActor($arr);
					return $this->response(["message" => "Success!"], 200);
				} else {
					return $this->response(
						[
							"message" =>
								"Oops, your requested actor doesn't exist in our database!",
						],
						404
					);
				}
			} else {
				return $this->response(
					[
						"message" =>
							"Oops, your requested film doesn't exist in our database!",
					],
					404
				);
			}
		} else {
			$this->response(
				[
					"message" =>
						"Please fill all of input and give a valid value! There are required!",
				],
				422
			);
		}
	}
	public function film_delete()
	{
		if ($this->input->get("id")) {
			$id = ["id" => htmlspecialchars($this->input->get("id"))];
			if ($this->film->detailFilm($id)->num_rows() != 0) {
				// Delete Parent First
				try {
					$this->film->deleteFilm($id);

					// Then Delete Hooked Actors
					$this->film->deleteHookedActors(["film_id" => $id["id"]]);

					// Then Delete Hooked Categories
					$this->film->deleteHookedCategories([
						"film_id" => $id["id"],
					]);
					return $this->response(["message" => "Success!"], 200);
				} catch (Exception $e) {
					return $this->response(
						[
							"message" => "Oops, We have trouble here",
							"trace" => $e,
						],
						500
					);
				}
			} else {
				$this->response(
					[
						"message" =>
							"Oops, your requested film doesn't exist in our database!",
					],
					404
				);
			}
		} else {
			return $this->response(
				[
					"message" =>
						"Please fill all of input and give a valid value! There are required!",
				],
				422
			);
		}
	}
	public function film_get()
	{
		return $this->response(["data" => $this->film->getFilm()], 200);
	}
	public function film_detail_get()
	{
		if ($this->input->get("id")) {
			$id = htmlspecialchars($this->input->get("id"));
			return $this->response(
				[
					"data" => [
						"actors" => $this->film->getFilmActors([
							"film_id" => $id,
						]),
						"categories" => $this->film->getFilmCategories([
							"film_id" => $id,
						]),
						"detail" => $this->film->getFilmDetail([
							"id" => $id,
						])[0],
					],
				],
				200
			);
		} else {
			return $this->response(
				[
					"message" =>
						"Please fill all of input and give a valid value! There are required!",
				],
				422
			);
		}
	}
	public function film_detail_post()
	{
		if (
			$this->input->get("id") &&
			$this->input->post("title") &&
			strlen($this->input->post("release")) == 4 &&
			is_numeric($this->input->post("release")) &&
			$this->input->post("description") &&
			is_numeric($this->input->post("rental_rate"))
		) {
			$id = ["id" => htmlspecialchars($this->input->get("id"))];
			if ($this->film->detailFilm($id)->num_rows() > 0) {
				$arr_of_data = [
					"title" => htmlspecialchars($this->input->post("title")),
					"release_year" => htmlspecialchars(
						$this->input->post("release")
					),
					"description" => htmlspecialchars(
						$this->input->post("description")
					),
					"rental_rate" => htmlspecialchars(
						$this->input->post("rental_rate")
					),
				];
				if ($this->film->updateFilm($arr_of_data, $id)) {
					return $this->response(
						[
							"message" => "Success!",
						],
						201
					);
				} else {
					$this->response(
						[
							"message" => "Oops, we had trouble : ",
							"trace_error" => $this->db->error(),
						],
						500
					);
				}
			} else {
				$this->response(
					[
						"message" =>
							"Oops, your requested film doesn't registered in our database!",
					],
					422
				);
			}
		} else {
			$this->response(
				[
					"message" =>
						"Please fill all of input and give a valid value! There are required!",
				],
				422
			);
		}
	}
	public function actors_get()
	{
		return $this->response(
			$this->film->getAllActors()->result_array(),
			200
		);
	}
	public function categories_get()
	{
		return $this->response(
			$this->film->getAllCategories()->result_array(),
			200
		);
	}
	public function list_movie_year_actor_get()
	{
		$arr = [];
		foreach ($this->film->getFilm() as $row) {
			array_push($arr, [
				"title" => $row["title"],
				"film_year" => $row["release_year"],
				"actor_name" => $this->film->getFilmActorName([
					"film_id" => $row["id"],
				]),
			]);
		}
		return $this->response($arr, 200);
	}
	public function top_5_category_get()
	{
		return $this->response(
			$this->film->top_5_category()->result_array(),
			200
		);
	}
	public function top_5_films_get()
	{
		return $this->response(
			$this->film->top_5_favorite_film()->result_array(),
			200
		);
	}
	public function top_3_films_get()
	{
		return $this->response(
			$this->film->top_3_favorite_film()->result_array(),
			200
		);
	}
}
