<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Ação</th>
        </tr>
    </thead>

    <tbody>
        @foreach($habilidades as $hab)
            <tr>
                <td>{{$hab->name}}</td>
                <td>{{$hab->title}}</td>
                <td><i class="material-icons red-text small desassocia-habilidade mouse-pointer link-js" data-id="{{$hab->id}}">delete_forever</i></td>
            </tr>
        @endforeach
    </tbody>
</table>
