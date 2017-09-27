<?php

namespace LyndaDL;

class FileDB
{
	const STORAGE_FOLDER = 'storage/';
	const COURSE_FILE_NAME = 'courses.json';
	const FILE_EXT = '.json';
	protected $courses;

	public function __construct()
	{
		$filePath = self::STORAGE_FOLDER . self::COURSE_FILE_NAME;
		if(!file_exists($filePath))
			file_put_contents($filePath, json_encode([]));

		$this->courses = json_decode(file_get_contents($filePath));
	}

	/**
	 * Saves a course name with generared id
	 * @param  string $name
	 * @return string
	 */
	public function saveCourseName($name)
	{
		$filePath = self::STORAGE_FOLDER . self::COURSE_FILE_NAME;
		$id = uniqid('ly_');
		$this->courses[] = (object)compact('id', 'name');
		file_put_contents($filePath, json_encode($this->courses));
		return $id;
	}

	/**
	 * Save course episodes
	 * @param  string $id
	 * @param  array $episodes
	 * @return void
	 */
	public function saveCourseEpisodes($id, $episodes)
	{
		file_put_contents(self::STORAGE_FOLDER . $id . self::FILE_EXT, json_encode($episodes));
	}

	/**
	 * Get all course name
	 * @return void
	 */
	public function getCourses()
	{
		return $this->courses;
	}

	/**
	 * Get all episodes of a course
	 * @param  string $id
	 * @return array|bool
	 */
	public function getCourseEpisodes($id)
	{
		$fileName = self::STORAGE_FOLDER . $id . self::FILE_EXT;
		if(!file_exists($fileName))
			return false;

		return json_decode(file_get_contents($fileName));
	}

	public function getSingleEpisode($courseId, $epId)
	{
		$course = $this->getCourseEpisodes($courseId);
		return $course ? $course[$epId] : false;
	}

	public function getCourseIndex($id)
	{
		$index = null;
		foreach ($this->courses as $key => $course) {
			if($course->id == $id) {
				$index = $key;
				break;
			}
		}
		return $index;
	}

	public function deleteCourse($id)
	{
		$index = $this->getCourseIndex($id);
		if($index == null) 
			return;

		array_splice($this->courses, $index, 1);
		$courseFile = self::STORAGE_FOLDER . self::COURSE_FILE_NAME;
		file_put_contents($courseFile, json_encode($this->courses));
		$episodeFile = self::STORAGE_FOLDER . $id . self::FILE_EXT;
		if(file_exists($episodeFile))
			unlink($episodeFile);
	}

	public function getCourseName($id)
	{
		$index = $this->getCourseIndex($id);
		if($index === null) {
			return false;
		}
		return $this->courses[$index];
	}

}





