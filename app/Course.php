<?php

namespace LyndaDL;

class Course
{
	protected $curl;
	protected $db;
	protected $content;
	protected $courseId;

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

	public function retriveCourseId()
	{
		preg_match('/data-tracking-category="course-page" data-course-id="(\d+)"/', $this->content, $matches);
		$this->courseId = $matches[1];
		return $this->courseId;
	}

	public function retriveEpLinks()
	{
		preg_match_all('/<a href="(.+?)".+?data-ga-value="(\d+)".+>\s+(.+?)\s+<\/a>/', $this->content, $matches);
		$newArr = [];
		foreach ($matches[1] as $key => $link) {
			$newArr[] = ['id' => $matches[2][$key], 'courseId' => $this->courseId, 'name' => $matches[3][$key], 'url' => $link];
		}
		return $newArr;
	}

	public function save($link)
	{
		$this->content = $this->curl->retriveContent($link);

		$name = $this->retriveCourseName();
		$courseId = $this->retriveCourseId();
		$id = $this->db->saveCourseName($name, $courseId);

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






