<!DOCTYPE html>
<html>
<head>
  <title>FACTURA # {{$order['order_id']}} </title>
  <style type="text/css">
    @page {
      size: 8.5in 6.5in;  /* width height */
    }
    body {
      margin-top: 1.0in;
      margin-right: 0.1in;
      margin-bottom: 1.0in;
      margin-left: 0.1in;
    }

    title {
      padding: 1em 2em;
      border-width: thin thick medium;
      color: black;
      background: white;
      border: solid;
    }

    td {
      border-bottom: 1px solid lightgray;
    }

    .label {
      border: solid 1px lightgray;
      padding: 5px;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }
  </style>
</head>

<body>
  <div class="page body">
    <div class="title">FACTURA # {{$order['order_id']}}</div>
      <table>
        <tr>
          <td>CLIENTE: {{$order['name']}}</td>
          <td style="text-align: right">NIT: {{$order['nit']}}</td>
        </tr>
        <tr>
          <td>EMAIL: {{$order['email']}}</td>
          <td style="text-align: right">NRC: {{$order['nrc']}}</td>
        </tr>
        <tr>
          <td>TELÉFONO: {{$order['phone_number']}}</td>
          <td style="text-align: right">DUI: {{$order['dui']}}</td>
        </tr>
      </table>

      <table>
          <tr>
            <th class="label">ID</th>
            <th class="label">UNIDADES</th>
            <th class="label">ITEM</th> class="label"
            <th class="label">PRECIO</th>
            <th class="label">VALOR</th>
          </tr>

          <!--OFFERS-->
          @if( isset($offers_items) )
                @foreach( $offers_items as $offer_item )
                  @if($offer_item[0]->id !== 1)
                      <tr>
                        <td style="text-align: center">{{$offer_item[0]->id}}</td>
                        <td style="text-align: center">{{$offer_item[0]->quantity}}</td>
                        <td style="width: 60%">{{$offer_item[0]->request}}</td>
                        <td style="text-align: center">{{ localMoneyFormat($offer_item[0]->charge) }}</td>
                        <td style="text-align: right">{{$offer_item[0]->value}}</td>
                      </tr>
                  @endif
                @endforeach
          @endif

          <!--PRODUCTS-->
          @if( isset($product_items) )
                @foreach ($product_items as  $product_item)
                  <tr>
                    <td style="text-align: center">{{$product_item['item_id']}}</td>
                    <td style="text-align: center">{{$product_item['quantity']}}</td>
                    <td style="width: 60%">{{$product_item['request']}}</td>
                    <td style="text-align: center">{{localMoneyFormat($product_item['charge'])}}</td>
                    <td style="text-align: right">{{localMoneyFormat($product_item['value'])}}</td>
                  </tr>
                @endforeach
          @endif
      </table>
      <table>
        <tr>
            <td style="text-align: right">TOTAL: {{ localMoneyFormat($order['amount']) }}</td>
        </tr>
      </table>
  </div>
</body>
</html>
