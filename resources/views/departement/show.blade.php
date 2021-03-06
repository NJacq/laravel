<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>


        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            td {
                color: black;
                font-size: 20px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="title m-b-md">
                {{$title}} {{ $departement->nom_departement }}
            </div>
            <table class="table table-sm table-hover">                 
                <thead class="thead-dark">           
                    <tr>              
                        <th>Numéro de département</th>
                        <th>Numéro de région</th>
                        <th>Logements</th>
                        <th>Établissements</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>                         
                        <td>{{ $departement->code_departement }}</td>    
                        <td>{{ $departement->code_region }}</td>    
                        <td>{{ $departement->logements }}</td>    
                        <td>{{ $departement->etablissements }}</td>                       
                    </tr>
                </tbody> 
            </table>                         
        </div>
    </body>
</html>
