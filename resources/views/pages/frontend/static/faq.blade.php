@extends('layouts.index_new')

@section('content')
<!------body-------------->
<div class="what-we-offer change-bg">
  <div class="ui main container">
    <div class="ui stackable wide column grid">
      <div class="wide column">
        {{-- <h1 class="PHeadinh-h1">FAQs</h1> --}}
        <div class="faq">
          {{-- New Faq --}}
          <div class="faq-section ui stackable two column grid">
            <div class="seven wide column tab">
            <button class="tablinks" onclick="openTab(event, 'firstTab')" id="defaultOpen">What is Crypto Currency?</button>
            <button class="tablinks" onclick="openTab(event, 'secondTab')">How Do I Fund My Account?</button>
            <button class="tablinks" onclick="openTab(event, 'thirdTab')">How Do I Trade?</button>
            <button class="tablinks" onclick="openTab(event, 'fourTab')">Why I should trade on ?</button>
            <button class="tablinks" onclick="openTab(event, 'fivethTab')">Can I Change the leverage for my account?
          </button>
            <button class="tablinks" onclick="openTab(event, 'sixthTab')">How do I Contact you?</button>
          </div>
          <div class="nine wide column tab-content">
          <div id="firstTab" class="tabcontent">
            <h3>What is Crypto Currency?</h3>
            <p>A cryptocurrency (or crypto currency) is a digital asset designed to work as a medium of exchange that uses strong cryptography to secure financial transactions, control the creation of additional units, and verify the transfer of assets. Cryptocurrencies use decentralized control as opposed to centralized digital currency and central banking systems. The decentralized control of each cryptocurrency works through distributed ledger technology, typically a blockchain, that serves as a public financial transaction database. Bitcoin, first released as open-source software in 2009, is generally considered the first decentralized cryptocurrency. Since the release of bitcoin, over 6,000 altcoins (alternative variants of bitcoin, or other cryptocurrencies) have been created.</p>
          </div>

          <div id="secondTab" class="tabcontent">
            <h3>How Do I Fund My Account?</h3>
            <p>Go To Sign Up, Fill the form, Make sure you filling the right info.After you account will be opened you will need to activate it threw first time deposit , using BTC , ETH or LTC will activate your account immediatly. Alternativly For Credit Card deposit , one of our CS will contact you shortly via phone call in order to complete the transaction</p> 
          </div>

          <div id="thirdTab" class="tabcontent">
            <h3>How Do I Trade?</h3>
            <p>If you believe an asset’s price is going to rise, you open a buy position (known as ‘going long’). If you think the asset’s price is going to fall, you open a sell position (known as ‘going short’). The performance of the market governs not just whether you make a profit or loss, but also by how much. So let’s say you think a particular market will rise, and you buy a CFD - your profit will be greater the further the market rises, and your losses greater the further it declines. The same rule applies if you expect a market to fall; you’ll make more the further the market drops, and lose more the further the market rises.</p>
          </div>

          <div id="fourTab" class="tabcontent">
            <h3>Why I should trade on ?</h3>
            <p>We have more than 1000 crypto currencies assets available as CFDs on the market and offer some of the most competitive spreads. Combining that with top class customer service and education makes us the preferred platform for both new and experienced traders. Your trades are executed automatically, with absolutely no requotes and NO SPREAD!</p>
          </div>

          <div id="fivethTab" class="tabcontent">
            <h3>Can I Change the leverage for my account?</h3>
            <p>No.
            At the moment support 1:50 leverage only.</p>
          </div>

          <div id="sixthTab" class="tabcontent">
            <h3>How do I Contact you?</h3>
            <p>For any inquiries please email us at : cs@</p>
          </div>
        </div>
          </div>

          {{-- end new faq --}}
          {{-- FAQ Item Start --}}
          <div class="faq-item">
            <h3 class="Headinh-hlight">What is Crypto Currency?</h3>
            <p>A cryptocurrency (or crypto currency) is a digital asset designed to work as a medium of exchange that uses strong cryptography to secure financial transactions, control the creation of additional units, and verify the transfer of assets. Cryptocurrencies use decentralized control as opposed to centralized digital currency and central banking systems. The decentralized control of each cryptocurrency works through distributed ledger technology, typically a blockchain, that serves as a public financial transaction database. Bitcoin, first released as open-source software in 2009, is generally considered the first decentralized cryptocurrency. Since the release of bitcoin, over 6,000 altcoins (alternative variants of bitcoin, or other cryptocurrencies) have been created.</p><p></p>
          </div>
          {{-- FAQ Item End --}}

          {{-- FAQ Item Start --}}
          <div class="faq-item">
            <h3 class="Headinh-hlight">How Do I Fund My Account?</h3>
            <p>Go To Sign Up, Fill the form, Make sure you filling the right info.After you account will be opened you will need to activate it threw first time deposit , using BTC , ETH or LTC will activate your account immediatly. Alternativly For Credit Card deposit , one of our CS will contact you shortly via phone call in order to complete the transaction</p><p></p>
          </div>
          {{-- FAQ Item End --}}

          {{-- FAQ Item Start --}}
          <div class="faq-item">
            <h3 class="Headinh-hlight">How Do I Trade?</h3>
            <p>If you believe an asset’s price is going to rise, you open a buy position (known as ‘going long’). If you think the asset’s price is going to fall, you open a sell position (known as ‘going short’). The performance of the market governs not just whether you make a profit or loss, but also by how much. So let’s say you think a particular market will rise, and you buy a CFD - your profit will be greater the further the market rises, and your losses greater the further it declines. The same rule applies if you expect a market to fall; you’ll make more the further the market drops, and lose more the further the market rises.</p><p></p>
          </div>
          {{-- FAQ Item End --}}

          {{-- FAQ Item Start --}}
          <div class="faq-item">
            <h3 class="Headinh-hlight">Why Should I Trade?</h3>
            <p>{{ env('_app_name_f') }} gives you a wider choice of products to access the excitement of the crypto currencies markets. Whether you have insights into news , analysis and so on you can now get easy access to trade them. You can trade with a 1:50 leverage and they provide an excellent alternative to suit a variety of trading styles or methods e.g. short or long-term investors can find the right product to complement their preferences.</p><p></p>
          </div>
          {{-- FAQ Item End --}}

          {{-- FAQ Item Start --}}
          <div class="faq-item">
            <h3 class="Headinh-hlight">Why I should trade on {{ env('_app_name_f') }}?</h3>
            <p>We have more than 1000 crypto currencies assets available as CFDs on the market and offer some of the most competitive spreads. Combining that with top class customer service and education makes us the preferred platform for both new and experienced traders. Your trades are executed automatically, with absolutely no requotes and NO SPREAD!</p><p></p>
          </div>
          {{-- FAQ Item End --}}

          {{-- FAQ Item Start --}}
          <div class="faq-item">
            <h3 class="Headinh-hlight">Can I Change the leverage for my account?</h3>
            <p>No.<br>At the moment {{ env('_app_name_f') }} support 1:50 leverage only.</p><p></p>
          </div>
          {{-- FAQ Item End --}}

          {{-- FAQ Item Start --}}
          <div class="faq-item">
            <h3 class="Headinh-hlight">How do I Contact you?</h3>
            <p>For any inquiries please email us at : <a href="mailto:cs&#64;{{ env('_app_domain') }}" title="Email"></a>cs&#64;{{ env('_app_domain') }}</p>
          </div>
          {{-- FAQ Item End --}}
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function openTab(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

document.getElementById("defaultOpen").click();
</script>

@endsection
