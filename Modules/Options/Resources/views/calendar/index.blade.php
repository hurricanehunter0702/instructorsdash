@extends('core::layouts.app')
@section('title', __('Events'))
@push('head')
@endpush
@section('content')
<div class="container">
  <form id="form_create" method="post" action="{{ route('options.calendar-setting.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label class="form-label">@lang('Calendar Color')</label>
      <div class="input-group">
        <input type="color" name="bg_color" class="form-control" value="{{ isset($calendarSetting) ? $calendarSetting['bg_color'] : '' }}" />
      </div>
    </div>
    <div class="seo-content">
      <div class="form-group">
          <label class="form-label">@lang('SEO Title')</label>
          <input type="text" name="title" value="{{ isset($calendarSetting) ? $calendarSetting['title'] : '' }}"
              class="form-control">
      </div>
      <div class="form-group">
          <label class="form-label">@lang('SEO Description')</label>
          <textarea name="description" rows="3" class="form-control">{{ isset($calendarSetting) ? $calendarSetting['description'] : '' }}</textarea>
      </div>
      <div class="form-group">
          <label class="form-label">@lang('SEO Keywords')</label>
          <textarea name="keywords" rows="3" class="form-control">{{ isset($calendarSetting) ? $calendarSetting['keywords'] : '' }}</textarea>
      </div>
    </div>
    <div class="card-footer">
      <div class="d-flex">
        <a href="{{ route('options.calendar-setting.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
        <button type="submit" class="btn btn-success ml-auto">@lang('Save')</button>
      </div>
    </div>  
  </form>
</div>
@endsection
@push('scripts')
@endpush