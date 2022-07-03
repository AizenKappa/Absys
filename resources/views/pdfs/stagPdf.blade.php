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
    <h3>{{$data["stFullName"]}}<br>{{$data["groupe_name"]}}</h3>

   
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
    @if(count($data["nj_abs"]))
        @foreach($data["nj_abs"] as $abs)
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
    @if(count($data["just_abs"]))
        @foreach($data["just_abs"] as $abs)
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
    @if(count($data["absProf"]))
        @foreach($data["absProf"] as $abs)
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
</body>
</html>