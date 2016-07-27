@if($cases)
<section class="customise-module">
    <div class="cm-title">
        <p class="p1">THEIR TRAVEL</p>
        <div class="cm-line"></div>
        <p class="p2">{{trans('customization.theirTrip')}}</p>
    </div>
    <div class="customise-module-main clear">
        <?php $count = count($cases); $i=1; ?>
        @foreach($cases as $case)
        <div class="tt-item{{$i++<$count ? ' tt-mr' : ''}}">
            <img src="@storageAsset($case->image)">
            <div class="tt-text">
                <p class="p1">{{trans('customization.totalCost')}}：{{$case->cost}}</p>
                <p class="p2">{{$case->content}}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif