@include('home.inc.spacer')
<div class="container">
	<div class="col-lg-12">
		
	
					<center>
					<h2>
						<span class="title-3">{{ t('Featured Categories') }} <span style="font-weight: bold;display:none;">{{ t('Category') }}</span></span>
						<?php $attr = ['countryCode' => config('country.icode')]; ?>
						
					</h2>
					</center>
			
			<div class="row">
			@if (isset($categories) and $categories->count() > 0)
				@foreach($categories as $key => $cat)
					


					<div class="col-sm-3" style="margin-bottom:20px;">
		                <div class="col-sm-12 thumbnail text-center">
		                    <?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug]; ?>
						<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">
							<img src="{{ \Storage::url($cat->picture) . getPictureVersion() }}" class="img-responsive" alt="img">
				
						</a>

		                    <div class="caption">
		                        <h4 style="font-size:20px;">{{ $cat->name }}</h4>
		                    </div>
		                </div>
		            </div>



				@endforeach
			@endif
			</div>
			<center>
			<div style="margin:20px;">
				<a href="{{ lurl(trans('routes.v-sitemap', $attr), $attr) }}" class="btn btn-primary">
					{{ t('View more') }}
				</a>
			</div>	
			</center>
		
	</div>
</div>

