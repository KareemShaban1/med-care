   <!-- Topbar Start -->
   <div class="navbar-custom">
       <ul class="list-unstyled topbar-menu float-end mb-0">
          
           <li class="dropdown notification-list topbar-dropdown">
               <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                   <!-- <img src="{{asset('backend/assets/images/flags/us.jpg')}}" alt="user-image" class="me-0 me-sm-1" height="12">  -->
                   @if (App::getLocale() == 'ar')
                   {{ LaravelLocalization::getCurrentLocaleName() }}
                   <img src="{{ asset('backend/assets/images/flags/eg.png') }}" alt="">
                   @else
                   {{ LaravelLocalization::getCurrentLocaleName() }}
                   <img src="{{ asset('backend/assets/images/flags/us.png') }}" alt="">
                   @endif
                   <!-- <span class="align-middle d-none d-sm-inline-block">English</span> <i class="mdi mdi-chevron-down d-none d-sm-inline-block align-middle"></i> -->
               </a>

               <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu">

                   @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                   <a class="dropdown-item notify-item" rel="alternate" hreflang="{{ $localeCode }}"
                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                       {{ $properties['native'] }}
                   </a>
                   @endforeach

               </div>
           </li>



           <li class="dropdown notification-list">
               <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                   <span class="account-user-avatar">
                       <img src="{{asset('backend/assets/images/users/user.png')}}" alt="user-image" class="rounded-circle">
                   </span>
                   <span>
                       <span class="account-user-name"> {{ Auth::user()->name ?? 'Admin' }} </span>
                       <span class="account-position">{{Auth::user()->roles[0]->name ?? 'Admin'}}</span>
                   </span>
               </a>
               <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                   <!-- item-->
                   <div class=" dropdown-header noti-title">
                       <h6 class="text-overflow m-0">Welcome !</h6>
                   </div>

                   <!-- item-->
                   <a href="" class="dropdown-item notify-item">
                       <i class="mdi mdi-account-circle me-1"></i>
                       <span>My Account</span>
                   </a>

                   <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                       <i class="mdi mdi-account-edit me-1"></i>
                       <span>Settings</span>
                   </a>

                   <a href="javascript:void(0);" class="dropdown-item notify-item">
                       <i class="mdi mdi-lifebuoy me-1"></i>
                       <span>Support</span>
                   </a>

                   <a href="javascript:void(0);" class="dropdown-item notify-item">
                       <i class="mdi mdi-lock-outline me-1"></i>
                       <span>Lock Screen</span>
                   </a> -->

                 

               </div>
           </li>

       </ul>
       <button class="button-menu-mobile open-left">
           <i class="mdi mdi-menu"></i>
       </button>

   </div>
   <!-- end Topbar -->