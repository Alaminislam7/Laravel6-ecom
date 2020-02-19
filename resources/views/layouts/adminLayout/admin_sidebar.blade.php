<!--sidebar-menu-->

<?php $url = url()->current(); ?>

<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
      <li <?php if (preg_match("/dashboard/i", $url)){ ?> class="active" <?php } ?>><a href="{{ URL::to('/admin-panel/dashboard') }}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
      
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span> <span class="label label-important">2</span></a>
        <ul <?php if (preg_match("/categor/i", $url)){ ?> style="display: block;" <?php } ?>>
          <li <?php if (preg_match("/add-category/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin-panel/add-category')}}">Add Category</a></li>
          <li <?php if (preg_match("/view-category/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin-panel/view-category')}}">View Categories</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Products</span> <span class="label label-important">2</span></a>
        <ul <?php if (preg_match("/product/i", $url)){ ?> style="display: block;" <?php } ?>>
          <li <?php if (preg_match("/add-product/i", $url)){ ?> class="active" <?php } ?>><a href="{{ URL::to('/admin-panel/add-product') }}">Add Product</a></li>
          <li <?php if (preg_match("/view-product/i", $url)){ ?> class="active" <?php } ?>><a href="{{ URL::to('/admin-panel/view-product') }}">View Products</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Orders</span> <span class="label label-important">1</span></a>
        <ul <?php if (preg_match("/Orders/i", $url)){ ?> style="display: block;" <?php } ?>>
          <li <?php if (preg_match("/view-orders/i", $url)){ ?> class="active" <?php } ?>><a href="{{ URL::to('/admin-panel/view-orders') }}">View Orders</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Users</span> <span class="label label-important">1</span></a>
        <ul <?php if (preg_match("/Users/i", $url)){ ?> style="display: block;" <?php } ?>>
          <li <?php if (preg_match("/view-users/i", $url)){ ?> class="active" <?php } ?>><a href="{{ URL::to('/admin-panel/view-users') }}">View Users</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Coupons</span> <span class="label label-important">2</span></a>
        <ul <?php if (preg_match("/coupon/i", $url)){ ?> style="display: block;" <?php } ?>>
          <li <?php if (preg_match("/add-coupon/i", $url)){ ?> class="active" <?php } ?>><a href="{{ URL::to('/admin-panel/add-coupon') }}">Add Coupon</a></li>
          <li <?php if (preg_match("/view-coupons/i", $url)){ ?> class="active" <?php } ?>><a href="{{ URL::to('/admin-panel/view-coupons') }}">View Coupons</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Banners</span> <span class="label label-important">2</span></a>
        <ul <?php if (preg_match("/banner/i", $url)){ ?> style="display: block;" <?php } ?>>
          <li <?php if (preg_match("/add-banner/i", $url)){ ?> class="active" <?php } ?>><a href="{{ URL::to('/admin-panel/add-banner') }}">Add Banner</a></li>
          <li <?php if (preg_match("/view-banners/i", $url)){ ?> class="active" <?php } ?>><a href="{{ URL::to('/admin-panel/view-banner') }}">View Banners</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Cms Pages</span> <span class="label label-important">2</span></a>
        <ul <?php if (preg_match("/cms-page/i", $url)){ ?> style="display: block;" <?php } ?>>
          <li <?php if (preg_match("/add-cms/i", $url)){ ?> class="active" <?php } ?>><a href="{{ URL::to('/admin-panel/add-cms') }}">Add cms</a></li>
          <li <?php if (preg_match("/view-cms/i", $url)){ ?> class="active" <?php } ?>><a href="{{ URL::to('/admin-panel/view-cms') }}">View Cms</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Currencies</span> <span class="label label-important">2</span></a>
        <ul <?php if (preg_match("/currencies/i", $url)){ ?> style="display: block;" <?php } ?>>
          <li <?php if (preg_match("/add-currency/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin-panel/add-currency')}}">Add Currency</a></li>
          <li <?php if (preg_match("/view-currencies/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin-panel/view-currencies')}}">View Currencies</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <!--sidebar-menu-->