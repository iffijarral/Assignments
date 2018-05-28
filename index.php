<?php
	
	/*
	* @Author: Iftikhar Ahmed
	* 	
	* @desc: A simple page acting as controller and routing. It is controlled by two thing '.htaccess' file and 'getPath' a patch parsing function. 
	*	
	*/
	
	include("pages/header.html");
	
	$path_info = getPath();
	
	if($path_info['call_parts'][0] !='') {
		
		$page = $path_info['call_parts'][0];
		
		switch($page) {
			
			case "home":
				include("pages/home.html");	
			break;
			
			case "about":
				include("pages/about.html");	
			break;
			
			case "contact":
				include("pages/contact.html");	
			break;
			
			default:
				header("HTTP/1.0 404 Not Found");

				include("pages/404.html");	
			break;
						
		}
		
	} else {
		header("HTTP/1.0 404 Not Found");

		include("pages/404.html");
	}

	include("pages/footer.html");
	
	/*
	* Name: getPath()
	*
	* @desc: This is very handy function. It gets path from $_SERVER['REQUEST_URI'] and  after parses it return an array containing useful information about different parts of url. 
	*		 
	* Parameters: NULL
	* 			  
	* Returns: An array()
	*/
	
	function getPath() {
		
	  $path = array();
	  
	  if (isset($_SERVER['REQUEST_URI'])) {
		
		$request_path = explode('?', $_SERVER['REQUEST_URI']);

		$path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
		$path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
		$path['call'] = utf8_decode($path['call_utf8']);
		
		if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
		  $path['call'] = '';
		}
		
		$path['call_parts'] = explode('/', $path['call']);
		if(isset($request_path[1])) {
			$path['query_utf8'] = urldecode($request_path[1]);
			$path['query'] = utf8_decode(urldecode($request_path[1]));	
			$vars = explode('&', $path['query']);
			foreach ($vars as $var) {
			  $t = explode('=', $var);
			  $path['query_vars'][$t[0]] = $t[1];
			}
		}
		
		
	  }
		return $path;
	}