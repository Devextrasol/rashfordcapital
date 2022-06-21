<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
<script type="text/javascript" src="{{ asset('js/manifest.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/vendor.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/semantic/semantic.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/variables.js') }}"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inview.js') }}"></script>
@if(config('settings.adsense_client_id') && (config('settings.adsense_top_slot_id') || config('settings.adsense_bottom_slot_id')))
    <script>
        @if(config('settings.adsense_top_slot_id') && config('settings.adsense_bottom_slot_id'))
            // 2 ad slots
            var adsbygoogle = [{}, {}];
        @else
            // 1 ad slot
            var adsbygoogle = [{}];
        @endif
    </script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
@endif
@if(!$cookie_usage_accepted)
    <script type="text/javascript" src="{{ asset('js/cookie.js') }}"></script>
@endif

@stack('scripts')
<script type="text/javascript">

    //-------------RESPONSIVE SUBMENU TOGGLE-------------//
    $('.mydropdown').click(function(e){
        $('.sub-menu').toggleClass('active-submenu');
    });
    ///-----------Main search------------------//
    $('#search-trigger').click(function(){

    $('#websearch').addClass('trigger-serach');
    
  });
$('#close-trigger').click(function(){

    $('#websearch').removeClass('trigger-serach');
    
  });
//////////////////////////////////////////

    $(document).ready(function(){
  $('#menu-btn').click(function(){
    $('#menu').addClass('main-main');
    $('#menu-ul').addClass('menu-active');
    $('.cls-responsive').addClass('add-border');
    $('#page-test').addClass('myclas');
    $("#menu-close").show();
    $(this).hide();
    $('#search').hide();
    $('#text-wrap').hide();
    $(".close-text").show();
  });

  $('#search').click(function(){
    $('#menu').addClass('main-main');
    $('#menu-ul').addClass('search-active');
    $('#site-search').addClass('search-display');
    $('.cls-responsive').addClass('add-border');
    $('#page-test').addClass('myclas');
    $("#menu-btn").hide();
    $(this).hide();
    $('#menu-close').show();
    $(".close-text").show();
    $('#text-wrap').hide();
    $('#search-open').addClass('my-search');

  });


  $("#menu-close").click(function(){

    $( "#menu" ).removeClass( "main-main" );
    $( "#menu-ul" ).removeClass( "menu-active" );
    $( ".cls-responsive" ).removeClass( "add-border" );
    $('#menu').removeClass('main-main');
    $('#menu-ul').removeClass('search-active');
    $('#site-search').removeClass('search-display');
    $('.cls-responsive').removeClass('add-border');
    $('#page-test').removeClass('myclas');
    $('#search-open').removeClass('my-search');
    $(".close-text").hide();
    $("#menu-btn").show();
    $(this).hide();
    $('#search').show();
    $('#text-wrap').show();

  })
  $('#search-open').click(function(){
    $('#menu').addClass('main-main');
  })
});

function inviewExample() {
     var $example = $('#inview-example');
     var inview;

     if ($example.length) {
       inview = new Waypoint.Inview({
         element: $('#inview-example')[0],
         entered: function(direction) {
           $('.timer').each(function () {
               var $this = $(this);
               var val = $(this).data('count');
               jQuery({ Counter: 0 }).animate({ Counter: val }, {
                 duration: 1000,
                 easing: 'swing',
                 step: function () {
                   $this.text(Math.ceil(this.Counter));
                 }
               });
             });
         }
       })
     }
 }

$(window).on('load', function() {
  inviewExample();
});
    
</script>