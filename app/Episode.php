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

	public function getEpisodeUrl($courseId, $epId)
	{
		return $this->db->getSingleEpisode($courseId, $epId);
	}

	public function getDownloadLink($url)
	{
		$content = $this->curl->retriveContent($url);
		preg_match('/<div id="courseplayer"[\s\S]+?data-src="(.+?)"/', $content, $matches);
		return $matches[1];
	}

	public function downloadVideo($courseId, $epId)
	{
		$courseName = $this->db->getCourseName($courseId);
		$episode = $this->getEpisodeUrl($courseId, $epId);
		$downloadLink = $this->getDownloadLink($episode->url);
		$this->curl->downloadVideo($downloadLink, $episode->name, $epId, $episode->url, $courseName);
	}
}







