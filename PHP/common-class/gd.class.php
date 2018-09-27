<?php
class Image{
	private $information;
	private $image;
	
	/*��ͼƬ*/
	public function __construct($src)
	{
		$information = getimagesize($src);
		$this->information = array(
			'width'=> $information[0],
			'height'=> $information[1],
			'type'=> image_type_to_extension($information[2],false),
			'mime'=> $information['mime']
		);
		$func = "imagecreatefrom{$this->information['type']}";
		$this->image = $func($src);
	}
	
	/*��������ͼƬ*/
	public function thumb($width,$height)
	{
		$image_thumb = imagecreatetruecolor($width,$height);
		imagecopyresampled($image_thumb,$this->image,0,0,0,0,$width,$height,$this->information['width'],$this->information['height']);
		imagedestroy($this->image);
		$this->image = $image_thumb;
	}
	/*��������ˮӡ*/
	public function fontMark($content,$fontSrc,$size,$color,$local,$angle)
	{
		$col = imagecolorallocatealpha($this->image,$color[0],$color[1],$color[2],$color[3]);
		imagettftext($this->image,$size,$angle,$local['x'],$local['y'],$col,$fontSrc,$content);
	}
	/*����ͼƬˮӡ*/
	public function imageMark($source,$local,$alpha)
	{
		$sourceInfo = getimagesize($source);
		$sourceType = image_type_to_extension($sourceInfo[2],false);
		$funcImage = "imagecreatefrom{$sourceType}";
		$Water = $funcImage($source);
		imagecopymerge($this->image,$Water,$local['x'],$local['y'],0,0,$sourceInfo[0],$sourceInfo[1],$alpha);
		imagedestroy($Water);
	}
	
	/*������������ͼƬ*/
	public function showInBower()
	{
		header("Content-type:",$this->information['mime']);
		$func = "image{$this->information['type']}";
		$func($this->image);
	}
	/*��ͼƬ����*/
	public function save($NewName)
	{
		$func = "image{$this->information['type']}";
		$func($this->image,$NewName.".".$type);
	}
	/*����ͼƬ*/
	public function __destruct()
	{
		imagedestroy($this->image);
	}
}

