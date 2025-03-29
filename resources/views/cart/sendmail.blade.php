<?php
$id = $data['id'];
$detail = \App\Models\Order::with('city_name')->with('district_name')->with('ward_name')->find($id);

use App\Components\System;

$system = new System();
$fcSystem = $system->fcSystem();
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" dir="ltr" align="center" style="background-color:#fff;font-size:16px">
    <tb>
        <tr>
            <td align="left" valign="top" style="margin:0;padding:0">
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="720" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td>
                                <div style="border:2px solid #2f5acf;padding:8px 16px;border-radius:16px;margin-top:16px">
                                    <p style="margin:10px 0 20px;font-weight:bold;font-size:20px">
                                        {{trans('index.InformationLine')}}
                                        <a href="javascript:void(0)">
                                            #{{$detail->code}}
                                        </a>
                                        <span style="font-weight:normal">({{$detail->created_at}})</span>
                                    </p>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td valign="top">
                                                    <p style="margin:10px 0;font-weight:bold">
                                                        <b>{{trans('index.AccountInformation')}}</b>
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        <b>{{trans('index.Fullname')}}:</b> {{$detail->fullname}}
                                                    </p>
                                                    @if($detail->email)
                                                    <p style="margin:10px 0">
                                                        <b>Email:</b> <a href="mailto:{{$detail->email}}" target="_blank">{{$detail->email}}</a>
                                                    </p>
                                                    @endif
                                                    <p style="margin:10px 0">
                                                        <b>{{trans('index.Phone')}}:</b> {{$detail->phone}}
                                                    </p>
                                                </td>
                                                <td valign="top">
                                                    <p style="margin:10px 0;font-weight:bold">
                                                        <b>{{trans('index.DeliveryAddress2')}}</b>
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        <b>{{trans('index.Fullname')}}:</b> {{$detail->fullname}}
                                                    </p>
                                                    @if($detail->email)
                                                    <p style="margin:10px 0">
                                                        <b>Email:</b> <a href="mailto:{{$detail->email}}" target="_blank">{{$detail->email}}</a>
                                                    </p>
                                                    @endif
                                                    <p style="margin:10px 0">
                                                        <b>{{trans('index.Phone')}}:</b> {{$detail->phone}}
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        <b>{{trans('index.Address')}}:</b> {{$detail->address}}
                                                    </p>
                                                    @if(!empty($detail->ward_name))
                                                    <p>
                                                        <b>{{trans('index.Ward')}}:</b>
                                                        {{!empty($detail->ward_name)?$detail->ward_name->name:''}}
                                                    </p>
                                                    @endif
                                                    @if(!empty($detail->district_name))
                                                    <p>
                                                        <b>{{trans('index.District')}}:</b>
                                                        {{!empty($detail->district_name)?$detail->district_name->name:''}}
                                                    </p>
                                                    @endif
                                                    @if(!empty($detail->city_name))
                                                    <p>
                                                        <b>{{trans('index.City')}}:</b>
                                                        {{!empty($detail->city_name)?$detail->city_name->name:''}}
                                                    </p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <p style="margin:10px 0">
                                                        <b>{{trans('index.PaymentMethods')}}:</b>
                                                        {{config('cart')['payment'][$detail->payment]}}
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <?php $cart = json_decode($detail->cart, TRUE); ?>
                        <?php $coupon = json_decode($detail->coupon, TRUE); ?>
                        <tr>
                            <td>
                                <div style="border:2px solid #2f5acf;padding:8px 16px;border-radius:16px;margin-top:16px">
                                    <p style="margin:10px 0 20px;font-weight:bold;font-size:20px">
                                        {{trans('index.OrderDetails')}}
                                    </p>
                                    <table class="m_-8304563403915632023table" cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px">
                                        <thead>
                                            <tr>
                                                <th width="150px" style="text-align:left">{{trans('index.TitleProduct')}}</th>
                                                <th>{{trans('index.Amount')}}</th>
                                                <th width="150px">{{trans('index.Price')}}</th>
                                                <th style="text-align:right">{{trans('index.intomoney')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($cart)
                                            @foreach( $cart as $k=>$v)
                                            <?php
                                            $slug = !empty($v['slug']) ? route('routerURL', ['slug' => $v['slug']]) : 'javascript:void(0)';
                                            $unit = !empty($v['unit']) ? $v['unit'] : '';
                                            $options = !empty($v['options']) ? (!empty($v['options']['title_version']) ? $v['options']['title_version'] : '') : '';
                                            ?>
                                            <tr>
                                                <td style="text-align:left">
                                                    <p style="margin:5px 0 0">
                                                        <a href="{{$slug}}" target="_blank">{{$v['title']}}</a>
                                                    </p>
                                                    @if(!empty($options))
                                                    <p style="margin-top:3px">
                                                        <span style="font-size:12px;display:block">
                                                            {{$options}}
                                                        </span>
                                                    </p>
                                                    @endif
                                                </td>
                                                <td style="text-align:center">
                                                    {{$v['quantity']}} {{$unit}}
                                                </td>
                                                <td style="text-align:center">
                                                    <b>
                                                        {{number_format( $v['price'],0,'.',',')}}₫
                                                    </b>

                                                </td>
                                                <td style="text-align:right">
                                                    {{number_format($v['quantity'] * $v['price'],0,'.',',')}}
                                                    ₫
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">
                                                    <b>{{trans('index.Provisional')}}</b>
                                                </td>
                                                <td style="text-align:right">
                                                    {{ number_format($detail->total_price) }}₫
                                                </td>
                                            </tr>
                                            @if (isset($coupon))
                                            @foreach ($coupon as $v)
                                            <tr>
                                                <td colspan="3">
                                                    <b>{{trans('index.Discount')}}</b>
                                                </td>
                                                <td style="text-align:right">
                                                    - {{number_format($v['price'])}}₫
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="3"><b>{{trans('index.ShippingUnit')}}</b></td>
                                                <td style="text-align:right">
                                                    {{ $detail->title_ship }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><b>{{trans('index.TransportFee')}}</b></td>
                                                <td style="text-align:right">
                                                    {{ number_format($detail->fee_ship) }}₫
                                                </td>
                                            </tr>
                                            @if($detail->payment == 'wallet')
                                            <tr class="total_payment">
                                                <td colspan="3">
                                                    {{trans('index.TotalAmount')}}
                                                </td>
                                                <td colspan="2" class="text-right">
                                                    {{ number_format($detail->total_price-$detail->total_price_coupon+$detail->fee_ship) }}₫
                                                </td>
                                            </tr>
                                            <tr class="total_payment">
                                                <td colspan="3">
                                                    {{trans('index.Paid')}}
                                                </td>
                                                <td colspan="2" class="text-right">
                                                    {{ number_format($detail->wallet) }}₫
                                                </td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td colspan="3">
                                                    <b> {{trans('index.TotalMoneyPayment')}}</b>
                                                </td>
                                                <td style="text-align:right">
                                                    <b>
                                                        {{ number_format($detail->total_price-$detail->total_price_coupon+$detail->fee_ship-$detail->wallet) }}₫
                                                    </b>
                                                </td>
                                            </tr>

                                        </tfoot>
                                    </table>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:20px;font-size:14px;line-height:24px">
                                        <tbody>
                                            <tr>

                                                <td>
                                                    <p style="font-weight:bold;">
                                                        {{trans('index.NeedImmediateAssistance')}}
                                                    </p>
                                                    {{trans('index.JustFeedbackTo')}} <a href="mailto:{{$fcSystem['contact_email']}}" style="text-decoration:none;color:black" target="_blank">
                                                        <b>
                                                            {{$fcSystem['contact_email']}}
                                                        </b>
                                                    </a>
                                                    , {{trans('index.OrCallThePhoneNumber')}} <a href="tel:{{$fcSystem['contact_hotline']}}" style="text-decoration:none;color:black" target="_blank">
                                                        <b>{{$fcSystem['contact_hotline']}}</b>
                                                    </a> {{trans('index.OrInbox')}}
                                                    {{$fcSystem['homepage_company']}} <a href="{{$fcSystem['social_facebook']}}" style="text-decoration:none;color:black" target="_blank">
                                                        <b>
                                                            {{trans('index.here')}}
                                                        </b>
                                                    </a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="720" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td style="font-size:14px;text-align:center;padding:16px 0;line-height:20px">
                                Hotline: <a href="tel:{{$fcSystem['contact_hotline']}}" style="color:black;text-decoration:none" target="_blank">{{$fcSystem['contact_hotline']}}</a> |
                                CSKH: <a href="mailto:{{$fcSystem['contact_email']}}" style="color:black;text-decoration:none" target="_blank">{{$fcSystem['contact_email']}}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tb ody>
</table>