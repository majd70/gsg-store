<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document2</title>
</head>
<body>
    <h3> invoice #{{$order->number}}</h3>

    <table>

        <thead>
      <tr>
        <th> item</th>
        <th> price</th>

        <th> quantity</th>

        <th>total </th>

      </tr>
        </thead>

       <tbody>
        @foreach ($order->items as $item )

           <tr>
         <td> {{$item->product->name}}</td>
         <td> {{$item->price}} </td>
        <td>{{$item->quantity}} </td>
        <td>{{($item->quantity) * ($item->price)}} <td>
   </tr>
         @endforeach


       </tbody>

       <tr > {{$order->total}} </tr>




    </table>



    <h3> {{$order->number}}</h3>


</body>
</html>
