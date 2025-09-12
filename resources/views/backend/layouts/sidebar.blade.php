  <!-- ========== Left Sidebar Start ========== -->
  <div class="leftside-menu">

      <!-- LOGO -->
      <a class="logo text-center" href="#">
          <span class="logo-lg">
              <i class="fas fa-laptop-code"></i> <span class="logo-text">Medical Care</span>
          </span>
          <span class="logo-sm">
              <i class="fas fa-laptop-code"></i>
          </span>
      </a>

      <a class="logo text-center logo-dark">
          <span class="logo-lg text-white">
              Medical Care
              <!-- <img src="{{asset('backend/assets/images/logo-dark.png')}}" alt="" height="16"> -->
          </span>
          <span class="logo-sm text-white">
              Medical Care
              <!-- <img src="{{asset('backend/assets/images/logo_sm_dark.png')}}" alt="" height="16"> -->
          </span>
      </a>

      <div class="h-100" id="leftside-menu-container" data-simplebar="">

          <!--- Sidemenu -->
          <ul class="side-nav">
              <!-- Dashboard  -->
              <li class="side-nav-item">
                  <a href="{{route('dashboard')}}" class="side-nav-link">
                      <i class="uil-home-alt"></i>
                      <span>
                          {{__('Dashboard')}}
                      </span>
                  </a>
              </li>

              <!-- activity logs -->
              <li class="side-nav-item">
                  <a href="{{route('admin.activity-logs.index')}}" class="side-nav-link">
                      <i class="uil-money-withdraw"></i>
                      <span> {{__('Activity Logs')}} </span>
                  </a>
              </li>


                 <!-- banners -->
                 <li class="side-nav-item">
                  <a data-bs-toggle="collapse" href="#sidebarBanners" aria-expanded="false" aria-controls="sidebarBanners" class="side-nav-link">
                      <i class="uil-money-withdraw"></i>
                      <span> {{__('Banners')}} </span>
                      <span class="menu-arrow"></span>
                  </a>
                  <div class="collapse" id="sidebarBanners">
                      <ul class="side-nav-second-level">
                          <li>
                              <a href="{{route('admin.banners.index')}}">
                                  <span> {{__('Banners')}} </span>
                              </a>
                              <a href="{{route('admin.banners.trash')}}">
                                  <span> {{__('Trash Banners')}} </span>
                              </a>
                          </li>
                      </ul>
                  </div>
              </li>


              <!-- categories -->
              <li class="side-nav-item">
                  <a data-bs-toggle="collapse" href="#sidebarCategories" aria-expanded="false" aria-controls="sidebarCategories" class="side-nav-link">
                      <i class="uil-money-withdraw"></i>
                      <span> {{__('Categories')}} </span>
                      <span class="menu-arrow"></span>
                  </a>
                  <div class="collapse" id="sidebarCategories">
                      <ul class="side-nav-second-level">
                          <li>
                              <a href="{{route('admin.categories.index')}}">
                                  <span> {{__('Categories')}} </span>
                              </a>
                              <a href="{{route('admin.categories.trash')}}">
                                  <span> {{__('Trash Categories')}} </span>
                              </a>
                          </li>
                      </ul>
                  </div>
              </li>

              <!-- products -->
              <li class="side-nav-item">
                  <a data-bs-toggle="collapse" href="#sidebarProducts" aria-expanded="false" aria-controls="sidebarProducts" class="side-nav-link">
                      <i class="uil-money-withdraw"></i>
                      <span> {{__('Products')}} </span>
                      <span class="menu-arrow"></span>
                  </a>
                  <div class="collapse" id="sidebarProducts">
                      <ul class="side-nav-second-level">
                          <li>
                              <a href="{{route('admin.products.index')}}">
                                  <span> {{__('Products')}} </span>
                              </a>
                              <a href="{{route('admin.products.trash')}}">
                                  <span> {{__('Trash Products')}} </span>
                              </a>
                          </li>
                      </ul>
                  </div>
              </li>



              <!-- orders -->
              <li class="side-nav-item">
                  <a data-bs-toggle="collapse" href="#sidebarOrders" aria-expanded="false" aria-controls="sidebarOrders" class="side-nav-link">
                      <i class="uil-money-withdraw"></i>
                      <span> {{__('Orders')}} </span>
                      <span class="menu-arrow"></span>
                  </a>
                  <div class="collapse" id="sidebarOrders">
                      <ul class="side-nav-second-level">
                          <li>
                              <a href="{{route('admin.orders.index')}}">
                                  <span> {{__('Orders')}} </span>
                              </a>
                              <a href="">
                                  <span> {{__('Trash Orders')}} </span>
                              </a>
                          </li>
                      </ul>
                  </div>
              </li>


              </ul>

              <div class="clearfix"></div>

      </div>
      <!-- Sidebar -left -->
  </div>