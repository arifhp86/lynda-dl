<?php

namespace LyndaDL;

class Course
{
	protected $curl;
	protected $db;
	protected $content;

	public function __construct($curl, $db)
	{
		$this->curl = $curl;
		$this->db = $db;
	}

	public function retriveCourseName()
	{
		preg_match('/<h1 class="default-title" itemprop="name" data-course="(.+?)"/', $this->content, $matches);
		return $matches[1];
	}

	public function retriveEpLinks()
	{
		preg_match_all('/<a href="(.+)" class="item-name video-name ga".+\s+(.+)\s+<\/a>/', $this->content, $matches);
		$newArr = [];
		foreach ($matches[1] as $key => $link) {
			$newArr[] = ['name' => $matches[2][$key], 'url' => $link];
		}
		return $newArr;
	}

	public function save($link)
	{
		$this->content = $this->curl->retriveContent($link);
		$name = $this->retriveCourseName();
		$id = $this->db->saveCourseName($name);
		$epLinks = $this->retriveEpLinks();
		$this->db->saveCourseEpisodes($id, $epLinks);
	}

	public function getAll()
	{
		return $this->db->getCourses();
	}

	public function getEpisodes($id)
	{
		return $this->db->getCourseEpisodes($id);
	}

	public function delete($id)
	{
		$this->db->deleteCourse($id);
	}


}






