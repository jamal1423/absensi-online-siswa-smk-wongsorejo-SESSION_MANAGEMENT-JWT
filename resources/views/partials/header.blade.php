<div class="main-header">
	<div class="menu-toggle">
		<a href="{{ url('/dashboard') }}">
          <!--<i style="margin-right: -20px;" class="i-Home1 text-muted header-icon" role="button" ></i>-->
          <img class="i-Home1 text-muted header-icon mt-2" src="{{ asset('gambar-umum/logo.png') }}" width="70%">
          SMKNJO
      	</a>
	</div>
	<!--<div class="d-flex align-items-center">
		<div class="search-bar">
			<input type="text" placeholder="Search">
			<i class="search-icon text-muted i-Magnifi-Glass1"></i>
		</div>
	</div>-->
	<div style="margin: auto" class="header-icon"></div>
	<div class="header-part-right">
		<!--<i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>-->
		<div class="dropdown">
			<a href="{{ url('/logout') }}"><i style="margin-right: -20px;" class="i-Power-2 text-muted header-icon" role="button" ></i></a>
		</div>
		
		<div class="dropdown">
			<div class="user col align-self-end">
			<i class="i-Refresh text-muted header-icon" onClick="window.location.reload();" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
			</div>
		</div>
	</div>
</div>