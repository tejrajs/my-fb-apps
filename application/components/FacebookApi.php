<?php
namespace app\components;

use yii\base\Component;
use Facebook\Facebook;
use yii\web\Session;
class FacebookApi extends Component
{
	public $fb;
	
	public $accesstoken;
	
	public $app_id = '169681916430784';
	
	public $app_secret = 'bbc5cb3735117891cc087aebc5def370';
	
	public $default_graph_version = 'v2.5';
	
	public function init(){
		$this->fb = new Facebook([
			  'app_id' => $this->app_id,
			  'app_secret' => $this->app_secret,
			  'default_graph_version' => $this->default_graph_version,
			  //'default_access_token' => '{access-token}', // optional
		]);	
		$helper = $this->fb->getCanvasHelper ();
		try {
			$token = $helper->getAccessToken ();
		} catch ( \Facebook\Exceptions\FacebookResponseException $e ) {
			echo 'Graph returned an error: ' . $e->getMessage ();
			exit ();
		} catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}
		
		if(isset($token)){
			$this->accesstoken = $token;
// 			$session = new Session();
// 			$session->open();
// 			$session['accesstoken'] = $token;
		}
	}
	
// 	public function get($url){
// 		try {
// 			$token = $this->helper->getAccessToken();
// 			$response = $this->fb->get($url,$token);
// 			return $response;
// 		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
// 			echo 'Graph returned an error: ' . $e->getMessage();
// 			exit;
// 		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
// 			echo 'Facebook SDK returned an error: ' . $e->getMessage();
// 			exit;
// 		}
		
// 	}
	
// 	public function post($url,$params=[]){
// 		try {
// 			$token = $this->helper->getAccessToken();
// 			$response = $this->fb->post($url,$params,$token);
// 			return $response;
// 		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
// 			echo 'Graph returned an error: ' . $e->getMessage();
// 			exit;
// 		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
// 			echo 'Facebook SDK returned an error: ' . $e->getMessage();
// 			exit;
// 		}
// 	}
	
// 	public function delete($url,$params=[]){
// 		try {
// 			$token = $this->helper->getAccessToken();
// 			$response = $this->fb->delete($url,$params,$token);
// 			return $response;
// 		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
// 			echo 'Graph returned an error: ' . $e->getMessage();
// 			exit;
// 		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
// 			echo 'Facebook SDK returned an error: ' . $e->getMessage();
// 			exit;
// 		}
// 	}
}