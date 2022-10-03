<div>
    {{-- <ul>
        @foreach($opened as $trade)
            <li>{{ $trade->order_id }}</li>
        @endforeach
    </ul> --}}
    <table class="table">
        <tr>
            <th >Opened trades</th>
        </tr>
        <tr class="card-header bg-success text-white">
            <th></th>
            <th>   order_id   </th>
            <th>   symbol   </th>
            <th>   price   </th>
            <th>   qty   </th>
            <th>   leverage   </th>
            <th>   side   </th>
            <th>   rep_rate   </th>
        </tr>
        <tr >
            @php ($i = 1)
            @foreach ($opened as $trade)
            <td class=" bg-warning text-white">{{ $i++ }}</td>
            <td>{{ $trade->order_id}}</td>
            <td>{{ $trade->symbol }}</td>
            <td>{{ $trade->order_price}}</td>
            <td>{{ $trade->qty }}</td>
            <td>{{ $trade->leverage}}</td>
            <td>{{ $trade->side }}</td>
            <td>{{ $trade->rep_rate }}</td>
            @endforeach
            
        </tr>
    </table>
    <table class="table">
        <tr>
            <th>Closed trades</th>
        </tr>
        <tr class="card-header bg-success text-white">
            <th></th>
            <th>   order_id   </th>
            <th>   symbol   </th>
            <th>   price   </th>
            <th>   qty   </th>
            <th>   leverage   </th>
            <th>   side   </th>
            <th>   rep_rate   </th>
        </tr>
        @php ($i = 1)
            @foreach ($cloesd as $trade)
            <td class=" bg-warning text-white">{{ $i++ }}</td>
            <td>{{ $trade->order_id}}</td>
            <td>{{ $trade->symbol }}</td>
            <td>{{ $trade->price}}</td>
            <td>{{ $trade->qty }}</td>
            <td>{{ $trade->leverage}}</td>
            <td>{{ $trade->side }}</td>
            <td>{{ $trade->rep_rate }}</td>
            @endforeach
    </table>
</div>
