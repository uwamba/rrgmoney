<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
@include('agent.components.head')
@include('agent.components.header')

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 mb-4">Account Summary</h1>
                    <h1 class="display-6 mb-4">Users</h1>
                    
                    <div class="number-diy">
                        <div class="data" data-number="{{number_format($balance, 2)}}"></div>
                    </div>
                    <div class="row g-4 g-sm-5 justify-content-center">
                        <div class="col-sm-5">
                            <div class="about-fact btn-square flex-column rounded-circle bg-primary ms-sm-auto">
                                <p class="text-white mb-0">Stock</p>
                                <h3 class="text-white mb-0" >{{number_format($balance, 2)}}</h3>
                            </div>
                        </div>
                        <div class="col-sm-5 text-start">
                            <div class="about-fact btn-square flex-column rounded-circle bg-secondary me-sm-auto">
                                <p class="text-white mb-0">Last Transfer </p>
                                <h3 class="text-white mb-0" >{{number_format($lastSent, 2)}}</h3>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="about-fact mt-n130 btn-square flex-column rounded-circle bg-dark mx-sm-auto">
                                <p class="text-white mb-0">Commissions</p>
                                <h3 class="text-white mb-0" >{{number_format($commission, 2)}}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.5s">

                    <div class="row">
                        <div class="col-sm-14">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Calculator</h5>
                              <p class="card-text">Calculate amount to receive or to send</p>
                              <a href="{{ route('receive.calculator') }}" class="btn btn-primary">Clic Here</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-14">
                            <div class="card">
                              <div class="card-body">
                                <h5 class="card-title">Send</h5>
                                <p class="card-text">Sent money to a recipient</p>
                                <a href="{{ route('send.transfer') }}" class="btn btn-primary">Clic Here</a>
                              </div>
                            </div>
                          </div>
                        <div class="col-sm-14">
                          <div class="card">
                           <div class="card-body">
                             <h5 class="card-title">Receive</h5>
                             <p class="card-text">Sent money to a recipient</p>
                             <a href="{{ route('receive.transfer') }}" class="btn btn-primary">Clic Here</a>
                           </div>
                          </div>
                        </div>
                        <div class="col-sm-14">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Cash out</h5>
                              <p class="card-text">Cash out the money you receievd </p>
                              <a href="{{ route('AgentCashOut.create') }}" class="btn btn-primary">Click here</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-14">
                            <div class="card">
                              <div class="card-body">
                                <h5 class="card-title">Register New Customer</h5>
                                <p class="card-text">register new customer to send and receive money</p>
                                <a href="{{ route('users.create') }}" class="btn btn-primary">Click here</a>
                              </div>
                            </div>
                          </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Features Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-0 feature-row">
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                    <div class="feature-item border h-100 p-5">
                        <div class="icon-box-primary mb-4">
                            <i class="text-solid bi bi-flag" style="color: #4bc729;"></i>
                        </div>
                        <h5 class="mb-3">Countries</h5>
                        <p class="mb-0">Rwanda,Kenya,Uganda,Tanzani.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                    <div class="feature-item border h-100 p-5">
                        <div class="icon-box-primary mb-4">
                            <i class="bi bi-arrow-left-right" style="color: #4813a9;"></i>
                        </div>
                        <h5 class="mb-3">Payment Channel</h5>
                        <p class="mb-0">Bank Deposit,Mobile Money.Cash</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                    <div class="feature-item border h-100 p-5">
                        <div class="icon-box-primary mb-4">
                            <i class="bi bi-cash-coin text-dark"></i>
                        </div>
                        <h5 class="mb-3">Pricing</h5>
                        <p class="mb-0">Percentile,Flat fee</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.7s">
                    <div class="feature-item border h-100 p-5">
                        <div class="icon-box-primary mb-4">
                            <i class="bi bi-headphones text-dark"></i>
                        </div>
                        <h5 class="mb-3">24/7 Support</h5>
                        <p class="mb-0">Tel: +250 xxxxxxx, Email: email@email.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type='text/javascript'>

    /*
 * @Author: Patrick-Jun
 * @Date: 2020-08-03 11:21:42
 * @Last Modified by: Patrick-Jun
 * @Last Modified time: 2020-11-03 23:49:34
 * @Git: https://github.com/Patrick-Jun/jQuery.rollNumber.git
 */

