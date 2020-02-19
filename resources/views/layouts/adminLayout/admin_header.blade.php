<!--Header-part-->
  <div id="header">
    <h1><a href="{{ URL::to('/admin-panel/dashboard') }}">Broken Admin</a></h1>
  </div>
  <!--close-Header-part--> 
  
  
  <!--top-Header-menu-->
  <div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
      <li class=""><a title="" href="{{ URL::to('/admin-panel/settings') }}"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
      <li class=""><a title="" href="{{ URL::to('/logout') }}"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
    </ul>
  </div>
  <!--close-top-Header-menu-->
  <!--start-top-serch-->
  <div id="search">
    <input type="text" placeholder="Search here..."/>
    <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
  </div>
  <!--close-top-serch-->