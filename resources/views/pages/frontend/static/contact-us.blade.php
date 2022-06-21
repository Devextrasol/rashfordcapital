@extends('layouts.index_new')

@section('content')
    <!-- -------contact-us section------- -->
    <div class="contact-us">
      <div class="ui main container">
        <div class="ui two column doubling stackable grid contact-form">
          
          <div class="column content-block">
            <div class="ui vertical accordion menu">
            <div class="item">
              <a class="active title">
                Trading Hours
                <i class="plus icon"></i>
                <i class="minus icon"></i>
              </a>
              <div class="active content">
                <div class="ui form">
                  <div class="grouped fields">
                    <p>Unlike trading stocks and commodities, the cryptocurrency market isn’t traded on a regulated exchange. Rather, the market is open 24/7 across a growing number of exchanges. Successful crypto traders understand that, although the market for digital currency is open nonstop</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <a class="title">
                Holiday Trading Hours
                <i class="plus icon"></i>
                <i class="minus icon"></i>
              </a>
              <div class="content">
                <div class="ui form">
                  <div class="grouped fields">
                    <p>Unlike other centralized markets or any trading stock markets, cryptocurrency market can't be 'closed'. It has no holidays or breaks. Some centralized exchanges may shut temporarily to update the servers, etc but these moments are really rare. Online crypto exchanges are way more dynamic than stocks-and-bonds ones.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="contact-wrapper">
            <h1 class="contact-heading">Phone Number</h1>
              <p><b>UK:</b> <a href="tel:+442070488128">+442070488128</a></p>
              <p><b>Whatsapp:</b><a href="tel:+447405326797">+447405326797</a></p>  
              <p><b>EMAIL:</b><a href="mailto:support@zurich-group.uk">support@zurich-group.uk</a></p>
            </div>
          </div>
          <div class="column">
              {{-- <h1 class="contact-heading">Send us an Email</h1>
              <p>The response time may be longer than usual, due to the high number of new traders. We are working around the clock to speed up the process. Thank you for your patience.</p> --}}
              <form class="ui form">
                <div class="field">
                  <select class="ui fluid dropdown" style="border-radius: 10px;">
                    <option value="">Reason of Request</option>
                  <option value="AL">Customer Service</option>
                  <option value="AK">Support</option>
                  <option value="AZ">Dealing Room</option>
                  <option value="AR">Finance Department</option>
                  </select>
                </div>
              <div class="field">
                <div class="two fields">
                  <div class="field">
                    <input type="text" name="name" placeholder="Name" style="border-radius: 10px;">
                  </div>
                  <div class="field">
                    <input type="text" name="surname" placeholder="Sur Name" style="border-radius: 10px;">
                  </div>
                </div>
              </div>
              <div class="field">
                <input type="text" placeholder="Email" style="border-radius: 10px;">
              </div>
              <div class="field">
                <input type="text" placeholder="Phone Number" style="border-radius: 10px;">
              </div>
              <div class="field">
                <input type="text" placeholder="Subject" style="border-radius: 10px;">
              </div>
              <div class="field">
                <textarea rows="8" placeholder="Your Message" style="border-radius: 10px;"></textarea>
              </div>
              <div class="ui button submit-btn" tabindex="0">SEND MESSAGE</div>
            </form>
          </div>
        </div>
  </div>
</div> 
@endsection