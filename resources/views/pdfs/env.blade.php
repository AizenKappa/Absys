<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Feuille de presence</title>
    <style>
            *{
                padding:0;
                margin:0;
                box-sizing: border-box;
            }
        body{
            font-family: "dejavu sans", serif!important;
        }
       .header{
            margin-top: 10px;
        
            width:100vw;
            height: 60px;
            display: flex;
            justify-content: space-evenly
            

       }
       .logo{
       
            position: relative;
            top:10px;
            left:10px

       }

        .h{
           
            position: relative;
            top:10px;
            left:115px
        }
            .stTable, .stTable  td , .stTable th {
                border: 1px solid black;
            }
      
            .stTable{
               
                width:100%;
                border:1px solid black;
                border-collapse: collapse;
                margin-bottom: 5px;
            }
            .stTable tr th{
                font-weight:500;
                padding: 5px;
                padding-bottom:10px; 
            }

            .stTable tr td{
                font-size: 10px;
                padding: 2px;
                text-align: left;
               
            }
           
            .groupeInfo{
                border:none;
                font-size: 11px;
                
            }
            .classInfo{
                border:none;
                font-size: 11px;
                float: right;
            }
            .underline{
                text-decoration: underline;
            }
            .text-center{
                text-align:center
            }
            .text-semibold{
                font-weight: 700;
            }
            .clearfix::after {
                content: "";
                clear: both;
                display: table;
            }
            th{
                word-wrap: break-word;
                line-height: 30px;
            }
            .headerenv{
                width: 600px;
  
                border-top: 1px solid black;
                border-bottom: 4px solid black;
                border-left: 1px solid black;
                border-right: 4px solid black;
                /* padding: 15px 0; */
            }
            .infoenv{
                margin-left: 83px;
                font-weight: bold;
            }
            .contentheader{
                padding: 15px 0;
                margin: 1px;
                border-top: 4px solid black;
                border-bottom: 1px solid black;
                border-left: 4px solid black;
                border-right: 1px solid black;
            }

            
    </style>
