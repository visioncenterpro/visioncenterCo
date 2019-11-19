<!DOCTYPE html>
<html lang="es">
    <head>
        <title>MSVision Center Pro</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="<?=base_url()?>dist/jquery/jquery.js"></script>
        <script type="text/javascript" src="<?=base_url()?>dist/JsBarcode/dist/jquery.qrcode.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>dist/js/qrcode.min.js"></script>
        <style>
            body {
              height: 21cm;
              width: 25cm;
                /* to centre page on screen */
                margin-left: auto;
                margin-right: auto;
                margin:auto;
                font-family: sans-serif !important;

            }
            table {
              border-collapse: collapse;
              border:none;
              margin: 5px;
            }
            table td, table th {
              border: 1px solid black;
            }
            @media print {
                body {
                    height: 21.59cm !important;
                    width: 27.94cm !important;
                    /* to centre page on screen*/
                    margin-left: auto !important;
                    margin-right: auto !important;
                    margin:auto !important;
                    font-family: sans-serif !important;
                    padding: 5px;
                }

                tr {
                  page-break-inside:avoid; page-break-after:auto
                }
                
            }
            
        </style>
    </head>
<body>
<div class="content-wrapper">
<section class="content">
  