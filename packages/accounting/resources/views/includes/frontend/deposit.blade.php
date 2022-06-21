<a href="{{ route('frontend.account.deposite', [Auth::user()]) }}" class="item {{ Route::currentRouteName()=='frontend.account.deposite' ? 'active' : '' }}" >
    {{-- <i class="list alternate outline icon"></i> --}}
    {{ __('deposit') }}
</a>