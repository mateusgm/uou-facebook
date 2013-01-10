<script type="text/javascript">

  var APP_ID      = '<?php echo $this->app_id; ?>';
  var PERMISSIONS = '<?php echo $this->permissions; ?>';

  <?php if($this->page_id && $this->after_like_url) : ?>
    var PAGE_ID        = '<?php echo $this->page_id; ?>';
    var AFTER_LIKE_URL = '<?php echo $this->after_like_url; ?>';
  <? endif; ?>

</script>
<script type="text/javascript" src="/uou-facebook-sdk/js/uou-fb-wrapper.js?<?php echo rand(); ?>"></script>

<div id="fb-root"></div>
<?php if($this->uid) : ?>
  <div id="fb-uid" style="display: none;"><?php echo $this->uid; ?></div>
<?php endif; ?>
