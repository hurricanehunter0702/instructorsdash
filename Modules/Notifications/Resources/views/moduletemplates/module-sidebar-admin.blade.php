@can('admin')
<li class="nav-item {{ (request()->is('settings.notifications*')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('settings.notifications.index') }}">
		<i class="fa fa-bell"></i>
		<span>@lang('Notifications')</span>
	</a>
</li>
<li class="nav-item {{ (request()->is('settings.setup-requests.*')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('settings.setup-requests.index') }}">
		<i class="fa fa-list"></i>
		<span>@lang('Setup requests')</span>
	</a>
</li>
@endcan


