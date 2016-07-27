@extends('index.misc')

@section('title', trans('index.frequently_asked_questions'))

@section('misc-content')
<section>
  <img class="about-banner" src="{{asset('/img/question-banner.jpg')}}">
  <div class="event-title clear">
    <p class="p1 fl">
      {{trans('index.frequently_asked_questions')}}
    </p>
    <div class="faq-search hide">
      <input placeholder="{{trans('misc.search_question')}}">
      <a>
        <i class="iconfont icon-search"></i>
      </a>
    </div>
  </div>
  <div class="faq-warp clear">
@include('index.faq-category')
    <div class="faq-result">
      <?php for($i=1;$i<=$num;$i++) {?>
      <div class="faq-item">
        <p class="p1">{{$i}}.{{trans('misc.faq_'.$category.'_q_'.$i)}}</p>
        <p class="p2">{{trans('misc.faq_'.$category.'_c_'.$i)}}</p>
        <p class="p3">{{trans('misc.faq_'.$category.'_a_'.$i)}}</p>
      </div>
      <?php } ?>
    </div>
  </div>
</section>
@endsection

@section('script')
<script src="{{asset('/js/src/faq.js')}}"></script>
@endsection

@section('inner-script')
@parent
<script type="text/javascript">
$(function(){
  var faqCategory = '{{$category}}';
  var faqNav = $(".faq-warp ul.faq-type li a");
  console.log(faqNav);
  var len = faqNav.length;
  for (var i = 0; i < len; i++) {
    var link = faqNav.get(i);
    if (link.href && link.href.indexOf(faqCategory) !== -1) {
      $(link).parent().addClass('active').siblings().removeClass('active');
      var $parentUl = $(link).parent().parent();
      if($parentUl.hasClass('sub-faq-type')) {
          $parentUl.parent().addClass('active').siblings().removeClass('active');
      }
      return;
    }
  }
});
</script>
@endsection