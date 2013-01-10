
window.fbAsyncInit = function() {
  uFB.init(APP_ID);
  uFB.subscribe_to_status_change();
  if(PAGE_ID && PERMISSIONS.search('user_likes') > 0) uFB.subscribe_to_edge_create();
};

var uFB = new function(){

  var self       = this;
  var cresponse  = null;
  var just_tried = false;

  // initialization

  this.init = function(id) {
    FB.init({
      appId:  id,
      status: true,
      cookie: true, 
      oauth:  true,
      xfbml:  true
    });
  }


  // authentication

  this.on_response = function(response) {
    cresponse = response;
    if(self.connected()) {
      $('#fb-uid').text(response.authResponse.userID);      
      fb_when.logged_in(response.authResponse);
    } else {
      if(!just_tried) self.login();
      if(self.not_authorized()) fb_when.not_authorized(response.authResponse);
      else fb_when.logged_out(response.authResponse);
    }
  }

  this.login = function(permissions) {
    FB.login(self.on_response, { scope: permissions });
    just_tried = true;  
  }

  this.connected = function(){
    return cresponse && cresponse.status == 'connected';
  } 

  this.not_authorized = function(){
    return cresponse && cresponse.status == 'not_authorized';
  } 


  // events

  this.subscribe_to_status_change = function() {
    FB.Event.subscribe('auth.statusChange', self.on_response);
  }

  this.subscribe_to_edge_create = function() {
    FB.Event.subscribe('edge.create', fb_when.liked_page);
  }


  // api

  this.check_like = function(page_id) {
    FB.api('/me/likes/' + page_id, function(response){
      if(response.data.length !== 0) fb_when.liked_page();
      else fb_when.not_liked_page();
    });
  }


  // helpers

  this.redirect_to = function(url) {
    window.location.href = url;
  }

}();


// Load the SDK's source Asynchronously

(function(d, debug){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
   ref.parentNode.insertBefore(js, ref);
 }(document, /*debug*/ false));

