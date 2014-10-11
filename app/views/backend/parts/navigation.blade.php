<nav class="navbar navbar-inverse" role="navigation" style="border-radius: 0px;">
		<div class="container-fluid">
		<div class="navbar-header">
			{{ HTML::link('/admin', 'Hairsaloon', array('class' => 'navbar-brand')) }}
		</div>
		<ul class="nav navbar-nav">
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Uporabniki <b class="caret"></b></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li>{{ HTML::link('/admin/users', 'Super administratorji') }}</li>
					<li>{{ HTML::link('/admin/users/2', 'Administratorji') }}</li>
					<li>{{ HTML::link('/admin/users/3', 'Frizerji') }}</li>
					<li>{{ HTML::link('/admin/users/5', 'Stranke') }}</li>
				</ul>
			</li>
			<li>{{ HTML::link('/admin/services', 'Storitve') }}</li>
			<li>{{ HTML::link('/admin/schedules', 'Urniki') }}</li>
			<li>{{ HTML::link('/admin/shifts', 'Izmene') }}</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>{{ HTML::link('', 'Hairsaloon page') }}</li>
			<li class="dropdown">
        		<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <b class="caret"></b></a>
        		<ul class="dropdown-menu">
		          <li>{{ HTML::link('admin/profile', 'Vaš profil') }}</li>
		          <li>{{ HTML::link('admin/logout', 'Odjava') }}</li>
		        </ul>
      		</li>
		</ul>
	</div>
</nav>