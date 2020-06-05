<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 25px;
            }
            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 40px;

                /** Extra personal styles **/
                border: 1px solid black;
                border-top: 0px;
                border-left: 0px;
                border-right: 0px;
                border-bottom: 1px solid black;
                text-align: left;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 30px; 

                text-align: center;
                line-height: 35px;
            }
            .page-number:before {
                content: "Pagina " counter(page);
            }
            thead th{
                font-size: 8px;
                border-bottom: 1px black solid;
                padding-bottom: 5px;
                text-align: left;
            }
            tbody td{
                font-size: 8px;
                padding-top: 5px;
                padding-bottom: 5px;
            }
            .err-blue {
                color: blue;
            }
            .err-red {
                color: red;
            }
            .err-green {
                color: green;
            }
            .group {
                font-style: 'italic';
                font-weight: bold;
                font-size: 14px;
            }
        }

        </style>
    </head>
    <body>
            <header>Reporte Inscripcion de Evento de {{ $tournament->description }}</header>
            <footer>
                <div class="page-number"></div> 
            </footer>
            <table width="100%" cellspacing="0" page-break-inside: auto>
                @foreach ($groups as $group)
                 <tr>
                    <td><div class="group">{{ $group->description }}<div></td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th>Correo</th>
                                    <th>Fecha Confirmacion</th>
                                    <th>Fecha Verificado</th>
                                    <th>Localizador</th>
                                    <th>Forma de Pago</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($group->users as $participant)
                                        <tr>
                                            <td>{{ Carbon\Carbon::createFromTimeStamp(strtotime($participant->register_date)) }}</td>
                                            <td>{{ $participant->user()->first()->name }} {{ $participant->user()->first()->last_name }}</td>
                                            <td>{{ $participant->user()->first()->phone_number }}</td>
                                            <td>{{ $participant->user()->first()->email }}</td>
                                            <td>{{ $participant->date_confirmed }}</td>
                                            <td>{{ $participant->date_verified }}</td>
                                            <td>{{ $participant->locator }}</td>
                                            <td>{{ $participant->payment()->first()->description }}</td>
                                            <td class={{$participant->status == 0 ? 'err-blue' : (($participant->status == 1 || $participant->status == 2) ? 'err-green' : 'err-red')}}>
                                                @if ($participant->status == 0)
                                                    Pendiente
                                                @endif
                                                @if ($participant->status == 1)
                                                    Aprobado
                                                @endif
                                                @if ($participant->status == 2)
                                                    Ganador
                                                @endif 
                                                @if ($participant->status == -1)
                                                    Rechazado
                                                @endif 
                                            </td>
                                        </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                @endforeach
            </table>
    </body>
</html>