<?php

namespace Packages\Accounting\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Packages\Accounting\Models\PaymentMethod;

class PaymentMethodService {
  private $paymentMethod;

  public function __construct(PaymentMethod $paymentMethod) {
    $this->paymentMethod = $paymentMethod;
  }

  /**
   * Get accepted currencies for a given payment method
   *
   * @return \Illuminate\Support\Collection
   */
  public function acceptedCurrencies() {
    $paymentServiceClass = '\Packages\Accounting\Services\\' . ucfirst($this->paymentMethod->paymentGateway->code) . 'PaymentService';
    // first check if payment service class implements acceptedCurrencies method and use its output
    if (method_exists($paymentServiceClass, 'acceptedCurrencies')) {
      $paymentService = new $paymentServiceClass(config('accounting.' . $this->paymentMethod->paymentGateway->code));
      $paymentMethodCurrencies = collect($paymentService->acceptedCurrencies());
      // otherwise check allowed currencies in the DB
    } else {

      $paymentMethodCurrencies = $this->paymentMethod->currencies()->with('currency')->get()->pluck('currency.code');
      // if no specific currencies set for the given method return all currencies
      if ($paymentMethodCurrencies->isEmpty()) {
        $paymentMethodCurrencies = Currency::pluck('code');
      }
    }
    if (request()->segment(5) == 12) {
      $paymentMethodCurrencies = DB::table('currencies')->select('code')->where('code', 'btc')->first();
    } elseif (request()->segment(5) == 13) {
      $paymentMethodCurrencies = DB::table('currencies')->select('code')->where('code', 'eth')->first();
    } elseif (request()->segment(5) == 14) {
      $paymentMethodCurrencies = DB::table('currencies')->select('code')->where('code', 'ltc')->first();
    }
    return $paymentMethodCurrencies;
  }
}
