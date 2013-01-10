<?
  require "libs/facebook.php";
  require "includes/uou-utils.php";

  class UouFacebook {

    private $facebook;
    private $uid;
    private $app_id;
    private $page_id;
    private $after_like_url;
    private $permissions;

    function __construct($app_id, $secret_key, $permissions) {
      if(!$app_id) die('Inicialize o Facebook app id');
      $this->app_id      = $app_id;
      $this->facebook    = $this->init_sdk($app_id, $secret_key);
      $this->uid         = $this->facebook->getUser();
      $this->permissions = $permissions;
    }

    // login by redirect only if not open in facebook (otherwise open facebook popin in js)
    function login() {
      if(!$this->uid && !strpos($_SERVER["HTTP_REFERER"], 'facebook')) {
        $args = array('scope' => $permissions);
        $url  = $this->facebook->getLoginUrl($args);
        if(!$_GET['state']) js_redirect_to($url);
      }
    }

    function redirect_if_already_liked($page_id, $url) {
      $this->page_id        = $page_id;
      $this->after_like_url = $url; 
      if($this->user_has_liked($page_id)) php_redirect_to($url);
    }

    function print_js() { 
      require_once('includes/uou-facebook-js.php');
    }

    function user_has_liked($page_id) {
      try{      
        $like    = $this->facebook->api('/me/likes/' . $page_id);
        return count($like['data']) > 0;
      } catch (FacebookApiException $e) {
        // do nothing
        return null;
      }
    }

    private function init_sdk($app_id, $secret) {
      return new Facebook(array(
        'appId'  => $app_id,
        'secret' => $secret,
        'cookie' => true
      ));
    }

  }  

?>
