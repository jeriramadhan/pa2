@extends('layouts.user')
@section('head')

@endsection
@section('content')
    <h2 class="title-bar no-border-bottom">
        {{__("Booking History")}}
    </h2>
    @include('admin.message')
    <div class="booking-history-manager">
        <div class="tabbable">
            <ul class="nav nav-tabs ht-nav-tabs">
                <?php $status_type = Request::query('status'); ?>
                <li class="@if(empty($status_type)) active @endif">
                    <a href="{{url(app_get_locale()."/user/booking-history")}}">{{__("All Booking")}}</a>
                </li>
                @if(!empty($statues))
                    @foreach($statues as $status)
                        <li class="@if(!empty($status_type) && $status_type == $status) active @endif">
                            <a href="{{url(app_get_locale()."/user/booking-history?status=".$status)}}">{{booking_status_to_text($status)}}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
            @if(!empty($bookings) and $bookings->total() > 0)
                <div class="tab-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-booking-history">
                            <thead>
                            <tr>
                                <th width="2%">{{__("Type")}}</th>
                                <th>{{__("Title")}}</th>
                                <th class="a-hidden">{{__("Order Date")}}</th>
                                <th class="a-hidden">{{__("Execution Time")}}</th>
                                <th>{{__("Cost")}}</th>
                                <th class="a-hidden">{{__("Status")}}</th>
                                {{-- <th>{{__("Action")}}</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                            <td>{{$booking->object_model}}</td>
                            <td>@if(get_bookable_service_by_id($booking->object_model) and $service = $booking->service)
                                                    <a href="{{$service->getDetailUrl()}}" target="_blank">{{$service->title}}</a>
                                                @else
                                                    <a href="" target="_blank">{{$booking->address2}}</a>
                                                @endif</td>
                            <td>{{$booking->created_at}}</td>
                            <td>{{$booking->updated_at}}</td>
                            <td>{{format_money_main($booking->total_before_fees)}}</td>
                            <td>{{$booking->status}}</td>
                            {{-- <td>{{format_money_main($booking->total_before_fees)}}</td> --}}
                                {{-- @include(ucfirst($booking->object_model).'::frontend.bookingHistory.loop') --}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="bravo-pagination">
                        {{$bookings->appends(request()->query())->links()}}
                    </div>
                </div>
            @else
                {{__("No Booking History")}}
            @endif
        </div>
    </div>
@endsection
@section('footer')

@endsection
