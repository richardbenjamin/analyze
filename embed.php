<?php require 'config.php'; ?>

<script src="<?php echo base_url; ?>/node_modules/socket.io-client/socket.io.js"></script>
<script src="//www.google.com/jsapi"></script>
<?php 
$ip = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');

?>
<!-- 'forceNew':true, 'reconnect':false, 'sync disconnect on unload':true  -->
<script>
	function supports_html5_storage() {
	  try {
	    return 'localStorage' in window && window['localStorage'] !== null;
	  } catch (e) {
	    return false;
	  }
	}
  function randomId(){
    var id = '';
    var character = '';
    var alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for(var i=0; i< 30; i++ ){
      var random_number = Math.floor(Math.random()*9) ;
      id += random_number;
      if( random_number % 2 ){
        character = alpha.charAt( Math.floor(Math.random()*alpha.length) );
        if( Math.floor(Math.random()*100) % 2 ){
          id += character.toLowerCase();
        } else {
          id += character;
        }
      }
    }
    return id;
  }
  // Start socket io
  var socket = io.connect('<?php echo io_url; ?>', {});
  
  if( supports_html5_storage() ){
    var id = localStorage.getItem('rbk_user_id');
    if( id == null ){
      localStorage.setItem('rbk_user_id', randomId() );
      id = localStorage.getItem('rbk_user_id');
    }
  }
  // socket.custom_id = id;
	var url = (window.location != window.parent.location) ? document.referrer: document.location;
	var host = window.parent.location.host;
  socket.emit('client-info', {
    id: id,
    url: url,
    host: host,
    ip:'<?php echo $ip; ?>',
    city: google.loader.ClientLocation.address.city,
    state: google.loader.ClientLocation.address.region,
    lat: google.loader.ClientLocation.latitude,
    lng: google.loader.ClientLocation.longitude
	});

</script>