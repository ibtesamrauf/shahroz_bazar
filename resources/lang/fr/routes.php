<?php
/**
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

$routesTab = [
    /*
    |--------------------------------------------------------------------------
    | Routes Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the global website.
    |
    */
	
	// Countries
    'countries' => 'pays',
	
	// Auth
    'login'    => 'connexion',
    'logout'   => 'deconnexion',
    'register' => 'inscription',
	
	// Post
	'post'   => '{slug}/{id}.html',
	'v-post' => ':slug/:id.html',
	
	// Page
    'page'   => 'page/{slug}.html',
    't-page' => 'page',
    'v-page' => 'page/:slug.html',
	
	// Contact
    'contact' => 'contact.html',
];

if (config('larapen.core.multiCountriesWebsite')) {
    // Sitemap
    $routesTab['sitemap'] = '{countryCode}/plan-du-site.html';
    $routesTab['v-sitemap'] = ':countryCode/plan-du-site.html';

    // Latest Ads
    $routesTab['search'] = '{countryCode}/recherche';
    $routesTab['t-search'] = 'recherche';
    $routesTab['v-search'] = ':countryCode/recherche';

    // Search by Sub-Category
    $routesTab['search-subCat'] = '{countryCode}/categorie/{catSlug}/{subCatSlug}';
    $routesTab['t-search-subCat'] = 'categorie';
    $routesTab['v-search-subCat'] = ':countryCode/categorie/:catSlug/:subCatSlug';

    // Search by Category
    $routesTab['search-cat'] = '{countryCode}/categorie/{catSlug}';
    $routesTab['t-search-cat'] = 'categorie';
    $routesTab['v-search-cat'] = ':countryCode/categorie/:catSlug';

    // Search by Location
    $routesTab['search-city'] = '{countryCode}/annonces/{city}/{id}';
    $routesTab['t-search-city'] = 'annonces';
    $routesTab['v-search-city'] = ':countryCode/annonces/:city/:id';

    // Search by User
    $routesTab['search-user'] = '{countryCode}/vendeurs/{id}/annonces';
    $routesTab['t-search-user'] = 'vendeurs';
    $routesTab['v-search-user'] = ':countryCode/vendeurs/:id/annonces';
	
	// Search by Username
	$routesTab['search-username'] = '{countryCode}/profile/{username}';
	$routesTab['t-search-username'] = 'profile';
	$routesTab['v-search-username'] = ':countryCode/profile/:username';
	
	// Search by Tag
	$routesTab['search-tag'] = '{countryCode}/mot-cle/{tag}';
	$routesTab['t-search-tag'] = 'mot-cle';
	$routesTab['v-search-tag'] = ':countryCode/mot-cle/:tag';
} else {
    // Sitemap
    $routesTab['sitemap'] = 'plan-du-site.html';
    $routesTab['v-sitemap'] = 'plan-du-site.html';

    // Latest Ads
    $routesTab['search'] = 'recherche';
    $routesTab['t-search'] = 'recherche';
    $routesTab['v-search'] = 'recherche';

    // Search by Sub-Category
    $routesTab['search-subCat'] = 'categorie/{catSlug}/{subCatSlug}';
    $routesTab['t-search-subCat'] = 'categorie';
    $routesTab['v-search-subCat'] = 'categorie/:catSlug/:subCatSlug';

    // Search by Category
    $routesTab['search-cat'] = 'categorie/{catSlug}';
    $routesTab['t-search-cat'] = 'categorie';
    $routesTab['v-search-cat'] = 'categorie/:catSlug';

    // Search by Location
    $routesTab['search-city'] = 'annonces/{city}/{id}';
    $routesTab['t-search-city'] = 'annonces';
    $routesTab['v-search-city'] = 'annonces/:city/:id';

    // Search by User
    $routesTab['search-user'] = 'vendeurs/{id}/annonces';
    $routesTab['t-search-user'] = 'vendeurs';
    $routesTab['v-search-user'] = 'vendeurs/:id/annonces';
	
	// Search by Username
	$routesTab['search-username'] = 'profile/{username}';
	$routesTab['v-search-username'] = 'profile/:username';
	
	// Search by Tag
	$routesTab['search-tag'] = 'mot-cle/{tag}';
	$routesTab['t-search-tag'] = 'mot-cle';
	$routesTab['v-search-tag'] = 'mot-cle/:tag';
}

// Posts Permalink Collection
$vPost = config('larapen.core.permalink.posts');

// Posts Permalink
if (isset($vPost[config('settings.seo.posts_permalink', '{slug}/{id}')])) {
	$routesTab['post'] = config('settings.seo.posts_permalink', '{slug}/{id}') . config('settings.seo.posts_permalink_ext', '');
	$routesTab['v-post'] = $vPost[config('settings.seo.posts_permalink', '{slug}/{id}')] . config('settings.seo.posts_permalink_ext', '');
}

return $routesTab;
