<nav class="navbar navbar-inverse" role="navigation" style="border-radius: 0px;">
		<div class="container-fluid">
		<div class="navbar-header">
			{{ HTML::link('/admin', 'Hairsaloon', array('class' => 'navbar-brand')) }}
		</div>
		<ul class="nav navbar-nav">
			<li>{{ HTML::link('/admin/users', 'Users') }}</li>
			<li>{{ HTML::link('/admin/groups', 'Groups') }}</li>
			<li>{{ HTML::link('/admin/tags', 'Tags & Categories') }}</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>{{ HTML::link('', 'Hairsaloon page') }}</li>
			<li>{{ HTML::link('admin/logout', 'Logout') }}</li>
		</ul>
	</div>
</nav>