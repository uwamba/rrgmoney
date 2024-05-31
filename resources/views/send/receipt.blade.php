<!DOCTYPE html>
<html>
<head>
  <title>Receipt</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
  <div class="container">
  <div class="row invoice row-printable">
      <div class="col-md-10">
          <!-- col-lg-12 start here -->
          <div class="panel panel-default plain" id="dash_0">
              <!-- Start .panel -->
              <div class="panel-body p30">

                      <!-- Start .row -->
                       <div class="col-lg-6">
                          <!-- col-lg-6 start here -->
                          {{$imageData = base64_encode(file_get_contents(public_path('images/rrgmoney.png')));}}
                          <div class="invoice-logo"> <img src="data:image/png;base64,{{$imageData}}" style="width: 80px; height: 40px"></div>
                          <h6>Kigali, Makuza, Ground Floor,KN 48 Street</h6>
                       </div>
                       <div class="row">

                          <div class="col-sm-2">
                                    <h6><strong>Receipt</strong> #{{$request->id}}</h6>
                                    <h6><strong>Receipt Date:</strong> {{date('Y-m-d H:i:s')}}</h6>
                           </div>
                       </div>

                       <div >

                                  <h5><strong>Receipt To</strong></h5>
                                  <p>Names: {{$request->first_name." ".$request->last_name}}</p>
                                  <p>Email:{{$request->sender_email}}</p>

                       </div>
                       <div class="invoice-items">
                              <div class="table-responsive" style="overflow: hidden; outline: none;"  tabindex="0">
                                  <table class="table table-bordered " border="1">
                                      <thead>
                                          <tr >
                                              <th class="per5 text-left">Description</th>
                                              <th class="per5 text-center">Qty</th>
                                              <th class="per25 text-center">Fee</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td class="per5 text-left">Money Transfer amount {{$request->amount_local_currency}} from {{$request->first_name}} to {{$request->names}}</td>
                                              <td class="text-center">1</td>
                                              <td class="text-left">{{$request->charges}}</td>
                                          </tr>


                                      </tbody>

                                  </table>
                              </div>
                       </div>
                          <div class="invoice-footer mt25">
                              <p class="text-center">Generated on Monday,{{date('Y-m-d H:i:s')}}</p>
                              <p class="text-center">Agent: {{$agent}}</a></p>
                          </div>
                      </div>
                      <!-- col-lg-12 end here -->
              </div>
          </div>
          <!-- End .panel -->
      </div>
      <!-- col-lg-12 end here -->
  </div>
  </div>
</body>
</html>


