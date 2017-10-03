<?php

namespace LyndaDL;

class Episode
{
	protected $curl;
	protected $db;

	public function __construct($curl, $db)
	{
		$this->curl = $curl;
		$this->db = $db;
	}

	public function getEpisode($courseId, $epId)
	{
		return $this->db->getSingleEpisode($courseId, $epId);
	}

	public function getDownloadLink($url)
	{
		$content = json_decode($this->curl->retriveContent($url));
		// var_dump($url);die;
		return $content[0]->urls->{'540'};
	}

	public function downloadVideo($courseId, $epId)
	{
		$courseName = $this->db->getCourseName($courseId);
		$episode = $this->getEpisode($courseId, $epId);
		$downloadLink = $this->getDownloadLink("https://www.lynda.com/ajax/course/{$episode->courseId}/{$episode->id}/play");
		$this->curl->downloadVideo($downloadLink, $episode->name, $epId, $episode->url, $courseName);
	}
}







