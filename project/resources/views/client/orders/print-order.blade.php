<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Assitente de impressão</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="{{ mix('assets/css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <style>
        @media print {
            .not-print * {
                display: none;
            }
        }

        @media not print {
            .page {
                border: 1px solid grey;
                background-color: white;
                margin: 0 auto;
                width: 210mm;
                height: 297mm;
            }


            body {
                background-color: #1e1e1e;
                margin: 0;
            }

            .not-print {
                display: block;
            }

            #menu {
                height: 70px;
                padding: 10px;
                border-bottom: 1px solid #2d2d2d;
                margin-bottom: 13px;
                background: red;
                background: -webkit-linear-gradient(left top, #3a3a3a, #353535);
                background: -o-linear-gradient(bottom right, #3a3a3a, #353535);
                background: -moz-linear-gradient(bottom right, #3a3a3a, #353535);
                background: linear-gradient(to bottom right, #3a3a3a, #353535);
            }

            #menu .text-color-default {
                color: #e4e4e4;
            }

            #menu #print-message {
                font-family: Arial, sans-serif;
                font-size: 1.1em;
                text-align: center;
                position: absolute;
                margin-top: 20px;
            }

            #menu #print-button {
                float: right;
                margin-right: 70px;
                margin-top: 5px;
            }

            #menu button {
                text-decoration: none;
                font-family: sans-serif;
                font-size: 1.3em;
                background-color: transparent;
                border: none;
                cursor: pointer;
            }

            #print-info {
                float: left;
                font-family: Arial, sans-serif;
                position: absolute;
                margin-top: 12px;
                margin-left: 5px;
            }

            #menu > div {
                width: 33%;
                float: left;
                position: inherit;
            }
        }

        .border-header {
            border: 1px solid black;
            border-radius: 5px;
        }

    </style>

    <div class='not-print'>
        <div id='menu'>

            <div>
      <span class="text-color-default" id="print-message">
        Para imprimir aperte CTRL + P ou clique no botão ao lado.
      </span>
            </div>

            <button onclick="javascript:callPrintDialog()" class="text-color-default" id="print-button">
                <span class="fa fa-print fa-2x"> </span>
            </button>

            <span class="clearfix"></span>
        </div>
    </div>

    <script>
      window.onload = function () {
        window.print();
      };

      function callPrintDialog() {
        window.print();
      }
    </script>

</head>

<body>
<div class="page">
    <div class="print-area">
        <div class="row m-4 p-1 border-header">
            <div class="col-2">
                <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" alt="Logo">
            </div>
            <div class="col-10 p-3">
                <div class="row justify-content-center">
                    <strong> {{$order->company->corporate_name}}</strong>
                </div>
                <div class="row justify-content-center">
                    <strong>{{$order->company->cpf_cnpj}}</strong>
                </div>
            </div>
        </div>

        <div class="row m-4">
            <div class="col-12 p-3">
                <h5>Dados do cliente:</h5>
                <div class="row">
                    <div class="col-8 border-header"><strong> Cliente:</strong> {{$order->client->name}}</div>
                    <div class="col-4 border-header"><strong> CPF/CNPJ:</strong> {{$order->client->cpf_cnpj}}</div>
                </div>
                <h5 class="pt-1">Endereço de entrega:</h5>
                <div class="row">
                    <div class="col-6 border-header">{{$order->address->street_avenue}}
                        , {{$order->address->number}}  {{$order->address->complement ? ' - ' . $order->address->complement : ''}}</div>
                    <div class="col-3 border-header"><strong>Bairro:</strong> {{$order->address->district}}</div>
                    <div class="col-3 border-header"><strong>Municipio:</strong> {{$order->address->city->name}}</div>
                </div>

                <h5 class="pt-1">Dados dos produtos:</h5>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descrição</th>
                                <th>Quantidade</th>
                                <th>Valor unitário</th>
                                <th>Valor total</th>
                                <th>Confere</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($order->productItems as $productItem)
                                    <tr>
                                        <td>{{$productItem->product->code}}</td>
                                        <td>{{$productItem->product->title}}</td>
                                        <td>{{$productItem->quantity}}</td>
                                        <td>{{money($productItem->value_cents/100)}}</td>
                                        <td>{{money($productItem->total/100)}}</td>
                                        <td><i class="fa fa-square-o" aria-hidden="true"></i></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>

                    </div>
                    <h5 class="col-sm-3">Total do pedido:</h5>
                    <h5 class="col-sm-9 text-right">{{money($order->total/100)}}</h5>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
