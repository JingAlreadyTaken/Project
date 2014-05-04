<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This library will help in providing secure file uploads, the functions we have provided are based
 * on the vulnerabilites on file uploads in PHP and solutions provided 
 */




class Upload
{
	
 	/**
	 * Maximum allowed file size for file upload in bytes
	 * @var int
 	*/
	public static $maximumSize = 2097152;
	
	/**
	 * Allowed extensions
	 * @var array
	**/
	public static $allowedExtensions= array("jpeg"=>"jpeg","gif"=>"gif","pdf"=>"pdf","jpg"=>"jpg",
											"png"=>"png","txt"=>"txt");


	/**
	 *ISA681-term project
	 *Receives the file name and tests if its allowed and valid, only allows the filename to contain 
	 * does not allow spaces,anyother metacharacters excepts "-","_" with alphanumeric characters
	 *@param string $string contains the file name to be tested
	 *@return boolean true if file name is valid 
	 *
	**/
	public static function isValidName($field)
	{

		if(!($_FILES[$field]))
		{
			return FALSE;
		}
		else
			$file_name=$_FILES[$field]["name"];
	 $pattern="/^([A-Z]|[a-z]|[0-9]|[_-])+\.[a-z]{3,4}$/";
	 preg_match($pattern, $file_name, $matches);
	 if(count($matches) == 0)
	 	return FALSE;
	 else
	 	return TRUE;

	}

	/**
	 *ISA681-term project
	 * Receives the file name and checks for the file size , if the size is within the allowed limit 
	 * returns true
	 * @param string $field filename identifier
	 * @return Boolean TRUE if within acceptable, fals if not within acceptable limit
	 **/

	 public static function isSizeOk($field)
	 {
	 	if(!($_FILES[$field]))
	 		return FALSE;
	 	else
	 	{ 		
	 		if ($_FILES[$field]["size"] > Upload::$maximumSize)
	 			return FALSE;
	 		else
	 			return TRUE;
	 	}
	 }

	 /**
	  *ISA681-term project
	  * Receives the file name and checks if the provided extensions is part of allowed extensions
	  * this is just direct stripping of the extension provided and comparing with allowed extensions
	  * should be combined with isFileTypeReal to check if the type provided and actual type are same
	  * @param string $field file identifier
	  * @return boolean true is allowed extension, false if not
	  **/
	 public static function isExtensionOk($field)
	 {

	 	if(!($_FILES[$field]))
		{
			return FALSE;
		}
		else
		{
		$file_name=$_FILES[$field]["name"];
	 	$pattern="/^([A-Z]|[a-z]|[0-9]|[_-])+\.([a-z]{3,4})$/";
		 preg_match($pattern, $file_name, $matches);
	 	if(count($matches) == 0)
		 	return FALSE;
		 else
	 		{
		
	 			if (Upload::$allowedExtensions[$matches[2]]===$matches[2])
	 				return TRUE;
	 			else
	 				return FALSE;
			}
	 		}
	 }

	 /**
	  * ISA681-term project
	  * Check if the provided file is just image
	  * Checks if the file provided is just an image or diguised as image, use only for image file
	  * @param string $field file identifer 
	  * @return boolean returns true if file is identified to be image else returns false
	  **/
	 public static function isImage($field)
	 {
	 	if(!($_FILES[$field]))
		{
			return FALSE;
		}
		else
		{
		$file_name=$_FILES[$field]["name"];
	 	$pattern="/^([A-Z]|[a-z]|[0-9]|[_-])+\.([a-z]{3,4})$/";
		preg_match($pattern, $file_name, $match);
		$temp_name=$_FILES[$field]["tmp_name"];
		$failed ='n';
		error_reporting(0);
		if(($match[2] === "jepg") or ($match[2] === "jpg"))
		{
			if(!($img=imagecreatefromjpeg($temp_name)))
				$failed = 'y';
		}
		if($match[2] === "png")
		{
			if(!($img=imagecreatefrompng($temp_name)))
				$failed = 'y';
		}
		if($match[2] === "gif")
		{
			if(!($img=imagecreatefromgif($temp_name)))
				$failed = 'y';
		}
		error_reporting(E_ALL);
		if ($failed === 'y')
			return FALSE;
		else
		{
			$imageinfo = getimagesize($temp_name);
			if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png' )
				return FALSE;
			else
				return TRUE;

		}
		}
	}


	/**
	 * ISA681-term project
	 *Checks if the file type is allowed based on MimeType 
	 *@param string $field the identifier for the file 
	 *@return boolean if the file type is not allowed return false
	 **/
	public static function isFileTypeReal($field)
	{
		$finfo=new finfo(FILEINFO_MIME_TYPE);
		$file_contents=file_get_contents($_FILES[$field]['tmp_name']);
		$mime_type=$finfo->buffer($file_contents);
		if($mime_type === $_FILES[$field]['type'])
			return TRUE;
		else
			return FALSE;
	}
}


?>