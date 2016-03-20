<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Session;
use Facebook\Facebook;

class SiteController extends Controller
{
	
	public function beforeAction($action)
	{
		if ($action->id == 'callback') {
			$this->enableCsrfValidation = false;
		}
	
		return parent::beforeAction($action);
	
	}

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
    	$fb = new Facebook([
			  'app_id' => '169681916430784',
			  'app_secret' => 'bbc5cb3735117891cc087aebc5def370',
			  'default_graph_version' => 'v2.5',
			  //'default_access_token' => '{access-token}', // optional
		]);	
    	
    	$helper = $fb->getCanvasHelper ();
    	try {
    		$token = $helper->getAccessToken ();
    	} catch ( \Facebook\Exceptions\FacebookResponseException $e ) {
    		echo 'Graph returned an error: ' . $e->getMessage ();
    		exit ();
    	} catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
    		echo 'Facebook SDK returned an error: ' . $e->getMessage();
    		exit;
    	}
    	
    	//$helper = $data->fb->getCanvasHelper();
    	if(!isset($data->accesstoken)){
    		return $this->redirect(['/site/connect']);
    	}
    	$response = $data->fb->get('/me?fields=id,name',$data->accesstoken);
    	$user = $response->getGraphUser();
        return $this->render('index',[
        		'user' => $user
        ]);
    }
	
    public function actionConnect()
    {
    	$fb = new Facebook([
			  'app_id' => '169681916430784',
			  'app_secret' => 'bbc5cb3735117891cc087aebc5def370',
			  'default_graph_version' => 'v2.5',
			  //'default_access_token' => '{access-token}', // optional
		]);	
    	
    	$helper = $fb->getRedirectLoginHelper();
    	try {
    		$token = $helper->getAccessToken ();
    	} catch ( \Facebook\Exceptions\FacebookResponseException $e ) {
    		echo 'Graph returned an error: ' . $e->getMessage ();
    		exit ();
    	} catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
    		echo 'Facebook SDK returned an error: ' . $e->getMessage();
    		exit;
    	}
    	
    	$permissions = ['email', 'user_likes','user_posts','publish_actions']; // optional
    	$loginUrl = $helper->getLoginUrl('https://my-fb-apps.herokuapp.com/site/callback', $permissions);
    	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
    }
    
    public function actionCallback($code)
    {
    	$session = new Session();
    	$session->open();
    	
    	$fb = new Facebook([
			  'app_id' => '169681916430784',
			  'app_secret' => 'bbc5cb3735117891cc087aebc5def370',
			  'default_graph_version' => 'v2.5',
			  //'default_access_token' => '{access-token}', // optional
		]);	
    	$helper = $fb->getRedirectLoginHelper();
    	
    	try {
    		$accessToken = $helper->getAccessToken();
    	} catch(\Facebook\Exceptions\FacebookResponseException $e) {
    		// When Graph returns an error
    		echo 'Graph returned an error: ' . $e->getMessage();
    		exit;
    	} catch(\Facebook\Exceptions\FacebookSDKException $e) {
    		// When validation fails or other local issues
    		echo 'Facebook SDK returned an error: ' . $e->getMessage();
    		exit;
    	}
    	
    	if (isset($accessToken)) {
    		// Logged in!
    		$session['facebook_access_token'] = (string) $accessToken;
    		return $this->redirect('https://apps.facebook.com/tej_fb_apps/');
    		// Now you can redirect to another page and use the
    		// Now you can redirect to another page and use the
    		// access token from $_SESSION['facebook_access_token']
    	}else{
    		return $this->redirect(['/site/connect']);
    	}
    }
    
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
