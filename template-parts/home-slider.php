<?php 
global $fields;
$has_big_slider=true;
if ( isset($fields['slide']) && is_array($fields['slide']) ):  
  //intialize the active class 
  $liActive = ' class="active"';
  $itActive = ' active';
  $indicators = '';
  $items = '';
  foreach ($fields['slide'] as $k => $field):
    //each indicator
    $format = '<li data-target="#carouselHome" data-slide-to="%s"%s></li>';
    $indicators .= sprintf($format, $k, $liActive);
    
    ob_start();

    $style = '';
    if( isset($field['bg_image']['url']) ) {
      $format = ' style="background-image: url(%s)"';
      $style = sprintf($format, $field['bg_image']['url']);
    }
    
    $video = '';
    if ( isset($field['bg_video_new']) && strlen($field['bg_video_new']) > 11 ) {
      $videoID = substr($field['bg_video_new'], -11);
      $format = ' data-videoID="%s" data-videoContainer="player%s"';
      $video = sprintf($format, $videoID, $k);
      ?> 
    <script> var headerVideo = true; </script> 
      <?php
    }
    ?>
    <div class="carousel-item<?php echo $itActive ?>"<?php echo $style . $video ?>>
        <?php if ($video): ?> 
        <div class="video-container" id="player<?php echo $k ?>"></div>
        <?php endif;?>      
      <div class="custom-container"> 
        <div class="slider-text is-animated-in">
          <h1 class="heading" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="800" data-aos-duration="800" style="color:<?php echo $field['title_color'] ?>;"><?php echo $field['title'] ?></h1>
          <div class="subtitle subheading" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="1200" data-aos-duration="800">
            <?php if (!empty($field['subtitle'])): ?><h2><?php echo $field['subtitle'] ?></h2><?php endif; ?>
            <?php if (!empty($field['button_text'])): ?><a class="learn-more" href="<?php echo $field['button_link']['url']; ?>" <?php if (!empty($field['button_link']['target'])) echo 'target="'. $field['button_link']['target'] .'"'; ?>><?php echo $field['button_text'] ?></a><?php endif; ?>
          </div>
        </div>
        <div class="slider-buttons">
          <?php 
          if ( isset($field['buttons']) && is_array($field['buttons']) ):  
            foreach ($field['buttons'] as $btn):
          ?>
          <a href="<?php echo $btn['link'] ?>" class="<?php echo $btn['color'] ?>"><?php echo $btn['text'] ?></a>
          <?php 
            endforeach;            
          endif;        
          ?>
          <?php if ( isset($field['buttons']) && is_array($field['buttons']) ): ?>
          <div class="buttons-on-mobile">
            <button type="button">Filter</button>
            <ul class="buttons-on-mobile-list">
            <?php foreach ($field['buttons'] as $btn): ?>
              <li><a href="<?php echo $btn['link'] ?>"><?php echo $btn['text'] ?></a></li>
            <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>
        </div>        
      </div>
      
      <?php if ( isset($field['bg_video_new']) && !empty($field['bg_video_new']) ): ?>
      <iframe width="560" height="315" id="player<?php echo $k ?>" src="<?php echo $field['bg_video_new'] ?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
      <?php endif; ?>
      
    </div>
    <?php

    $items .= ob_get_contents();
    ob_end_clean();
    
    
    //reset the active class    
    $liActive = '';
    $itActive = '';
  endforeach;
?>
<div id="carouselHome" class="carousel slide home-slider" data-ride="carousel" data-interval="false">
  <?php if( count($fields['slide']) > 1 ): ?>   
  <ol class="carousel-indicators">
    <?php echo $indicators ?>
  </ol>
  <?php endif; ?>
  <div class="carousel-inner">
    <?php echo $items ?>
  </div>
  <div class="clearfix"></div>
  <?php if( count($fields['slide']) > 1 ): ?> 
  <a class="carousel-control carousel-control-prev slider-link" href="#carouselHome" role="button" data-slide="prev">
    <i class="fa fa-angle-left" aria-hidden="true"></i>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control carousel-control-next slider-link" href="#carouselHome" role="button" data-slide="next">
    <i class="fa fa-angle-right" aria-hidden="true"></i>
    <span class="sr-only">Next</span>
  </a>
  <?php endif; ?>
  <!-- Total slides = <?php echo count($fields['slide']) ?> -->
</div>

<?php 
endif;
?>