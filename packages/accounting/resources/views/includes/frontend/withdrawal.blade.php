<a href="{{ route('frontend.account.withdrawals', [Auth::user()]) }}" class="item {{ Route::currentRouteName()=='frontend.account.withdrawals' ? 'active' : '' }}" >
    {{-- <i class="list alternate outline icon"></i> --}}
    {{ __('withdrawls') }}
</a>