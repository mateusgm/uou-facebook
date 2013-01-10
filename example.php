<?

  // config

  $config = array();

  $config['FB']     = array(
    'app_id'         => '200859703383681',
    'secret_key'     => 'ce85a7e6dd81026d165b91570e0cb543',
    'permissions'    => 'publish_actions,user_likes',
    'page_id'        => '165202343614075',
    'after_like_url' => 'game/'
  );

  // initialization

  require_once('uou-facebook.php');
  $uou_fb = new UouFacebook($config['FB']);
  $uou_fb->login();

  // if you require the user to like a page

  $uou_fb->redirect_if_already_liked($config['FB']['page_id'], $config['FB']['after_like_url']);

?>

<!DOCTYPE html>
<html xmlns:fb="https://www.facebook.com/2008/fbml">
  <head>
    <title>Torre de Presentes - Minas Shopping</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

    <script>

      // dealing with events

      var fb_when = {

        logged_in: function(response) {
          uFB.check_like(PAGE_ID);
        },

        liked_page: function() {
          if(uFB.connected()) uFB.redirect_to(AFTER_LIKE_URL);
        },

        not_authorized: function(response) {
          // do nothing
        },

        logged_out: function(response) {
          // do nothing
        },

        not_liked_page: function(page) {
          // do nothing
        }

      }
  
    </script>
  </head>

  <body style="margin: 0;">

    <?php $uou_fb->print_js(); ?>

  </body>

</html>