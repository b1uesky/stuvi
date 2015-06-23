{{ var_dump($seller_order) }}
<a href="{{ url('/order/seller/'.$seller_order['id']) }}">To schedule a pickup time</a>