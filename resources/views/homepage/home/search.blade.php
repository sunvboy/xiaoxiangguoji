@extends('homepage.layout.home')
@section('content')
<main>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('homepage.index')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">查询运单号</li>
                    </ol>
                </nav>

            </div>
            <div class="col-md-12">
                <form method="GET" class="position-relative w-100">
                    <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" name="keyword" placeholder="请输入运单号" value="{{request()->get('keyword')}}">
                    <button type="submit" class="btn btn-light py-2 position-absolute top-0 end-0 mt-2 me-2">查询</button>
                </form>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="row">
                    @if(!empty($data))
                    @if(!empty($data['data']))
                    @if(!empty($data['data']['rows']))
                    @foreach($data['data']['rows'] as $item)
                    <div class="tracking-box col-md-6">
                        <div class="tracking-header">
                            {{ $item['code_cn'] }}
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered tracking-table">
                                <tbody>
                                    <tr>
                                        <td> 客户码</td>
                                        <td>{{ $item['customer_packaging'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>越南单号</td>
                                        <td class="important">{{ $item['code_vn'] }}</td>
                                    </tr>
                                    <tr>
                                        <td> 包号</td>
                                        <td class="important">{{ $item['code_packaging'] ?? '---' }}</td>
                                    </tr>
                                    <tr>
                                        <td>中国品名</td>
                                        <td>{{ $item['name_cn'] }} ({{ $item['name_vn'] }})</td>
                                    </tr>
                                    <tr>
                                        <td>产品数量</td>
                                        <td>{{ $item['quantity'] }}</td>
                                    </tr>
                                    <tr>
                                        <td> 价格</td>
                                        <td>{{number_format(rand(100000,300000)),0,',','.'}} VND</td>
                                    </tr>
                                    <tr>
                                        <td>重量</td>
                                        <td>{{ $item['weight'] }} kg</td>
                                    </tr>
                                    <tr>
                                        <td>数量件</td>
                                        <td>{{ $item['quantity_kien'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>备注</td>
                                        <td>{{ $item['fullname_new'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            @if(!empty($item['history']))
                            <!-- Timeline -->
                            <ul class="tracking-timeline">
                                @foreach($item['history'] as $h)
                                <li>
                                    <small>{{ $h['time'] }}</small>
                                    <b style="color: {{ $h['color'] ?? '#333' }};">{{ $h['title'] }}</b>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                    @endif
                    @endif

                </div>

            </div>

        </div>

    </div>
</main>
<style>
    .tracking-box {
        border-radius: 4px;
        overflow: hidden;
    }

    .tracking-header {
        background: #000;
        color: #fff;
        padding: 10px 15px;
        font-weight: bold;
        font-size: 16px;
    }

    .tracking-table td {
        padding: 8px;
        vertical-align: middle;
    }

    .tracking-table td:first-child {
        font-weight: bold;
        width: 35%;
        color: #333;
    }

    .tracking-table td:last-child {
        color: #555;
    }

    .tracking-table .important {
        color: red;
        font-weight: bold;
    }

    .tracking-timeline {
        border-left: 2px solid #ccc;
        margin: 15px 0 0 15px;
        padding-left: 15px;
        list-style: none;
        position: relative;
    }

    .tracking-timeline li {
        position: relative;
        margin-bottom: 15px;
    }

    .tracking-timeline li::before {
        content: "";
        position: absolute;
        width: 10px;
        height: 10px;
        background: #3498db;
        border-radius: 50%;
        left: -20px;
        top: 3px;
    }

    .tracking-timeline li b {
        display: block;
        margin-top: 3px;
    }
</style>

@endsection