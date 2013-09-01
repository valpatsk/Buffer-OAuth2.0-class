Buffer.OAuth2.class
=====================

Please take OAuth2.class.php from my repo OAuth2.0-class https://github.com/valpatsk/OAuth2.0-class .

Buffer OAuth 2.0 Class.
Very short necessary list of functions for me to interact with Buffer through OAuth 2.0.

HOW TO USE:

1. Redirect user to Auth screen:
```php
require_once("Buffer.OAuth2.class.php");
//Create Buffer app to get keys
$client_id = "...";
$client_secret = "...";
//put here your redirect url
$redirect_url="...";
$BO = new BufferInOAuth2();
$connect_link = $BO>getAuthorizeUrl($client_id,$redirect_url);
//show link or just redirect  
```


2. Get Access Token
```php
require_once("Buffer.OAuth2.class.php");
$client_id = "...";
$client_secret = "...";
//put here your redirect url
$redirect_url="...";
$code = isset($_REQUEST['code'])?$_REQUEST['code']:'';
$BO = new BufferInOAuth2();
//you can put code as argument or it will be taken from $_REQUEST
$access_token = $BO->getAccessToken($client_id,$client_secret,$redirect_url,$code);
//you can already use $BO object
$user = $BO->getUser();
//How to use futher with existing access_token:
$BO = new BufferInOAuth2($access_token);
```


3. List of possible methods
```php
checkConnection();
getProfiles();
getUser();
postMessage();
```

4. How to post messages
```php
$content=array();
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
$BO = new BufferInOAuth2($access_token);
$result = $BO->postMessage($content);
//check for result info in $result array.
```
