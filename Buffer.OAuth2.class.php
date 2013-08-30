<?php
/*
    (c) ContentMX.com
    Created: 30/08/2013
    Author: Valery Patskevich
    valpatsk@gmail.com
*/

require_once('OAuth2.class.php');

class BufferOauth2 extends OAuth2{

	public $access_token;

	function __construct($access_token=''){
        $this->access_token_url = 'https://api.bufferapp.com/1/oauth2/token.json';
        $this->authorize_url = "https://bufferapp.com/oauth2/authorize";
        parent::__construct($access_token);
    }

	public function getAccessToken($client_id="", $secret="", $callback_url="", $code = ""){
        $result = parent::getAccessToken($client_id, $secret, $callback_url, $code);
        $result = json_decode($result,true); 
		if(isset($result['error'])){
			$this->error = $result['error'].' '.$result['error_description'];;
			return false;
		}else{
			$this->access_token = $result['access_token'];
			return $result['access_token'];
		}
	}

	public function checkConnection(){
		if(!$this->access_token) return false;
        $user=$this->getUser();
		if(!$user || isset($user['error'])){
			return false;
		}else{
			return true;
		}
	}

	public function getProfiles(){
		$params=array();
		$params['url']="https://api.bufferapp.com/1/profiles.json";
		if($this->access_token){
			$profiles = $this->makeRequest($params);
			return json_decode($profiles,true); 
		}else 
			return false;
	}

	public function getUser(){
		$params=array();
		$params['url']="https://api.bufferapp.com/1/user.json";
		if($this->access_token){
			$user = $this->makeRequest($params);
			return json_decode($user,true); 
		}else 
			return false;
	}
/*
$content['text']='...';
$content['profile_ids'] = array('id_1','id_2'); //taken from $this->getProfiles();
$content['now']= true or false; // post now or save as draft
$content['shorten'] = true or false;
$content['media'] = array();
$content['media']['title']='...';
$content['media']['picture']'...';
$content['media']['thumbnail']'...';
$content['media']['description']'...';
$content['media']['link']'...';
*/
	public function postMessage($content=array()){
		$params=array();
		$params['url']='https://api.bufferapp.com/1/updates/create.json';
		$params['method']='post';
		$args=array();
		foreach($content as $key=>$value){
			if(is_array($value)){
				foreach($value as $key2=>$value2){
					$args[$key.'['.$key2.']']=$value2;
				}
			}else{
				$args[$key]=$value;
			}
		}
		$params['args']=$args;
		$result = $this->makeRequest($params);
        return json_decode($result,true);
	}

}

?>