(function($) {
  $.fn.rollNumber = function(options) {
    let $self = this;
    if (options.number === undefined) return;
    let number = options.number,
        speed = options.speed || 500,
        interval = options.interval || 100,
        fontStyle = options.fontStyle,
        rooms = options.rooms || String(options.number).split('').length,
        _fillZero = !!options.rooms;
    fontStyle.color = fontStyle.color || '#000'; 
    fontStyle['font-size'] = fontStyle['font-size'] || 14;
    // 计算单个数字宽度
    $self.css({
      display: 'flex',
      'justify-content': 'center',
      'align-items': 'center',
      'font-size': fontStyle['font-size'],
      color: 'rgba(0,0,0,0)'
    }).text(number);
    let _height = $self.height();
    let space = options.space || _height/2;
    $self.empty(options);

    // 添加滚动元素
    let numberHtml = '';
    for (let i = 0; i < 10; i++) numberHtml += `<span style="display: block; width: ${ space }px; height: ${ _height }px; line-height: ${ _height }px; text-align: center; ${ Object.keys(fontStyle).join(': inherit; ') + ': inherit;' }">${ i }</span>`;
    numberHtml = `<div class="_number" style="width: ${ space }px; height: ${ _height }px; line-height: ${ _height }px; display: flex; justify-content: center; align-items: center;"><div style="position: relative; width: ${ space }px; height: ${ _height }px; overflow: hidden;"><div style="position: absolute; width: 100%;">${ numberHtml }</div></div></div>`
    
    // 处理数字
    let numArr = String(number).split('');
    if (_fillZero) { // 前置补0
      // 当含有小数时，补0位数应该+1
      if (String(number).indexOf('.') !== -1) rooms++;
      for (let i = numArr.length; i < rooms; i++) {
        numArr.unshift(0);
      }
      number = numArr.join('');
    }
    if (!!options.symbol) { // 含千分位
      let appendHtml = [];
      let symbolHtml = `<span style="display: block; width: ${ space }px; height: ${ _height }px; line-height: ${ _height }px; text-align: center; ${ Object.keys(fontStyle).join(': inherit; ') + ': inherit;' }">${ options.symbol }</span>`;
      let dotHtml = `<span style="display: block; width: ${ space }px; height: ${ _height }px; line-height: ${ _height }px; text-align: center; ${ Object.keys(fontStyle).join(': inherit; ') + ': inherit;' }">.</span>`;
      symbolHtml = `<div class="_number" style="width: ${ space }px; height: ${ _height }px; line-height: ${ _height }px; display: flex; justify-content: center; align-items: center;"><div style="position: relative; width: ${ space }px; height: ${ _height }px; overflow: hidden;"><div style="position: absolute; width: 100%;">${ symbolHtml }</div></div></div>`;
      dotHtml = `<div class="_number" style="width: ${ space }px; height: ${ _height }px; line-height: ${ _height }px; display: flex; justify-content: center; align-items: center;"><div style="position: relative; width: ${ space }px; height: ${ _height }px; overflow: hidden;"><div style="position: absolute; width: 100%;">${ dotHtml }</div></div></div>`;
      
      let numarr = String(number).split('.');
      const re = /(-?\d+)(\d{3})/;
      while (re.test(numarr[0])) {
        numarr[0] = numarr[0].replace(re, '$1,$2');
      }
      numArr = (numarr.length > 1 ? numarr[0] + '.' + numarr[1] : numarr[0]).split('');
      for (let i = 0; i < numArr.length; i++) {
        if (isNaN(Number(numArr[i]))) { // 判断是否是符号
          if (numArr[i] === '.') { // 判断小数
            appendHtml.push(dotHtml);
          } else {
            appendHtml.push(symbolHtml);
          }
        } else {
          appendHtml.push(numberHtml);
        }
      }
      $self.append(appendHtml.join('')).css(fontStyle);
    }else {
      $self.append(numberHtml.repeat(rooms)).css(fontStyle);
      // 处理小数符号
      if (String(number).indexOf('.') !== -1) {
        $($self.find('._number')[String(number).indexOf('.')]).find('span')[0].innerHTML = '.';
      }
    }

    let domArr = $self.find('._number');

    for (let i = 0; i < domArr.length; i++) {
      setTimeout(function(dom, n) {
        $(dom.children[0].children[0]).animate({
          'top': -_height * n + 'px' // 千分位*number = NaN px
        }, speed);
      }, interval*(domArr.length - i), domArr[i], numArr[i]);
    }
  }
})(jQuery);



    </script>
      <script type='text/javascript'>


// 简单demo
$('.number-normal .data').rollNumber({
  number: 123456,   //必需：显示数据
  // speed: 100,    //可选：每个数字滚动时长，取值"slow"、"fast" 或毫秒，默认：500
  // interval: 100, //可选：前后两个数字间隔时长，毫秒，默认：100
  // rooms: 9,      //可选：显示总位数，需大于等于数据长度，大于数据长度时前面补0，默认：等于数据长度
  // space: 90,     //可选：每个数字宽度，默认为：高度/2
  // symbol: ',',   //可选：千分位占位符，默认：false
  fontStyle: {      //可选：数字字体样式
    'font-size': 100,    //可选：默认14
    color: '#FF0000',    //可选：默认black
    // 其他文字样式，标准css均可以设置
    // 'font-family': 'LetsgoDigital',
    // 'font-weight': 700
  }
})

/*
* 深度自定义demo
* 内部样式结构：._number > div > div > span
* 该demo在css中，自定义了内部 ._number和span的样式
*/
$diy = $('.number-diy .data');
$diy.rollNumber({
  number: $diy[0].dataset.number, 
  speed: 500, 
  interval: 200,
  rooms: 9,
  space: 110,
  symbol: ',', 
  fontStyle: {
    'font-size': 102,
    'font-family': 'LetsgoDigital',
  }
})




          </script>


    
     
   
    @extends('customer.components.footer')
    @include('common.logout-modal')
</body>
</html>