</head>
<body>
    @foreach($data as $d)
    
    <section style="max-height: 1090px;height:1090px;border:1px solid transparent">
        <div id="envlope" style="text-align: center;margin-top:100px;">
                
                <h1 class="headerenv" style="display:inline-block;font-weight: bolder;font-size:25px;">
                    <div class="contentheader">Enveloppe Examen</div>
                </h1>

        </div>
        <h2 style="margin-top:45px;padding-left: 110px;font-weight: bolder;font-size:20px">L'enveloppe contient :</h2>
        <ul style="font-weight: bolder;font-size:18px;margin-top:35px;padding-left:165px;list-style-image:url('{{public_path("/img/listStyle.png")}}')">
            <li style="margin-bottom:5px;">Copies examen</li>
            <li style="margin-bottom:5px;">Enoncé Epreuve</li>
            <li style="margin-bottom:5px;">PV de note</li>
            <li style="margin-bottom:5px;">Détail notes</li>
            <li style="margin-bottom:5px;">Feuille de présence</li>
        </ul>
           
            <h2 style="font-weight:bolder;text-align: center;margin-top:55px;font-size:22px;margin-bottom:70px">EXAMEN DE FIN DE MODULE - 
                @if($d['module']['regional'] == 1)
                 <span>Régional</span>
                @else
                 <span>LOCAL</span>    
                @endif
            </h2>

        <div class="infoenv">
            <table style="font-size:15px;width: 600px;">
                <tr >
                    <th style="text-align: left"><p style="padding-right: 50px">Etablissement</p></th>
                    <th style="text-align: left">:&nbsp;CENTRE DE QUALIFICATION PROFESSIONNELLE ESSAFA CASABLANCA</th>
                </tr>
                <tr>
                    <th style="text-align: left">Niveau</th>
                    <th style="text-align: left">:&nbsp;{{$d['groupe']['filiere']['niveau']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left">Filière</th>
                    <th style="text-align: left">:&nbsp;{{$d['groupe']['filiere']['nom_fil']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left"> Module</th>
                    <th style="text-align: left">:&nbsp;{{$d['module']['code_module']}} - {{$d['module']['nom_module']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left">Groupe</th>
                    <th style="text-align: left">:&nbsp;{{$d['groupe']['nom_gp']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left">Type examen</th>
                    <th style="text-align: left">:&nbsp;</th>
                </tr>
            </table>
        </div>


        <h3 style="margin-left:100px; margin-top:60px">Formateur responsable : <strong>{{$d['prof']['nom_prof']}}</strong></h3>
        
    </section>
    <section style="max-height: 1090px;height:1090px;border:1px solid transparent">
        <div id="envlope" style="text-align: center;margin-top:100px;">
                
                <h1 class="headerenv" style="display:inline-block;font-weight: bolder;font-size:25px;">
                    <div class="contentheader">Enveloppe Examen</div>
                </h1>

        </div>
        <h2 style="margin-top:45px;padding-left: 110px;font-weight: bolder;font-size:20px">L'enveloppe contient :</h2>
        <ul style="font-weight: bolder;font-size:18px;margin-top:35px;padding-left:165px;list-style-image:url('{{public_path("/img/listStyle.png")}}')">
            <li style="margin-bottom:5px;">Copies examen</li>
            <li style="margin-bottom:5px;">Enoncé Epreuve</li>
            <li style="margin-bottom:5px;">PV de note</li>
            <li style="margin-bottom:5px;">Détail notes</li>
            <li style="margin-bottom:5px;">Feuille de présence</li>
        </ul>
      
            <h2 style="font-weight:bolder;text-align: center;margin-top:55px;font-size:22px;margin-bottom:70px">CONTROLE CONTINU N°1</h2>

        <div class="infoenv">
            <table style="font-size:15px;width: 600px;">
                <tr>
                    <th style="text-align: left"><p style="padding-right: 50px">Etablissement</p></th>
                    <th style="text-align: left">:&nbsp;CENTRE DE QUALIFICATION PROFESSIONNELLE ESSAFA CASABLANCA</th>
                </tr>
                <tr>
                    <th style="text-align: left">Niveau</th>
                    <th style="text-align: left">:&nbsp;{{$d['groupe']['filiere']['niveau']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left">Filière</th>
                    <th style="text-align: left">:&nbsp;{{$d['groupe']['filiere']['nom_fil']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left"> Module</th>
                    <th style="text-align: left">:&nbsp;{{$d['module']['code_module']}} - {{$d['module']['nom_module']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left">Groupe</th>
                    <th style="text-align: left">:&nbsp;{{$d['groupe']['nom_gp']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left">Type examen</th>
                    <th style="text-align: left">:&nbsp;</th>
                </tr>
            </table>
        </div>


        <h3 style="margin-left:100px; margin-top:60px">Formateur responsable : <strong>{{$d['prof']['nom_prof']}}</strong></h3>
        
    </section>
    <section style="max-height: 1090px;height:1090px;border:1px solid transparent">
        <div id="envlope" style="text-align: center;margin-top:100px;">
                
                <h1 class="headerenv" style="display:inline-block;font-weight: bolder;font-size:25px;">
                    <div class="contentheader">Enveloppe Examen</div>
                </h1>

        </div>
        <h2 style="margin-top:45px;padding-left: 110px;font-weight: bolder;font-size:20px">L'enveloppe contient :</h2>
        <ul style="font-weight: bolder;font-size:18px;margin-top:35px;padding-left:165px;list-style-image:url('{{public_path("/img/listStyle.png")}}')">
            <li style="margin-bottom:5px;">Copies examen</li>
            <li style="margin-bottom:5px;">Enoncé Epreuve</li>
            <li style="margin-bottom:5px;">PV de note</li>
            <li style="margin-bottom:5px;">Détail notes</li>
            <li style="margin-bottom:5px;">Feuille de présence</li>
        </ul>
      
            <h2 style="font-weight:bolder;text-align: center;margin-top:55px;font-size:22px;margin-bottom:70px">CONTROLE CONTINU N°2</h2>

        <div class="infoenv">
            <table style="font-size:15px;width: 600px;">
                <tr>
                    <th style="text-align: left">
                        <p style="padding-right: 50px">Etablissement</p>
                    </th>
                    <th style="text-align: left;">:&nbsp;CENTRE DE QUALIFICATION PROFESSIONNELLE ESSAFA CASABLANCA</th>
                </tr>
                <tr>
                    <th style="text-align: left">Niveau</th>
                    <th style="text-align: left">:&nbsp;{{$d['groupe']['filiere']['niveau']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left">Filière</th>
                    <th style="text-align: left">:&nbsp;{{$d['groupe']['filiere']['nom_fil']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left"> Module</th>
                    <th style="text-align: left">:&nbsp;{{$d['module']['code_module']}} - {{$d['module']['nom_module']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left">Groupe</th>
                    <th style="text-align: left">:&nbsp;{{$d['groupe']['nom_gp']}}</th>
                </tr>
                <tr>
                    <th style="text-align: left">Type examen</th>
                    <th style="text-align: left">:&nbsp;</th>
                </tr>
            </table>
        </div>


        <h3 style="margin-left:100px; margin-top:60px">Formateur responsable : <strong>{{$d['prof']['nom_prof']}}</strong></h3>
        
    </section>
    @endforeach
</body>
</html>