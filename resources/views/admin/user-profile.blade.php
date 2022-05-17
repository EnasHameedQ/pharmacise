@extends('layouts.admin.master')
@section('content')
  <x-alert type="status" />
  
  {{-- TODO STYLE PAGE (NAIF) 😅 --}}
  <main class="page-invoice-profile container">

    {{-- bg --}}
    <div class="t-bg"></div>

    {{-- user --}}
    <header class="t-header">
      {{-- avatar --}}
      <div class="t-avatar">
        <img src="{{ asset('uploads/user/' . $user->avatar) }}" alt="user avatar">
      </div>

      {{-- user info --}}
      <div class="t-user-desc">
        {{-- user name --}}
        <h3 class="t-user-name">
          <x-icon icon='home' />

          <span> {{ $user->name }} </span>
        </h3>

        {{-- item date --}}
        <div class="t-item">
          <x-icon icon='home' />

          <span>{{ $user->created_at }}</span>
        </div>
      </div>
    </header>

    {{-- content --}}
    <div class="t-content">
      {{-- log data --}}
      <div class="t-log-data">
        <header>
          <x-icon icon="home" />
          <h3 class="t-heading">@lang('heading.invoice-profile')</h3>
        </header>

        <div class="t-list">
          @if(isset($transactions))
            @foreach($transactions as $transaction)
              {{-- item --}}
              <div class="t-item">
                {{-- header --}}
                <div class="t-item-header">
                  {{-- title --}}
                  <h4 style="display:flex; align-items: center;">
                    <a href="{{ $transaction->meta['invoice_id'] }}">رقم العملية: {{ $transaction->uuid }}</a>
                  </h4>
                  {{-- date --}}
                  <span class="t-date">
                    <span>تاريخ</span> {{ $transaction->created_at->format('Y-m-d') }}
                    <span> بتوقيت </span>{{ $transaction->created_at->format('h:m:s A') }}
                  </span>
                </div>

                {{-- desc --}}
                <div class="t-desc">
                  <p>
                    <span>{{ $transaction->meta['state_1'] }}</span>
                    <span>( {{ $transaction->meta['depositor'] }} )</span>
                    <span>{{ $transaction->meta['state_2'] }}</span>
                    <span>( {{ $transaction->meta['recipient'] }} )</span>
                  </p>
                  <span> المبلغ: {{ $transaction->amount }}</span>

                </div>
                <a href="{{ route('admin.invoice', $transaction->meta['invoice_id']) }}" class="btn">عرض الفاتورة</a>
              </div>
            @endforeach
          @endif
        </div>


      </div>
    </div>

  </main>

@stop
