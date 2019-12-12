/**
 * Header video logic
 */	
if ( typeof headerVideo !== 'undefined' ) {
  console.log('video present');
  if ( typeof headerVideoScript === 'undefined' ) {
    // 2. This code loads the IFrame Player API code asynchronously.
    var headerVideoScript = document.createElement('script');

    headerVideoScript.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(headerVideoScript, firstScriptTag);      
  }
  
  var YouTubeIframeAPIReadyFunction;

  function onYouTubeIframeAPIReady() {
    console.log('YouTube API ready');
    YouTubeIframeAPIReadyFunction();
  }
} 

jQuery(document).ready(function($){
  /**
   * Video function
   */
  YouTubeIframeAPIReadyFunction = function(){
    console.log('ready function');
    
    var players = {},
        crtPlayer;
    
    $('.home-slider .carousel-item').each(function(el){
      if ( $(this).data('videoid') ) {
        var videoContainer =$(this).data('videocontainer'),
            videoID = $(this).data('videoid');
        //This code creates an <iframe> (and YouTube player) 
        players[videoContainer] = new YT.Player(videoContainer, {
          height: '390',
          width: '640',
          videoId: videoID,
          playlist:  videoID,
          loop: 1,
          controls: 0,
          rel: 0,
          showinfo: 0,
          modestbranding: 1,
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }
    });   
    
    //start playing the video
    function onPlayerReady(event){
      console.log('lets play');
      var activeVideo = $('.home-slider .carousel-item.active').data('videocontainer');
      console.log(activeVideo);
      if ( activeVideo ) {
        players[activeVideo].playVideo();
        crtPlayer = players[activeVideo];
      }
    } 
    
    //replay the video if ended
    function onPlayerStateChange(event) {      
      if ( event.data == YT.PlayerState.ENDED ) {
        onPlayerReady(event);
      }
    }
    
    //Process the videos after slide change
    $('.home-slider').on('slid.bs.carousel', function () {
      console.log('slide changed');
      //pause the current video
      if ( crtPlayer ) {
        crtPlayer.pauseVideo();
      } 
      
      //play the active video
      onPlayerReady();
    })
  }

  // $('#recipeCarousel').carousel({
  //   interval: 10000
  // })

  $('#recipeCarousel.carousel .carousel-item').each(function(){
      var next = $(this).next();
      if (!next.length) {
      next = $(this).siblings(':first');
      }
      next.children(':first-child').clone().appendTo($(this));
      
      if (next.next().length>0) {
      next.next().children(':first-child').clone().appendTo($(this));
      }
      else {
        $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
      }
  });


  $('.user_role_select').on('change', function(){
    var role = $(this).find('option:checked').val();
    if(role != ''){
      $('.user_role_block').hide();
      $('.user_role_block[data-role="'+role+'"]').show();
    }
  });




});