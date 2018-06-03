<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
  <?php
// Init.
$sForm = [
    'enableFormAreaCustomization' => '0',
    'hideTitles'                  => '0',
    'title'                       => t('Sell and buy near you'),
    'subTitle'                    => t('Simple, fast and efficient'),
    'bigTitleColor'               => '', // 'color: #FFF;',
    'subTitleColor'               => '', // 'color: #FFF;',
    'backgroundColor'             => '', // 'background-color: #444;',
    'backgroundImage'             => '', // null,
    'height'                      => '', // '450px',
    'parallax'                    => '0',
    'hideForm'                    => '0',
    'formBorderColor'             => '', // 'background-color: #333;',
    'formBorderSize'              => '', // '5px',
    'formBtnBackgroundColor'      => '', // 'background-color: #4682B4; border-color: #4682B4;',
    'formBtnTextColor'            => '', // 'color: #FFF;',
];

// Get Search Form Options
if (isset($searchFormOptions)) {
    if (isset($searchFormOptions['enable_form_area_customization']) and !empty($searchFormOptions['enable_form_area_customization'])) {
        $sForm['enableFormAreaCustomization'] = $searchFormOptions['enable_form_area_customization'];
    }
    if (isset($searchFormOptions['hide_titles']) and !empty($searchFormOptions['hide_titles'])) {
        $sForm['hideTitles'] = $searchFormOptions['hide_titles'];
    }
    if (isset($searchFormOptions['title_' . config('app.locale')]) and !empty($searchFormOptions['title_' . config('app.locale')])) {
        $sForm['title'] = $searchFormOptions['title_' . config('app.locale')];
        $sForm['title'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['title']);
        if (str_contains($sForm['title'], '{count_ads}')) {
            try {
                $countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
            } catch (\Exception $e) {
                $countPosts = 0;
            }
            $sForm['title'] = str_replace('{count_ads}', $countPosts, $sForm['title']);
        }
        if (str_contains($sForm['title'], '{count_users}')) {
            try {
                $countUsers = \App\Models\User::count();
            } catch (\Exception $e) {
                $countUsers = 0;
            }
            $sForm['title'] = str_replace('{count_users}', $countUsers, $sForm['title']);
        }
    }
    if (isset($searchFormOptions['sub_title_' . config('app.locale')]) and !empty($searchFormOptions['sub_title_' . config('app.locale')])) {
        $sForm['subTitle'] = $searchFormOptions['sub_title_' . config('app.locale')];
        $sForm['subTitle'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['subTitle']);
        if (str_contains($sForm['subTitle'], '{count_ads}')) {
            try {
                $countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
            } catch (\Exception $e) {
                $countPosts = 0;
            }
            $sForm['subTitle'] = str_replace('{count_ads}', $countPosts, $sForm['subTitle']);
        }
        if (str_contains($sForm['subTitle'], '{count_users}')) {
            try {
                $countUsers = \App\Models\User::count();
            } catch (\Exception $e) {
                $countUsers = 0;
            }
            $sForm['subTitle'] = str_replace('{count_users}', $countUsers, $sForm['subTitle']);
        }
    }
    if (isset($searchFormOptions['parallax']) and !empty($searchFormOptions['parallax'])) {
        $sForm['parallax'] = $searchFormOptions['parallax'];
    }
    if (isset($searchFormOptions['hide_form']) and !empty($searchFormOptions['hide_form'])) {
        $sForm['hideForm'] = $searchFormOptions['hide_form'];
    }
}

