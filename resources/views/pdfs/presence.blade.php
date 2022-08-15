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
            
    </style>
</head>
<body>
    
    @foreach($data as $data)
    <section style="padding:10px 25px 0px 25px;max-height: 1099px;height:1099">
            {{-- <div class="header">
                <img class="logo" src="{{public_path("/img/logo.png")}}"  style="height: 100%;" alt="">

                <img class="h" src="{{public_path("/img/header.png")}}" style="height: 100%;" alt="">
        </div>
        <div>
            <h5 style="text-align:center">{{$data["institut"]}}</h5>
        </div>
        <div style="width:100vw;height:34px;position: relative;">
            <table style="font-size:10px;position: absolute;right:30px;top:0">
                <tr>
                    <th ><p style="text-align: left">{{$data["dr"]}}</p></th>
                </tr>
                <tr>
                    <th><p style="text-align: left">{{$data["complexe"]}}</p></th>
                </tr>
            </table>

        </div> --}}
        <div >
            <img src="{{public_path("/img/testHeader.png")}}" style="height:120px;">
        </div>
        <div>
            <h6 style="text-align:center">{{$data["institut"]}}</h6>
        </div>
        <div style="width:100vw;position: relative;">
            <table style="font-size:10px;position: absolute;right:30px;top:0">
                <tr>
                    <th ><p style="text-align: left">{{$data["dr"]}}</p></th>
                </tr>
                <tr>
                    <th><p style="text-align: left">{{$data["complexe"]}}</p></th>
                </tr>
            </table>

        </div>
        <div>
            <table style="font-size:10px; width:100%">
                <tr>
                    <td>
                        <p class="text-center underline text-semibold">Type Examen : &#x25A2; CC N° ….......... &#x25A2; EFM (R/L) ; ….............................</p>
                        @if($data["type"] == "feuille_de_presence")
                        <p class="text-center underline text-semibold" >Feuille de Présence</p>
                        @endif
                        @if($data['type']=="pv_de_notes")
                        <p class="text-center underline text-semibold" >PV de Notes EFM</p>
                        @endif
                        @if($data['type']=="grille_de_notation")
                        <p class="text-center underline text-semibold" >Grille de Notation</p>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-bottom: 15px">
            <table style="width: 100%">
                <tr>
                    <td>
                        <table class="groupeInfo">
                            <tr>
                                <td>Filière:</td>
                                <td><strong>{{$data["filiere"]}}</strong></td>
                            </tr>
                            <tr>
                                <td>Groupe de formation:</td>
                                <td><strong>{{$data["groupe"]}}</strong></td>
                                
                            </tr>
                            <tr>
                                <td>Intitulé du Module:</td>
                                <td> ....................................</td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="classInfo">
                            <tr>
                                <td>Année de formation: <strong>{{$data["anneeScolaire"]}}</strong></td>
                            </tr>
                            <tr>
                                <td>Niveau: <strong>Technicien spécialiser</strong></td>
                            </tr>
                            <tr>
                                <td ><p> Inscrits:<strong>{{$data["nbre"]}}</strong> |Présents: .......</p><p>|Absents:....</p> </td>
                            </tr>
                           
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <table class="stTable" >
            <tr style="background-color: rgb(230, 224, 224)">
                <th>CEF</th>
                <th>Nom</th>
                <th>Prénom</th>
                @if($data["type"] == "feuille_de_presence")
                    <th>Emargement</th>
                    <th>Observation</th>
                @endif
                @if($data['type']=="pv_de_notes")
                    <th>Note <img src="{{public_path("/img/rect.png")}}" alt="selec"> 20 <img src="{{public_path("/img/rect.png")}}" alt="selec"> 40 </th>
                    <th>Observation</th>
                @endif
                @if($data['type']=="grille_de_notation")
                        <th style="font-size:11px;">Qst1</th>
                        <th style="font-size:11px;">Qst2</th>
                        <th style="font-size:11px;">Qst3</th>
                        <th style="font-size:11px;">Qst4</th>
                        <th style="font-size:11px;">Qst5</th>
                        <th style="font-size:11px;">Qst6</th>
                        <th style="font-size:11px;">Qst7</th>
                        <th style="font-size:11px;">Qst8</th>
                        <th style="font-size:11px;">Qst9</th>
                        <th style="font-size:11px;">Qst10</th>
                        <th style="font-size:11px;">Total</th>
                @endif
                
                
            </tr>
            @foreach($data["stagiaires"] as $st)
            <tr>
                <td>{{$st["id"]}}</td>
                <td>{{$st["nom_st"]}}</td>
                <td>{{$st["prenom_st"]}}</td>
                @if($data['type']=="grille_de_notation")
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @else
                    <td></td>
                    <td></td>
                @endif
                
            </tr>
            @endforeach
            
        </table>
        <strong style="font-size:12px;margin-top: 20px">Formateur &nbsp;&nbsp;&nbsp;:&nbsp;................................</strong>
        <div style="position: absolute;top:960px;left:43px;">
            <img src="{{public_path("/img/footer.png")}}" style="height:90px;">
        </div>
    </section>

    @endforeach
</body>
</html>