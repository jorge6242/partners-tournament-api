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
        }

        </style>
    </head>
    <body>
            <header>Reporte de Inscripcion de Torneos</header>
            <footer>
                <div class="page-number"></div> 
            </footer>
            <table width="100%" cellspacing="0" page-break-inside: auto>
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
               <thead>
                <tbody>
                @foreach ($data as $element)
                    <tr>
                        <td>{{ Carbon\Carbon::createFromTimeStamp(strtotime($element->register_date)) }}</td>
                        <td>{{ $element->user()->first()->name }} {{ $element->user()->first()->last_name }}</td>
                        <td>{{ $element->user()->first()->phone_number }}</td>
                        <td>{{ $element->user()->first()->email }}</td>
                        <td>{{ $element->date_confirmed }}</td>
                        <td>{{ $element->date_verified }}</td>
                        <td>{{ $element->locator }}</td>
                        <td>{{ $element->payment()->first()->description }}</td>
                        <td>
                            @if ($element->status == 0)
                                Pendiente
                            @endif
                            @if ($element->status == 1)
                                Verificado
                            @endif 
                            @if ($element->status == -1)
                                Rechazado
                            @endif 
                        </td>
                    </tr> 
                @endforeach
                 <tbody>
            </table>
    </body>
</html>