// Country Map status (shown/hidden)
$showMap = false;
if (file_exists(config('larapen.core.maps.path') . config('country.icode') . '.svg')) {
    if (isset($citiesOptions) and isset($citiesOptions['show_map']) and $citiesOptions['show_map'] == '1') {
        $showMap = true;
    }
}
?>
@if (isset($sForm['enableFormAreaCustomization']) and $sForm['enableFormAreaCustomization'] == '1')
    
    @if (isset($firstSection) and !$firstSection)
        <div class="h-spacer"></div>
    @endif
    
    <?php $parallax = (isset($sForm['parallax']) and $sForm['parallax'] == '1') ? 'parallax' : ''; ?>
    <div class="wide-intro {{ $parallax }}">
        <div class="dtable hw100">
            <div class="dtable-cell hw100">
                <div class="container text-center">
                    <br />
                    @if ($sForm['hideTitles'] != '1')
                        <h1 class="intro-title animated fadeInDown"> {{ $sForm['title'] }} </h1>
                        <p class="sub animateme fittext3 animated fadeIn">
                            {!! $sForm['subTitle'] !!}
                        </p>
                    @endif
                    
                    @if ($sForm['hideForm'] != '1')
                        <div class="row search-row fadeInUp">
                            <?php $attr = ['countryCode' => config('country.icode')]; ?>
                            <form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET">
                                <div class="col-lg-4 col-sm-4 search-col relative">
                                    <i class="icon-docs icon-append"></i>
                                    <input type="text" name="q" class="form-control keyword has-icon" placeholder="{{ t('What?') }}" value="">
                                </div>
                                <div class="col-lg-3 col-sm-3 search-col relative locationicon">
                                    <i class="icon-location-2 icon-append"></i>
                                    <input type="hidden" id="lSearch" name="l" value="">

                                    @if ($showMap)
                                        <select name="location" onChange="myNewFunction(this);" id="locSearch" class="form-control keyword has-icon locinput searchtag-input tooltipHere" style="height:45px">
                                            @if (isset($countryCols))
                                                @foreach ($countryCols as $key => $col)   
                                                    @foreach ($col as $k => $country)
                                                        <?php
                                                        $countryLang = App\Helpers\Localization\Country::getLangFromCountry($country->get('languages'));
                                                        ?>
                                                        <option  {{ config('country.name', 0)==$country->get('name') ? 'selected' : ''}} title="{{ url($countryLang->get('abbr') . '?d=' . $country->get('code')) }}" value="{{ str_limit($country->get('name'), 100) }}">{{ str_limit($country->get('name'), 100) }}</option>
                                                    @endforeach  
                                                @endforeach
                                            @endif
                                        </select>       

                                        <!-- <input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
                                               placeholder="{{ t('Senegal') }}" value="" title="" data-placement="bottom"
                                               data-toggle="tooltip" type="button"
                                               data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}"> -->
                                    @else
                                        <select name="location" onChange="myNewFunction(this);" id="locSearch" class="form-control keyword has-icon locinput searchtag-input tooltipHere" style="height:45px">
                                            @if (isset($countryCols))
                                                @foreach ($countryCols as $key => $col)   
                                                    @foreach ($col as $k => $country)
                                                        <?php
                                                        $countryLang = App\Helpers\Localization\Country::getLangFromCountry($country->get('languages'));
                                                        ?>
                                                        <option  {{ config('country.name', 0)==$country->get('name') ? 'selected' : ''}} title="{{ url($countryLang->get('abbr') . '?d=' . $country->get('code')) }}" value="{{ str_limit($country->get('name'), 100) }}">{{ str_limit($country->get('name'), 100) }}</option>
                                                    @endforeach  
                                                @endforeach
                                            @endif
                                        </select>       
                                        <!-- <input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon"
                                               placeholder="{{ t('Senegal') }}" value=""> -->
                                    @endif
                                </div>

                                <div class="col-lg-3 col-sm-3 search-col relative">
                                    @if (isset($bcTab) and count($bcTab) > 0)
                                        @foreach($bcTab as $key => $value)
                                            <?php $value = collect($value); ?>
                                            @if ($value->has('position') and $value->get('position') > count($bcTab)+1)
                                                <li class="form-control keyword has-icon active">
                                                    {!! $value->get('name') !!}
                                                    &nbsp;
                                                    @if (isset($city) or isset($admin))
                                                        <a href="#browseAdminCities" id="dropdownMenu1" data-toggle="modal"> <span class="caret"></span> </a>
                                                    @endif
                                                </li>
                                            @else
                                                <li><a href="{{ $value->get('url') }}">{!! $value->get('name') !!}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                    <i class="icon-docs icon-append"></i>
                                </div>
                                <div class="col-lg-2 col-sm-2 search-col">
                                    <button class="btn btn-primary btn-search btn-block">
                                        <i class="icon-search"></i> <strong>{{ t('Find') }}</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                
                </div>
            </div>
        </div>
    </div>
    
