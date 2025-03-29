@extends('dashboard.layout.dashboard')
@section('title')
<title>Cấu hình đăng nhập</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấu hình",
        "src" => route('generals.index'),
    ],
    [
        "title" => "Cấu hình đăng nhập",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<?php
$config = json_decode($detail->config, TRUE);
?>
<div class="content">
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-4">
            <label class="font-medium text-base mr-auto">Đăng nhập Facebook/Google/Zalo</label>
            <div class="mt-2">
                Thành viên có thể đăng nhập vào quản trị bằng tài khoản Facebook, Google hoặc Zalo
            </div>
        </div>
        <form class="col-span-12 lg:col-span-8" method="post" action="{{route('customer_socials.update',['id'=>$detail->id])}}">
            @csrf
            <div class="">
                <div class=" box">
                    <div id="formTaxConfig" class="p-5">
                        <div class="preview">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="col-span-2 md:col-span-2">
                                    <label for="vertical-form-1" class="form-label font-semibold">client_id_facebook</label>
                                    <?php echo Form::text('config[facebook][client_id_facebook]', !empty($config['facebook']) ? (!empty($config['facebook']['client_id_facebook']) ? $config['facebook']['client_id_facebook'] : '') : '', ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                                </div>
                                <div class="col-span-2 md:col-span-2">
                                    <label for="vertical-form-2" class="form-label font-semibold">client_secret_facebook</label>
                                    <?php echo Form::text('config[facebook][client_secret_facebook]', !empty($config['facebook']) ? (!empty($config['facebook']['client_secret_facebook']) ? $config['facebook']['client_secret_facebook'] : '') : '', ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                                </div>
                                <div class="col-span-2 md:col-span-2">
                                    <label for="vertical-form-2" class="form-label font-semibold">redirect_facebook</label>
                                    <?php echo Form::text('config[facebook][redirect_facebook]', !empty($config['facebook']) ? (!empty($config['facebook']['redirect_facebook']) ? $config['facebook']['redirect_facebook'] : '') : '', ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" box mt-3">
                    <div id="formTaxConfig" class="p-5">
                        <div class="preview">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="col-span-2 md:col-span-2">
                                    <label for="vertical-form-1" class="form-label font-semibold">client_id_google</label>
                                    <?php echo Form::text('config[google][client_id_google]', !empty($config['google']) ? (!empty($config['google']['client_id_google']) ? $config['google']['client_id_google'] : '') : '', ['class' => 'form-control w-full', 'placeholder' => '']); ?>

                                </div>
                                <div class="col-span-2 md:col-span-2">
                                    <label for="vertical-form-2" class="form-label font-semibold">client_secret_google</label>
                                    <?php echo Form::text('config[google][client_secret_google]', !empty($config['google']) ? (!empty($config['google']['client_secret_google']) ? $config['google']['client_secret_google'] : '') : '', ['class' => 'form-control w-full', 'placeholder' => '']); ?>

                                </div>
                                <div class="col-span-2 md:col-span-2">
                                    <label for="vertical-form-2" class="form-label font-semibold">redirect_google</label>
                                    <?php echo Form::text('config[google][redirect_google]', !empty($config['google']) ? (!empty($config['google']['redirect_google']) ? $config['google']['redirect_google'] : '') : '', ['class' => 'form-control w-full', 'placeholder' => '']); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" box mt-3">
                    <div id="formTaxConfig" class="p-5">
                        <div class="preview">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="col-span-2 md:col-span-2">
                                    <label for="vertical-form-1" class="form-label font-semibold">client_id_zalo</label>
                                    <?php echo Form::text('config[zalo][client_id_zalo]', !empty($config['zalo']) ? (!empty($config['zalo']['client_id_zalo']) ? $config['zalo']['client_id_zalo'] : '') : '', ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                                </div>
                                <div class="col-span-2 md:col-span-2">
                                    <label for="vertical-form-2" class="form-label font-semibold">client_secret_zalo</label>
                                    <?php echo Form::text('config[zalo][client_secret_zalo]', !empty($config['zalo']) ? (!empty($config['zalo']['client_secret_zalo']) ? $config['zalo']['client_secret_zalo'] : '') : '', ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                                </div>
                                <div class="col-span-2 md:col-span-2">
                                    <label for="vertical-form-2" class="form-label font-semibold">redirect_zalo</label>
                                    <?php echo Form::text('config[zalo][redirect_zalo]', !empty($config['zalo']) ? (!empty($config['zalo']['redirect_zalo']) ? $config['zalo']['redirect_zalo'] : '') : '', ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-5" type="submit">Cập nhập</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
@push('javascript')

@endpush