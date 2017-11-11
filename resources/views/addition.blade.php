<?php
  $quote = array(
    (object) array('content' => 'To be a winner all we need is to give all we have'),
    (object) array('content' => 'Logic will get you from A to B <br /> But Imagination will take you anywhere'),
    (object) array('content' => 'Overthinking everything'),
    (object) array('content' => 'Worst case is the best case'),
    (object) array('content' => 'Love brings much happiness <br />Much more so than pining for someone brings pain'),
    (object) array('content' => 'In the end we only regret the chances we didn\'t take'),
    (object) array('content' => 'Choose a job you love and you <br />will never have to work a day in your life'),
    (object) array('content' => 'Never make permanent decisions on temporary feelings'),
    (object) array('content' => 'Just do! Don\'t think!'),
    (object) array('content' => 'Don\'t do unto others what you <br />don\'t want others do unto you'),
    (object) array('content' => 'I\'d like to love a person, who will stand for me <br />Even the world says, we\'re not meant to be'),
    (object) array('content' => 'Everything has beauty, but not everyone sees it'),
    (object) array('content' => 'Sometimes i wish, i could go back in life <br />Not to change things, but just to feel things twice'),
    (object) array('content' => 'If you don\'t fight for what you want <br />Don\'t cry for what you lost'),
    (object) array('content' => 'Friendship is a two way street<br />Not a one way road'),
    (object) array('content' => 'I hear and i forget; i see and i remember <br />I do and i understand'),
    (object) array('content' => 'A journey of thousand miles begins with a single step'),
    (object) array('content' => 'You may lose the people you love. You may lose the things you have. <br />But no matter what happens, never lose yourself'),
    (object) array('content' => 'Life is like a math, if it goes too easy <br />something is wrong'),
    (object) array('content' => 'Love is zero no matter how much you add to it <br />You will only lose out of misery'),
    (object) array('content' => 'Our greatest glory is not in never falling <br />but in getting up everytime we fall'),
    (object) array('content' => 'Everytime i thought i was being rejected from something good<br />i was actually redirected to something better'),
    (object) array('content' => 'When you have eliminated the impossible, what ever remains<br />however improbable, must be the truth'),
    (object) array('content' => 'Don\'t trust too much, Don\'t love too much, Don\'t hope too much<br />Because that too much, can hurt so much'),
    (object) array('content' => 'Dad, why do all the best people die? <br />My son, when you\'re in a garden, which flowers do you pick?<br />The most beautiful ones'),
  );
  $random = rand(0, count($quote) - 1);
?>

@section('footer-quote')
  <div id="footer-quote">
    <div class="row">
      <div class="col-md-12">
        <p class="text-center">
          <quote class="parisienne mrg-b-20">
            {!! $quote[$random]->content !!}
          </quote>
        </p>
      </div>
    </div>
  </div>
@endsection

@section('footer-content')
  <div class="container">
    <div class="row padd-tb-40 padd-lr-10">
      <div class="col-md-4 mrg-tb-20">
        <div class="footer-brand">
          <h2>LENGKO</h2>
        </div>
        <div class="font-size-18">
          <br /> Jl. Sendirian Aja No. 99, Kav. Kawin, Bandung, Jawa Barat
          <br />
          <br /> Telepon: +(62)222 0000 2017
          <br /> Fax: +(62)222 1111 2017
        </div>
      </div>
      <div class="col-md-8 mrg-tb-20">
        <iframe width="100%" height="450px" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAhKEZJfkMoTMHj-X3y0pH5dvhihShocPs&q=Bandung" allowfullscreen>

        </iframe>
      </div>
    </div>
  </div>
@endsection

@section('footer-copyright')
  <div id="footer-copyright">
    <div class="row">
      <div class="col-md-12">
        <p class="text-center">
          Copyright &copy; LENGKO 2017 all right reserved
          <br /> Developed with &#x2661; in Bandung by LENGKO Team
        </p>
      </div>
    </div>
  </div>
@endsection

@section('shopping-cart')
  <div id="shopping-cart" class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="pull-right" style="margin: 5px;">
        0 Pesanan <i class="large material-icons" style="vertical-align:middle;" aria-hidden="true">shopping_cart</i>
      </div>
    </div>
  </div>
@endsection