@else
    
    @include('home.inc.spacer')
    <div class="container">
        <div class="intro">
            <div class="dtable hw100">
                <div class="dtable-cell hw100">
                    <div class="container text-center">
                        <div class="row search-row fadeInUp">
                            <?php $attr = ['countryCode' => config('country.icode')]; ?>
                            <form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 search-col relative">
                                    <i class="icon-docs icon-append"></i>
                                    <input type="text" name="q" class="form-control keyword has-icon" placeholder="{{ t('What?') }}" value="">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 search-col relative locationicon">
                                    <i class="icon-location-2 icon-append"></i>
                                    <input type="hidden" id="lSearch" name="l" value="">
                                    @if ($showMap)
                                        <select name="location" onChange="myNewFunction(this);" id="locSearch" class="form-control keyword has-icon locinput searchtag-input tooltipHere" style="height:45px">
                                            @if (isset($countryCols))
                                                @foreach ($countryCols as $key => $col)   
                                                    @foreach ($col as $k => $country)
                                                        <?php
                                                        $countryLang = App\Helpers\Localization\Country::getLangFromCountry($country->get('languages'));
                                                        ?>
                                                        <option  {{ config('country.name', 0)==$country->get('name') ? 'selected' : ''}} title="{{ url($countryLang->get('abbr') . '?d=' . $country->get('code')) }}" value="{{ str_limit($country->get('name'), 100) }}">{{ str_limit($country->get('name'), 100) }}</option>
                                                    @endforeach  
                                                @endforeach
                                            @endif
                                        </select>       
                                        <!-- <input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
                                               placeholder="{{ t('Senegal') }}" value="" title="" data-placement="bottom"
                                               data-toggle="tooltip" type="button"
                                               data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}"> -->
                                    @else
                                        <select name="location" onChange="myNewFunction(this);" id="locSearch" class="form-control keyword has-icon locinput searchtag-input tooltipHere" style="height:45px">
                                            @if (isset($countryCols))
                                                @foreach ($countryCols as $key => $col)   
                                                    @foreach ($col as $k => $country)
                                                        <?php
                                                        $countryLang = App\Helpers\Localization\Country::getLangFromCountry($country->get('languages'));
                                                        ?>
                                                        <option  {{ config('country.name', 0)==$country->get('name') ? 'selected' : ''}} title="{{ url($countryLang->get('abbr') . '?d=' . $country->get('code')) }}" value="{{ str_limit($country->get('name'), 100) }}">{{ str_limit($country->get('name'), 100) }}</option>
                                                    @endforeach  
                                                @endforeach
                                            @endif
                                        </select>       
<!--                                         <input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon"
                                               placeholder="{{ t('Senegal') }}" value=""> -->
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-3 col-sm-3 col-xs-12 search-col relative">
                                    @if (isset($bcTab) and count($bcTab) > 0)
                                        @foreach($bcTab as $key => $value)
                                            <?php $value = collect($value); ?>
                                            @if ($value->has('position') and $value->get('position') > count($bcTab)+1)
                                                <li class="form-control keyword has-icon active">
                                                    {!! $value->get('name') !!}
                                                    &nbsp;
                                                    @if (isset($city) or isset($admin))
                                                        <a href="#browseAdminCities" id="dropdownMenu1" data-toggle="modal"> <span class="caret"></span> </a>
                                                    @endif
                                                </li>
                                            @else
                                                <li><a href="{{ $value->get('url') }}">{!! $value->get('name') !!}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                    <i class="icon-docs icon-append"></i>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 search-col">
                                    <button class="btn btn-primary btn-search btn-block">
                                        <i class="icon-search"></i> <strong>{{ t('Find') }}</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endif
@section('modal_location')
    @include('layouts.inc.modal.location')
@endsection
<script>
    function myNewFunction(sel)
    {
        // console.log(sel.options[sel.selectedIndex].title);
        var url = sel.options[sel.selectedIndex].title;
        window.location.href = url; // redirect
    }
</script>

