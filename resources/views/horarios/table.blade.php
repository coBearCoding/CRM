<table id="tbl_horarios" class="table table-flush">
    <thead class="thead-light">
    <tr>
        <th scope="col"></th>
        <th scope="col">oferta Academica</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($results as $offer)
        <tr>
            <td><img onclick='abrir(this,{{ $offer->id }})' src='/images/details_open.png' style='cursor: pointer;'/></td>
            <td>{{ $offer->nombre }}</td>
        </tr>
    @endforeach
    </tbody>
</table>