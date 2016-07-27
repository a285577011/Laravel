	<ul class="inbox-tabs nav nav-tabs padding-16 tab-size-bigger tab-space-1" id="inbox-tabs" style="padding-left:0px;">
            @foreach(config('tour.tour_step') as $k=>$v)
            												<li @if(Input::get('step')==$k)class="active"@endif>
													<a  href="{{route('admin::updateTour',['id'=>Input::get('id'),'step'=>$k])}}">
														<span class="bigger-110">{{$v}}</span>
													</a>
												</li>
            @endforeach
											</ul>