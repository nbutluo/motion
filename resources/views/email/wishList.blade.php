{{--<h1>hello {{$user}}, your verification code is : {{$code}}</h1>--}}
{{--<h3>hello {{$data['user']}}, your verification code is :{{$data['code']}} </h3>--}}
<h2>username：{{$data['user']}}</h2>
<h2>用户等级：{{$data['user_level']}}</h2>
@foreach($data['list'] as $product)
    <h5>产品名称：{{$product['product_name']}}</h5>
    <h5>产品sku：{{$product['product_sku']}}</h5>
    <h5>产品图片：<img src="{{$product['product_image']}}"></h5>
    @foreach($product['options'] as $option_key => $option_value)
        <h5>{{$option_key}}：</h5><span>{{$option_value}}</span>
    @endforeach
@endforeach
