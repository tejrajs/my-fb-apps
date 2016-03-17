<?php
namespace app\components;

use yii\base\Component;
use Facebook\Facebook;
class FacebookApi extends Component
{
	public $fb;
	
	private $token;
	
	public $app_id = '192495190824190';
	
	public $app_secret = '07b067bb8867e10bc11636fa4bb6f49d';
	
	public $default_graph_version = 'v2.5';
	
	public function init(){
		$this->fb = new Facebook([
			  'app_id' => $this->app_id,
			  'app_secret' => $this->app_secret,
			  'default_graph_version' => $this->default_graph_version,
			  //'default_access_token' => '{access-token}', // optional
		]);
		
		$helper = $this->fb->getCanvasHelper();
		
		try {
			$this->token = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}
	}
	
	public function get($url){
		$response = $this->fb->get($url,$this->token);
	}
	
	public function post($url,$params=[]){
		$response = $this->fb->post($url,$params,$this->token);
	}
	
	public function delete($url,$params=[]){
		$response = $this->fb->delete($url,$params,$this->token);
	}
}