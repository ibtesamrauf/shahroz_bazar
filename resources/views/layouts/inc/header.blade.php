<?php

use App\Models\Category;

// Search parameters
$queryString = (Request::getQueryString() ? ('?' . Request::getQueryString()) : '');

// Get the Default Language
$cacheExpiration = (isset($cacheExpiration)) ? $cacheExpiration : config('settings.other.cache_expiration', 60);
$defaultLang = Cache::remember('language.default', $cacheExpiration, function () {
    $defaultLang = \App\Models\Language::where('default', 1)->first();
    return $defaultLang;
});

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';
if (config('settings.geo_location.country_flag_activation')) {
    if (!empty(config('country.code'))) {
        if (\App\Models\Country::where('active', 1)->count() > 1) {
            $multiCountriesIsEnabled = true;
            $multiCountriesLabel = 'title="' . t('Select a Country') . '"';
        }
    }
}

// Logo Label
$logoLabel = '';
if (getSegment(1) != trans('routes.countries')) {
    $logoLabel = config('settings.app.name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
}
?>
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'>

<style>
    .header-wrapper{
        font-family: "Open Sans" !important;
    }
    .header-search{
        min-height:56px;background: #d8d6d9;color: #3c3241;
        padding: 0px 5px 12px;
    }
    li.postadd a.btn-awesome{
        border-radius: 2px; border: 0; padding: 0 6px; vertical-align: middle; height: 14px; line-height: 31px; overflow: hidden; text-align: center; font-family: inherit; font-weight: 400; border: 1px solid #e57373;color:#fff;
    }
    .navbar-default .navbar-nav>li.postadd a.btn-awesome{
        color:#fff;
        font-size: 12px;
        text-transform: uppercase;margin-top:-1px;
    }
    a.btn-awesome-2{
        border-radius: 2px; border: 0; padding:8px 12px; vertical-align: middle; font-weight: 400; border: 1px solid #e57373;color:#111;font-size: 12px;text-transform: uppercase;
    }
    a:hover.btn-awesome-2{
        background-color:#e57373;
        color:#fff;
    }
    .navbar-default .navbar-nav>li.postadd a{
        padding: 8px 0px;
        height:37px;
    }

    .navbar-default .navbar-nav>li.postadd a:hover.btn-awesome{
        background-color:#e57373;
        color:#fff;
    }
    .nav-justified {
      background-color: #fff;
      font-size: 12px;
    }
    .nav-justified > li > a {
      padding-top: 10px;
      padding-bottom: 10px;
      margin-bottom: 0;
      font-weight: bold;
      text-align: center;
      color:#111;
    }
    .nav-justified > .active > a,
    .nav-justified > .active > a:hover,
    .nav-justified > .active > a:focus {
      background-color: #f5f5f5;
     
    }
    .nav-justified > li:first-child > a {
      border-radius: 5px 5px 0 0;
    }
    .nav-justified > li:last-child > a {
      border-bottom: 0;
      border-radius: 0 0 5px 5px;
    }

    @media (min-width: 768px) {
      .nav-justified {
        max-height: 60px;
      }
      .nav-justified > li > a {
        border-right: 1px solid #d5d5d5;
        border-left: 1px solid #d5d5d5;
      }
      .nav-justified > li:first-child > a {
        border-left: 0;
        border-radius: 5px 0 0 5px;
      }
      .nav-justified > li:last-child > a {
        border-right: 0;
        border-radius: 0 5px 5px 0;
      }
    }
    .header-search{
        padding-top:15px;
    }
    .navbar-default .navbar-nav>li>a {
    font-size: 12px;
}
      .col-lg-2.no-right, .col-md-5.no-right,  .col-sm-5.no-right,  .col-md-2.no-right, .col-lg-2.no-right, .col-sm-2.no-right,  .col-xs-12.no-right, .col-xs-2.no-right {

                padding-right:3px;
                padding-left: 3px;
        }

    .header-search .form-control {border-radius: 0px;border-color:#bbb;}  
    .header-search .btn.btn-primary {border-radius: 0px;}

.wide-intro {
    height: 350px;
    max-height:350px;
}
.copy-info{
    color:#f0ece6;
    font-size: 14px;
}
.paymanet-method-logo{
    margin:0px;
    padding:0px;
}
.footer-nav li a{
    font-size: 14px;
}
.footer-title{
    font-size: 18px;
}
.category-links ul li a{
    color:#111;
}
.header-top{
    background-color:#2c2134;  
    color:#fff;
    height:40px;
}
.header{
    background-color:#36263b;  
    height:90px;
        padding-top: 22px;
}
.navbar-right{
    margin-top:0px;
}
.navbar-nav>li>a{
    color: #fff;
    padding-top: 9px;
    padding-bottom: 9px;
    font-weight: 400;
    font-size: 12px;
}
.navbar-nav>li>a:hover{
    color:#f5f5f5;
}
.logo-title span{
    color:#fff;
    font-size:14px;
}
.navbar-header{
    padding-top:9px;
}
.wide-intro h1 {
    line-height:60px;
}
.skin-green .logo, .skin-green .logo-title{
    color:#fff;
}
.navbar-brand{
    padding:0px;
}
body{
    font-family: "Open Sans" !important;
}
</style>
<div class="header-wrapper">
    <div class="header-top hidden-xs">
        <nav class="navbar" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    {{-- Toggle Nav --}}
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {{-- Logo --}}
                    <a href="{{ lurl('/') }}">
                        <span class="glyphicon glyphicon-home" style="color:#fff;"></span>
                    </a>

                    <nav class="wsmenu clearfix">
          <ul class="mobile-sub wsmenu-list">
            
                @if (count(LaravelLocalization::getSupportedLocales()) > 1)
                                   
                                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                @if (strtolower($localeCode) == strtolower(config('app.locale')))
                                                    <?php
                                                       
                                                        $lang_code = trim(strtolower($localeCode));
                                                    ?>
                                                   
                                                @endif
                                            @endforeach
                                        @else
                                            $lang_code = trim($defaultLang->id);
                                        @endif
            @php
                $p_categories = DB::table('categories')->where([['parent_id', '=', 0],['translation_lang', '=', $lang_code]])->get();
                //dd($lang_code);
            @endphp
            @if (isset($p_categories) and $p_categories->count() > 0)
                @php
                    $i = 1;
                @endphp
                @foreach($p_categories as $key => $cat)
                    <?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug]; 
                        if($cat->name == 'Fashion, Home & Garden'){
                            continue;
                        }
                        if($cat->name == 'Globazzar HR'){
                            continue;
                        }
                    ?>


                    <li><a href="#">{{ $cat->name }}</a>
                      <div class="megamenu clearfix halfmenu">
                        <div class="container-fluid">
                          <div class="row">
                        

                            @php

                                //if($cat->parent_id != 0){
                                //    $parentId = $cat->parent_id;
                                //}else{
                                    $parentId = $cat->translation_of;
                                //}
                                // Get SubCategories by Parent Category ID
                                
                                //$subcats = Category::where([['parent_id', '=', //$parentId],['translation_lang', '=', $lang_code]])->get();

                                $subcats = DB::table('categories')->where([['parent_id', '=', $parentId],['translation_lang', '=', $lang_code]])->get();

                                $count = count($subcats)/2;

                                $k = 0;
                                
                            @endphp
                            <div class="col-lg-12">
                            <div class="row">
                            <ul class="col-lg-6 col-md-12 col-xs-12 link-list">
                            

                            @foreach($subcats as $subcat)
                                @php 
                                
                                    $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug];
                                    $k++;
                                @endphp
                                <li><a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">{{ str_limit($subcat->name, 30) }}</a></li>
                                @if($k > $count)
                                </ul>
                                <ul class="col-lg-6 col-md-12 col-xs-12 link-list">
                                @endif
                            @endforeach
                            </ul>
                            </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-xs-12" style="display:none">

                                <?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug]; ?>
                        <a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">
                            <img src="{{ \Storage::url($cat->picture) . getPictureVersion() }}" class="img-responsive" alt="img">
                
                        </a>

                            </div>
                            
                            
                          </div>
                        </div>
                      </div>
                    </li>


                    <li class="dropdown" style="display:none">
                        <!--<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">{{ strtoupper($cat->name) }}</a>-->

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                            {{ strtoupper($cat->name) }}
                        </a>

                        <ul class="dropdown-menu">
                            @php
                                //$subcats = $categories->where('parent_id', $cat->id);
                                //$subcats = Category::where('parent_id', $cat->id)->get();
                                //$subcats = $categories;
                                //var_dump($subcats);


                                $languageCode = 'en';
                                $parentId = $cat->id;
                                
                                // Get SubCategories by Parent Category ID
                                
                                $subcats = Category::where('parent_id', $parentId)->orderBy('lft')->get();


                                
                            @endphp
                            @foreach($subcats as $subcat)
                                @php
                                    $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug];
                                @endphp
                                <li tabindex="-1"><a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">{{ $subcat->name }}</a></li>
                            @endforeach
                        </ul>
                               
                    

                    </li>
                    @php
                        $i++;
                        if($i > 5):
                            break;
                        endif;
                    @endphp
                @endforeach
            @endif
          </ul>
        </nav>
                </div>
                <div class="navbar-collapse collapse">

                    <ul class="nav navbar-nav navbar-right">
                        @if (count(LaravelLocalization::getSupportedLocales()) > 1)
                                    <!-- Language selector -->
                                    <li class="dropdown lang-menu pull-left" >
                                        <button class="btn btn-default dropdown-toggle" style="color: #fff; background-color: #2c2134; border-color: #2c2134; font-weight: 400;font-size: 12px;padding-top:9px;" type="button" data-toggle="dropdown">
                                            {{ strtoupper(config('app.locale')) }}
                                            <span class="caret hidden-sm"> </span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                @if (strtolower($localeCode) != strtolower(config('app.locale')))
                                                    <?php
                                                        // Controller Parameters
                                                        $attr = [];
                                                        $attr['countryCode'] = config('country.icode');
                                                        if (isset($uriPathCatSlug)) {
                                                            $attr['catSlug'] = $uriPathCatSlug;
                                                            if (isset($uriPathSubCatSlug)) {
                                                                $attr['subCatSlug'] = $uriPathSubCatSlug;
                                                            }
                                                        }
                                                        if (isset($uriPathCityName) && isset($uriPathCityId)) {
                                                            $attr['city'] = $uriPathCityName;
                                                            $attr['id'] = $uriPathCityId;
                                                        }
                                                        if (isset($uriPathPageSlug)) {
                                                            $attr['slug'] = $uriPathPageSlug;
                                                        }
                                                        
                                                        // Default
                                                        // $link = LaravelLocalization::getLocalizedURL($localeCode, null, $attr);
                                                        $link = lurl(null, $attr, $localeCode);
                                                        $localeCode = strtolower($localeCode);
                                                    ?>
                                                    <li>
                                                        <a href="{{ $link }}" tabindex="-1" rel="alternate" hreflang="{{ $localeCode }}">
                                                            <span class="lang-name"> {{{ $properties['native'] }}} </span>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endif
                        @if (!auth()->check())
                            <li>
                                @if (config('settings.security.login_open_in_modal'))
                                    <a href="#quickLogin" data-toggle="modal"> {{ t('Log In') }} </a>
                                @else
                                    <a href="{{ lurl(trans('routes.login')) }}"> {{ t('Log In') }} </a>
                                @endif
                            </li>
                            <li><a href="{{ lurl(trans('routes.register')) }}">{{ t('Register') }}</a></li>
                            <li style="display:none">
                                <a href="#"  ><i class="glyphicon glyphicon-search"></i></a>
                            </li>
                            
                        @else
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span>{{ auth()->user()->name }}</span>
                                    <i class="icon-down-open-big fa hidden-sm"></i>
                                </a>
                                <ul class="dropdown-menu user-menu">
                                    <li class="active">
                                        <a href="{{ lurl('account') }}">
                                            <i class="icon-home"></i> {{ t('Personal Home') }}
                                        </a>
                                    </li>
                                    <li><a href="{{ lurl('account/my-posts') }}"><i class="icon-th-thumb"></i> {{ t('My ads') }} </a></li>
                                    <li><a href="{{ lurl('account/favourite') }}"><i class="icon-heart"></i> {{ t('Favourite ads') }} </a></li>
                                    <li><a href="{{ lurl('account/saved-search') }}"><i class="icon-star-circled"></i> {{ t('Saved searches') }} </a></li>
                                    <li><a href="{{ lurl('account/pending-approval') }}"><i class="icon-hourglass"></i> {{ t('Pending approval') }} </a></li>
                                    <li><a href="{{ lurl('account/archived') }}"><i class="icon-folder-close"></i> {{ t('Archived ads') }}</a></li>
                                    <li><a href="{{ lurl('account/conversations') }}"><i class="icon-mail-1"></i> {{ t('Conversations') }}</a></li>
                                    <li><a href="{{ lurl('account/transactions') }}"><i class="icon-money"></i> {{ t('Transactions') }}</a></li>
                                </ul>
                            </li>
                            <li>
                                @if (app('impersonate')->isImpersonating())
                                    <a href="{{ route('impersonate.leave') }}">
                                        {{ t('Leave') }}
                                    </a>
                                @else
                                    <a href="{{ lurl(trans('routes.logout')) }}">
                                        {{ t('Log Out') }}
                                    </a>
                                @endif
                            </li>
                            <li>
                                <a href="#" onclick="myFunction()" ><i class="glyphicon glyphicon-search"></i></a>
                            </li>
                           
                        @endif
                     
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="header">

       <div class="container">
       <div class="row">
       <div class="col-md-12">
       <div class="pull-left">
       <a href="{{ lurl('/') }}" class="navbar-brand logo logo-title">
       globazzar     
       </a>
        </div>
       <div class="postadd pull-right">
                            @if (config('settings.single.guests_can_post_ads') != '1')
                                <a class="btn btn-block btn-border btn-post btn-add-listing" href="#quickLogin" data-toggle="modal">
                                    <i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
                                </a>
                            @else
                                <a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ lurl('posts/create') }}">
                                    <i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
                                </a>
                            @endif
        </div>
        </div>
        </div>
        </div>
    </div>
    @if (isset($categories) and $categories->count() > 0)
    <?php $attr = ['countryCode' => config('country.icode')]; ?>
    <div class="header-search" id="header-category" style="display:none">
        
        <div class="container">
        <div class="row">
        <div class="col-md-12">
        <center>
        <form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET" class="form-inline">
            

            <div class="form-group" >
                <input type="text" name="q" class="form-control" placeholder="{{ t('What?') }}" value="">
            </div>
            <div class="form-group">
                <input type="hidden" id="lSearch" name="l" value="">
                <input type="text" id="locSearch" name="location" class="form-control"
                                               placeholder="{{ t('Senegal') }}" value="">
            </div>
            
            <input class="btn btn-primary" type="submit" value="{{ t('Find') }}" style="padding: 7px 12px;" />
            
            {!! csrf_field() !!}

            
        </form>
        </center>

        </div>
        
        </div>
        </div>
    </div>
    <div class="header-category hidden-xs wsmain" style="display:none">
        
        <nav class="wsmenu clearfix">
          <ul class="mobile-sub wsmenu-list">
            @if (isset($categories) and $categories->count() > 0)
                @php
                    $i = 1;
                @endphp
                @foreach($categories as $key => $cat)
                    <?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug]; 
                        if($cat->name == 'Fashion, Home & Garden'){
                            continue;
                        }
                        if($cat->name == 'Globazzar HR'){
                            continue;
                        }
                    ?>


                    <li><a href="#">{{ $cat->name }}</a>
                      <div class="megamenu clearfix">
                        <div class="container-fluid">
                          <div class="row">
                            @php
                                //$subcats = $categories->where('parent_id', $cat->id);
                                //$subcats = Category::where('parent_id', $cat->id)->get();
                                //$subcats = $categories;
                                //var_dump($subcats);


                                $languageCode = 'en';
                                $parentId = $cat->id;
                                
                                // Get SubCategories by Parent Category ID
                                
                                $subcats = Category::transIn($languageCode)->where('parent_id', $parentId)->orderBy('lft')->get();

                                $count = count($subcats)/3;

                                $k = 0;
                                
                            @endphp
                            <div class="col-lg-9">
                            <div class="row">
                            <ul class="col-lg-4 col-md-12 col-xs-12 link-list">
                            @foreach($subcats as $subcat)
                                @php
                                    $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug];
                                    $k++;
                                @endphp
                                <li><a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">{{ $subcat->name }}</a></li>
                                @if($k > $count)
                                </ul>
                                <ul class="col-lg-4 col-md-12 col-xs-12 link-list">
                                @endif
                            @endforeach
                            </ul>
                            </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-xs-12">

                                <?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug]; ?>
                        <a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">
                            <img src="{{ \Storage::url($cat->picture) . getPictureVersion() }}" class="img-responsive" alt="img">
                
                        </a>

                            </div>
                            
                            
                          </div>
                        </div>
                      </div>
                    </li>


                    <li class="dropdown" style="display:none">
                        <!--<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">{{ strtoupper($cat->name) }}</a>-->

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                            {{ strtoupper($cat->name) }}
                        </a>

                        <ul class="dropdown-menu">
                            @php
                                //$subcats = $categories->where('parent_id', $cat->id);
                                //$subcats = Category::where('parent_id', $cat->id)->get();
                                //$subcats = $categories;
                                //var_dump($subcats);


                                $languageCode = 'en';
                                $parentId = $cat->id;
                                
                                // Get SubCategories by Parent Category ID
                                
                                $subcats = Category::where('parent_id', $parentId)->orderBy('lft')->get();


                                
                            @endphp
                            @foreach($subcats as $subcat)
                                @php
                                    $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug];
                                @endphp
                                <li tabindex="-1"><a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">{{ $subcat->name }}</a></li>
                            @endforeach
                        </ul>
                               
                    

                    </li>
                    @php
                        $i++;
                        if($i > 8):
                            break;
                        endif;
                    @endphp
                @endforeach
            @endif
          </ul>
        </nav>
    </div>
    @endif

</div>
<script>
function myFunction() {
    var x = document.getElementById("header-category");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

</script>
