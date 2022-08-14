<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>stagPdf</title>
</head>
<style>

    h3,h4{
        text-align: center
       
    }
    table{
        border-collapse: collapse;
        width:500px;  
        margin:auto
    }
    table ,th,td{
        border:1px solid black;
        text-align: center
    }
</style>
<body>
    <section style="max-height: 1090px;border:1px solid transparent">
        <div >
            <img src="{{public_path("/img/testHeader.png")}}" style="height:120px;">
        </div>
        <h3>{{$dataa["info"]["stFullName"]}}<br>{{ $dataa["info"]["groupe_name"] }}</h3>

    
    <table >
        <tr>
            <th colspan="6" style="padding:6px">Les absences Non justifiées</th>
        </tr>
        <tr style="border:1px solid black">
            <th>Date</th>
            <th>Debut</th>
            <th>Fin</th>
            <th>Durée</th>
            <th>Prof</th>
            <th>Type Seance</th>
        </tr>
    @if(count($dataa["info"]["nj_abs"]))
        @foreach($dataa["info"]["nj_abs"] as $abs)
        <tr>
            <td>{{$abs["date_abs"]}}</td>
            <td>{{substr($abs["duration"]["h_debut"],0,5)}}</td>
            <td>{{substr($abs["duration"]["h_fin"],0,5)}}</td>
            <td>{{$abs["nbAbs"]}} h</td>
            <td>{{$abs["prof"]["nom_prof"]}}</td>
            <td>{{$abs["seance"]}}</td>
        </tr>
        @endforeach
    @else
        <td colspan="6">Aucune Absence Non Justifée</td>
    @endif
    </table>
    <br>
    <br>
    <table >
        <tr>
            <th colspan="7" style="padding:6px">Les absences justifiées</th>
        </tr>
        <tr style="border:1px solid black">
            <th>Date</th>
            <th>Debut</th>
            <th>Fin</th>
            <th>Durée</th>
            <th>Prof</th>
            <th>Type Seance</th>
            <th>Motif</th>
        </tr>
    @if(count($dataa["info"]["just_abs"]))
        @foreach($dataa["info"]["just_abs"] as $abs)
        <tr>
            <td>{{$abs["date_abs"]}}</td>
            <td>{{substr($abs["duration"]["h_debut"],0,6)}}</td>
            <td>{{substr($abs["duration"]["h_fin"],0,6)}}</td>
            <td>{{$abs["nbAbs"]}} h</td>
            <td>{{$abs["prof"]["nom_prof"]}}</td>
            <td>{{$abs["seance"]}}</td>
            <td>{{$abs["motif"]}}</td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">Aucune Absence Justifiée</td>
        </tr>
    @endif
    </table>
    <br>
    <br>
    <table >
        <tr>
            <th colspan="2" style="padding:6px">Les absences Par Prof</th>
        </tr>
        <tr style="border:1px solid black">
            <th>Prof</th>
            <th>Heure Total</th>
           
        </tr>
    @if(count($dataa["info"]["absProf"]))
        @foreach($dataa["info"]["absProf"] as $abs)
        <tr>
           
            <td>{{$abs["nom"]}}</td>
            <td>{{$abs["hours"]}} h</td>
        </tr>
        @endforeach 
    @else
    <tr>
        <td colspan="2">Aucune Absence</td>
    </tr>
    @endif
    </table>
    <div style="position: absolute;top:960px;left:43px;">
        <img src="{{public_path("/img/footer.png")}}" style="height:90px;">
    </div>
    </section>
   
    
</body>
</html>