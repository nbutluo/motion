<div style="width:100%;text-align: center;float: left;margin:auto;">
    <div class="username" style="width:auto;float: left;margin-right:50px;">
        <p style="float: left;"><strong>name：{{$data['user']}}</strong></p>
    </div>
    <div class="email" style="width:auto;float: left;margin-right:50px;">
        <p style="float: left;"><strong>Email：{{$data['email']}}</strong></p>
    </div>
    <div class="country" style="width:auto;float: left;margin-right:50px;">
        <p style="float: left;"><strong>Country：{{$data['country']}}</strong></p>
    </div>
    <div class="company" style="width:auto;float: left;margin-right:50px;">
        <p style="float: left;"><strong>Company：{{$data['company']}}</strong></p>
    </div>
</div>
<div style="width:80%;text-align: center;float: left;">
    <div class="order-date" style="width:auto;float: left;margin-right:100px;">
        <p style="float: left;"><strong>Order Date：{{$data['order_date']}}</strong></p>
    </div>
    <div class="send" style="width:auto;float: left;">
        <p style="float: left;"><strong>Send to：{{$data['salesman']}}</strong></p>
    </div>
</div>
<div class="item" style="width:100%;float: left;">
    <p style="float: left;"><strong>Ordered Items:</strong></p>
</div>
<div style="width:60%;text-align: center;border:1px solid #aaa;float: left;">
    <div class="item-table">
        <table style="width:90%;margin:auto;">
            @foreach($data['list'] as $product)
                <tr style="height:40px;">
                    <td>Phone</td>
                    <td>Name</td>
                    <td>Frame Color</td>
                    <td>Desktop Size</td>
                    <td>Desk Frame Color</td>
                    <td>Numbers</td>
                </tr>
                <tr style="height:100px;">
                    <td><img src="{{$message->embed($product['product_image'])}}" width="70px" height="70px" alt="product_image"></td>
                    <td><span>{{$product['product_name']}}</span></td>
                    <td><span>@if (isset($product['option_color']) && $product['option_color'] != '')
                                {{$product['option_color']}}
                    @endif</span></td>
                    <td><span>@if (isset($product['option_size']) && $product['option_size'] != '')
                                {{$product['option_size']}}
                    @endif</span></td>
                    <td><span>@if (isset($product['desk_img']) && $product['desk_img'] != '')
                                <img src="{{$message->embed($product['desk_img'])}}" width="70px" height="70px" alt="desk_img">
                    @endif</span></td>
                    <td><span>{{$product['product_qty']}}</span></td>
                </tr>
                <tr>
                    <td colspan="6"><hr></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
